import express from 'express';
import helmet from 'helmet';
import morgan from 'morgan';
import compression from 'compression';
import rateLimit from 'express-rate-limit';
import session from 'express-session';
import { randomBytes, randomUUID } from 'node:crypto';
import { fileURLToPath } from 'node:url';
import { gerarHash, verificarSenha } from './services/senhas.js';
import { validar } from './services/validacao.js';
import { comprar, falha } from './services/compra.js';
import { Mercado } from './models/Mercado.js';
import { Produto } from './models/Produto.js';
import { criarFuncionario } from './models/Funcionario.js';

export function criarApp(banco, { logs = true } = {}) {
  const app = express();
  app.disable('x-powered-by');
  app.set('view engine', 'ejs');
  app.set('views', fileURLToPath(new URL('./views/app/', import.meta.url)));
  app.use(helmet({ contentSecurityPolicy: { directives: { 'upgrade-insecure-requests': null } } }));
  app.use(compression());
  if (logs) app.use(morgan('dev'));
  app.use(express.static(fileURLToPath(new URL('./assets/', import.meta.url))));
  app.use(express.urlencoded({ extended: false, limit: '32kb' }));
  app.use(express.json({ limit: '32kb' }));
  // Adapta os nomes dos campos fornecidos, sem redesenhar os formulários.
  app.use((req, res, next) => {
    if (req.body) {
      const aliases = { inputEmailLog: 'usuario', inputSenhaLog: 'senha', inputNomeProd: 'nome', inputFabricanteProd: 'marca', inputDescricaoProd: 'descricao', inputValorProd: 'preco', inputQtdProd: 'quantidade', inputNomeFunc: 'nome', inputSobrenomeFunc: 'sobrenome', inputCPFFunc: 'cpf', inputDataNascFunc: 'dataNascimento', inputTelefoneFunc: 'telefone', inputCargoFunc: 'cargo', inputSalarioFunc: 'salario', inputEmailFunc: 'email', inputSenha: 'senha' };
      for (const [original, campo] of Object.entries(aliases)) if (req.body[original] !== undefined) req.body[campo] = req.body[original];
      if (req.body.inputNomeProd !== undefined) {
        req.body.codigo ||= `XH${randomUUID().replaceAll('-', '').slice(0, 20)}`;
        req.body.imagem ||= '/img/produto1.png';
        req.body.preco = String(req.body.preco ?? '').replace(',', '.');
      }
      if (req.body.inputNomeFunc !== undefined) {
        req.body.cargo = String(req.body.cargo ?? '').trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        req.body.salario = String(req.body.salario ?? '').replace(',', '.');
        req.body.anosTrabalho ??= 0;
        req.body.setor ||= 'Geral';
        req.body.percentualBonus ??= 2;
        req.body.quantidadeSetores ||= 1;
      }
    }
    next();
  });
  app.use(session({ name: 'xhopii.sid', secret: process.env.SESSION_SECRET || randomBytes(32).toString('hex'), resave: false, saveUninitialized: false, cookie: { httpOnly: true, sameSite: 'lax', maxAge: 2 * 60 * 60 * 1000 } }));
  app.use(async (req, res, next) => {
    // Confere se a conta ainda existe, inclusive após exclusão administrativa.
    if (req.session.usuario && !(await banco.ler()).usuarios.some(u => u.id === req.session.usuario.id)) delete req.session.usuario;
    req.session.csrf ??= randomBytes(24).toString('hex');
    Object.assign(res.locals, { usuario: req.session.usuario, csrf: req.session.csrf, mensagem: req.session.mensagem, dinheiro: valor => Number(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }), caminho: req.path });
    delete req.session.mensagem;
    if (!['GET', 'HEAD', 'OPTIONS'].includes(req.method) && req.body?._csrf !== req.session.csrf && req.get('x-csrf-token') !== req.session.csrf) return next(Object.assign(new Error('Sessão do formulário expirou. Atualize a página.'), { status: 403 }));
    next();
  });
  const entrar = (req, res, next) => req.session.usuario ? next() : res.redirect('/login');
  const admin = (req, res, next) => { if (req.session.usuario?.papel !== 'admin') falha('Esta página é restrita à administração.', 403); next(); };
  const sucesso = (req, res, mensagem, destino) => { req.session.mensagem = mensagem; res.redirect(303, destino); };
  const limiteLogin = rateLimit({ windowMs: 10 * 60 * 1000, limit: 5, standardHeaders: 'draft-8', legacyHeaders: false, handler: (req, res) => res.status(429).render('login', { titulo: 'Entrar', erro: 'Limite de 5 tentativas atingido. Tente novamente em 10 minutos.' }) });

  app.get('/login', (req, res) => res.render('login', { titulo: 'Entrar', erro: null }));
  app.post('/login', limiteLogin, async (req, res) => {
    const dados = await banco.ler(); // readFile a cada login no modo JSON.
    const nome = String(req.body.usuario ?? '').trim().toLowerCase();
    const senha = typeof req.body.senha === 'string' ? req.body.senha : '';
    const usuario = dados.usuarios.find(u => u.usuario === nome);
    if (senha.length > 128 || !usuario || !verificarSenha(senha, usuario.senhaHash)) return res.status(401).render('login', { titulo: 'Entrar', erro: 'Usuário ou senha inválidos.' });
    await new Promise((resolve, reject) => req.session.regenerate(e => e ? reject(e) : resolve()));
    req.session.usuario = { id: usuario.id, nome: usuario.nome, papel: usuario.papel };
    sucesso(req, res, `Bem-vindo(a), ${usuario.nome}!`, '/');
  });
  app.post('/logout', (req, res, next) => req.session.destroy(e => { if (e) return next(e); res.clearCookie('xhopii.sid'); res.redirect('/login'); }));
  app.get('/ajuda', (req, res) => res.render('ajuda', { titulo: 'Ajuda' }));
  app.get('/recuperar-senha', (req, res) => res.render('recuperar-senha', { erro: null }));
  app.post('/recuperar-senha', (req, res) => res.status(501).render('recuperar-senha', { erro: 'Recuperação por e-mail não configurada nesta demonstração.' }));

  const formulario = (req, res, tipo, item = {}, erro = null, status = 200) => res.status(status).render('formulario', { titulo: `${item.id || (tipo === 'produtos' && req.params.id) ? 'Editar' : 'Cadastrar'} ${tipo === 'produtos' ? 'produto' : tipo === 'clientes' ? 'cliente' : 'funcionário'}`, tipo, item, editando: Boolean(req.params.id), erro });
  for (const tipo of ['clientes', 'funcionarios', 'produtos']) {
    const acesso = tipo === 'clientes' ? [] : [entrar, admin];
    app.get(`/${tipo}/cadastrar`, ...acesso, (req, res) => formulario(req, res, tipo));
    app.post(`/${tipo}`, ...acesso, async (req, res) => {
      try {
        const item = validar(tipo, req.body);
        await banco.alterar(dados => {
          if (tipo === 'produtos') {
            if (dados.produtos.some(p => p.codigo === item.codigo)) falha('Código já cadastrado.');
          } else {
            if (dados[tipo].some(p => p.cpf === item.cpf || p.email === item.email) || (tipo === 'clientes' && dados.usuarios.some(u => u.usuario === item.email))) falha('CPF ou e-mail já cadastrado.');
            item.id = randomUUID();
            if (tipo === 'clientes') { dados.usuarios.push({ id: item.id, nome: item.nome, usuario: item.email, senhaHash: gerarHash(item.senha), papel: 'cliente' }); delete item.senha; }
          }
          dados[tipo].push(item);
        });
        sucesso(req, res, 'Cadastro realizado com sucesso.', tipo === 'clientes' && req.session.usuario?.papel !== 'admin' ? (req.session.usuario ? '/' : '/login') : `/${tipo}`);
      } catch (e) { if (e.status !== 400) throw e; formulario(req, res, tipo, { ...req.body, senha: '' }, e.message, 400); }
    });
    if (tipo !== 'produtos') app.get(`/${tipo}`, entrar, admin, async (req, res) => {
      const busca = String(req.query.busca ?? '').trim();
      const itens = (await banco.ler())[tipo].filter(p => `${p.nome} ${p.sobrenome} ${p.cpf}`.toLowerCase().includes(busca.toLowerCase())).sort((a, b) => a.nome.localeCompare(b.nome, 'pt-BR'));
      res.render('pessoas', { titulo: tipo === 'clientes' ? 'Clientes' : 'Funcionários', tipo, itens, busca, criarFuncionario });
    });
    app.get(`/${tipo}/:id/editar`, entrar, admin, async (req, res) => {
      const item = (await banco.ler())[tipo].find(p => (p.id ?? p.codigo) === req.params.id);
      if (!item) falha('Registro não encontrado.', 404);
      formulario(req, res, tipo, item);
    });
    app.post(`/${tipo}/:id/editar`, entrar, admin, async (req, res) => {
      try {
        const alteracoes = validar(tipo, req.body, true);
        await banco.alterar(dados => {
          const item = dados[tipo].find(p => (p.id ?? p.codigo) === req.params.id);
          if (!item) falha('Registro não encontrado.', 404);
          if (tipo === 'produtos') { if (alteracoes.codigo !== item.codigo) falha('O código do produto não pode ser alterado.'); }
          else if (dados[tipo].some(p => p.id !== item.id && (p.cpf === alteracoes.cpf || p.email === alteracoes.email)) || (tipo === 'clientes' && dados.usuarios.some(u => u.id !== item.id && u.usuario === alteracoes.email))) falha('CPF ou e-mail já cadastrado.');
          Object.assign(item, alteracoes);
          if (tipo === 'clientes') Object.assign(dados.usuarios.find(u => u.id === item.id), { nome: item.nome, usuario: item.email });
        });
        sucesso(req, res, 'Alterações salvas.', `/${tipo}`);
      } catch (e) { if (e.status !== 400) throw e; formulario(req, res, tipo, { ...req.body, id: tipo !== 'produtos' ? req.params.id : undefined }, e.message, 400); }
    });
    app.post(`/${tipo}/:id/excluir`, entrar, admin, async (req, res) => {
      await banco.alterar(dados => {
        if (!dados[tipo].some(p => (p.id ?? p.codigo) === req.params.id)) falha('Registro não encontrado.', 404);
        dados[tipo] = dados[tipo].filter(p => (p.id ?? p.codigo) !== req.params.id);
        if (tipo === 'clientes') dados.usuarios = dados.usuarios.filter(u => u.id !== req.params.id);
      });
      sucesso(req, res, 'Registro excluído.', `/${tipo}`);
    });
  }
  // Compatibilidade com os endereços que já existiam nas telas fornecidas.
  app.get('/funcionario/cadastrar', (req, res) => res.redirect('/funcionarios/cadastrar'));
  app.get('/produto/cadastrar', (req, res) => res.redirect('/produtos/cadastrar'));
  app.get(['/home.html', '/home'], (req, res) => res.redirect('/'));
  app.get(['/', '/produtos'], entrar, async (req, res) => {
    const dados = await banco.ler();
    const mercado = new Mercado('Xhopii', '', '', '', dados.produtos.map(p => new Produto(p)));
    const busca = String(req.query.busca ?? '').trim();
    const ordem = ['menor', 'maior', 'nome'].includes(req.query.ordem) ? req.query.ordem : 'nome';
    const produtos = mercado.produtos.filter(p => `${p.nome} ${p.codigo} ${p.marca}`.toLowerCase().includes(busca.toLowerCase())).sort((a, b) => ordem === 'menor' ? a.preco - b.preco : ordem === 'maior' ? b.preco - a.preco : a.nome.localeCompare(b.nome, 'pt-BR'));
    res.render('catalogo', { titulo: req.path === '/' ? 'Home' : 'Produtos', produtos, busca, ordem, mercado, home: req.path === '/' });
  });
  app.get('/produtos/:id', entrar, async (req, res) => {
    const produto = (await banco.ler()).produtos.find(p => p.codigo === req.params.id);
    if (!produto) falha('Produto não encontrado.', 404);
    res.render('produto', { titulo: produto.nome, produto, chave: randomUUID() });
  });
  app.post('/compras', entrar, async (req, res) => {
    const pedido = await comprar(banco, req.body, req.session.usuario.id);
    sucesso(req, res, `Compra simulada concluída! Pedido ${pedido.id.slice(0, 8)}.`, '/pedidos');
  });
  app.get('/pedidos', entrar, async (req, res) => {
    const pedidos = (await banco.ler()).pedidos.filter(p => p.usuarioId === req.session.usuario.id).reverse();
    res.render('pedidos', { titulo: 'Meus pedidos', pedidos });
  });
  app.get('/api/produtos', entrar, async (req, res) => res.json((await banco.ler()).produtos));
  app.get('/api/mercado', entrar, admin, async (req, res) => {
    const mercado = new Mercado('Xhopii', '', '', '', (await banco.ler()).produtos.map(p => new Produto(p)));
    res.json({ valorEstoque: mercado.calcularValorMercado(), produtoMaisCaro: mercado.encontrarProdutoMaisCaro(), produtos: mercado.imprimirProdutos() });
  });
  app.use((req, res) => res.status(404).render('erro', { titulo: 'Página não encontrada', erro: 'Esse endereço não existe. Use o menu para continuar.' }));
  app.use((erro, req, res, next) => {
    if (res.headersSent) return next(erro);
    const status = erro.status || 500;
    if (status >= 500) console.error(erro);
    res.status(status).render('erro', { titulo: status === 500 ? 'Não foi possível concluir' : 'Confira os dados', erro: status === 500 ? 'Ocorreu um erro ao salvar ou consultar os dados. Tente novamente.' : erro.message });
  });
  return app;
}
