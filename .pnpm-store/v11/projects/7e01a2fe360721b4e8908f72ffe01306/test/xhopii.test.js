import test from 'node:test';
import assert from 'node:assert/strict';
import { mkdtemp, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import path from 'node:path';
import { Banco } from '../repositories/Banco.js';
import { criarApp } from '../app.js';
import { Produto } from '../models/Produto.js';
import { Mercado } from '../models/Mercado.js';
import { Funcionario, Gerente, Diretor } from '../models/Funcionario.js';
import { comprar } from '../services/compra.js';

test('POO: cupom, valor de estoque, ordenação e bônus polimórficos', () => {
  const a = new Produto({ codigo: '1', nome: 'A', preco: 59.9, quantidade: 2 });
  const b = new Produto({ codigo: '2', nome: 'B', preco: 100, quantidade: 3 });
  const mercado = new Mercado('Xhopii', '', '', '', [a, b]);
  assert.equal(a.aplicarCupomDesconto(10), 53.91);
  assert.throws(() => a.aplicarCupomDesconto(101));
  assert.equal(mercado.calcularValorMercado(), 419.8);
  assert.equal(mercado.encontrarProdutoMaisCaro().codigo, '2');
  assert.equal(mercado.buscarProduto('1'), a);
  mercado.excluirProduto('1');
  assert.equal(mercado.produtos.length, 1);
  assert.equal(new Funcionario({ salario: 1000 }).getSalario(), 1020);
  assert.equal(new Gerente({ salario: 1000, percentualBonus: 10 }).getSalario(), 1350);
  assert.equal(new Diretor({ salario: 1000 }).getSalario(), 1550);
});

test('Compra: recusa sem baixa, concorrência, idempotência e persistência', async () => {
  const diretorio = await mkdtemp(path.join(tmpdir(), 'xhopii-compra-'));
  const banco = new Banco({ diretorio });
  try {
    await banco.iniciar();
    await banco.alterar(d => { d.produtos[0].quantidade = 1; });
    const dados = { codigo: 'XH001', quantidade: 1, cupom: 'XHOPII10', pagamento: 'recusado', chave: 'compra-teste-1' };
    await assert.rejects(comprar(banco, dados, 'u', 0), /recusado/);
    assert.equal((await banco.ler()).produtos[0].quantidade, 1);
    dados.pagamento = 'aprovado';
    const resultados = await Promise.allSettled([comprar(banco, dados, 'u', 0), comprar(banco, { ...dados, chave: 'compra-teste-2' }, 'u', 0)]);
    assert.equal(resultados.filter(r => r.status === 'fulfilled').length, 1);
    assert.equal((await banco.ler()).produtos[0].quantidade, 0);
    assert.equal((await comprar(banco, dados, 'u', 0)).total, 53.91);
    assert.equal((await banco.ler()).pedidos.length, 1);
    const reaberto = new Banco({ diretorio });
    await reaberto.iniciar();
    assert.equal((await reaberto.ler()).pedidos.length, 1);
    await assert.rejects(comprar(banco, { ...dados, quantidade: -1 }, 'u', 0), /quantidade/);
  } finally { await banco.fechar(); await rm(diretorio, { recursive: true, force: true }); }
});

test('HTTP: login, CSRF, CRUD, autorização, XSS e limite de tentativas', async () => {
  const diretorio = await mkdtemp(path.join(tmpdir(), 'xhopii-http-'));
  const banco = new Banco({ diretorio });
  await banco.iniciar();
  const server = criarApp(banco, { logs: false }).listen(0, '127.0.0.1');
  await new Promise(resolve => server.once('listening', resolve));
  const base = `http://127.0.0.1:${server.address().port}`;
  function cliente() {
    let cookie = '', csrf = '';
    return async (url, dados, token = true) => {
      const response = await fetch(base + url, { redirect: 'manual', headers: { Cookie: cookie, ...(dados ? { 'Content-Type': 'application/x-www-form-urlencoded' } : {}) }, ...(dados ? { method: 'POST', body: new URLSearchParams({ ...dados, ...(token ? { _csrf: csrf } : {}) }) } : {}) });
      const novo = response.headers.get('set-cookie');
      if (novo) cookie = novo.split(';')[0];
      const html = await response.text();
      csrf = html.match(/name="_csrf" value="([^"]+)"/)?.[1] ?? html.match(/name="csrf-token" content="([^"]+)"/)?.[1] ?? csrf;
      return { status: response.status, html, location: response.headers.get('location') };
    };
  }
  const admin = cliente(), visitante = cliente();
  try {
    assert.equal((await admin('/')).location, '/login');
    assert.equal((await admin('/login')).status, 200);
    assert.equal((await admin('/login', { usuario: 'admin', senha: 'Xhopii123!' }, false)).status, 403);
    assert.equal((await admin('/login', { inputEmailLog: 'admin', inputSenhaLog: 'Xhopii123!' })).status, 303);
    const home = await admin('/');
    assert.equal(home.status, 200);
    assert.ok(home.html.includes('href="/css/style.css"'));
    assert.ok(home.html.includes('conteudo-home-carousel'));
    assert.ok(home.html.includes('/img/home-promocao.png'));
    assert.ok(!home.html.includes('/css/app.css'));
    for (const rota of ['/produtos', '/produtos/XH001', '/produtos/cadastrar', '/clientes', '/clientes/cadastrar', '/funcionarios', '/funcionarios/cadastrar', '/pedidos', '/ajuda', '/api/mercado']) assert.equal((await admin(rota)).status, 200, rota);
    const produto = { codigo: 'TESTE', nome: '<script>alert(1)</script>', marca: 'Marca', descricao: 'Produto de teste', preco: '10', quantidade: '3', imagem: '/img/produto1.png' };
    assert.equal((await admin('/produtos', { ...produto, preco: '-1' })).status, 400);
    assert.equal((await admin('/produtos', { codigo: 'TESTE', inputNomeProd: produto.nome, inputFabricanteProd: produto.marca, inputDescricaoProd: produto.descricao, inputValorProd: '10,00', inputQtdProd: '3' })).status, 303);
    assert.equal((await admin('/produtos', produto)).status, 400);
    const catalogo = await admin('/produtos?busca=script');
    assert.ok(catalogo.html.includes('&lt;script&gt;'));
    assert.ok(!catalogo.html.includes('<script>alert(1)</script>'));
    assert.equal((await admin('/produtos/TESTE/editar')).status, 200);
    assert.equal((await admin('/produtos/TESTE/editar', { ...produto, preco: '20' })).status, 303);
    assert.equal((await banco.ler()).produtos.find(p => p.codigo === 'TESTE').preco, 20);
    assert.equal((await admin('/produtos/TESTE/excluir', {})).status, 303);
    assert.equal((await admin('/produtos', { inputNomeProd: 'Produto original', inputFabricanteProd: 'Marca', inputDescricaoProd: 'Descrição original', inputValorProd: '12,50', inputQtdProd: '1' })).status, 303);
    assert.equal((await banco.ler()).produtos.find(p => p.nome === 'Produto original').preco, 12.5);
    await visitante('/clientes/cadastrar');
    const pessoa = { nome: 'Ana', sobrenome: 'Teste', cpf: '12345678901', email: 'ana@example.test', telefone: '18999999999', dataNascimento: '2000-01-01', senha: 'Senha123!' };
    assert.equal((await visitante('/clientes', pessoa)).status, 303);
    assert.ok(!(await banco.ler()).clientes[0].senha);
    assert.notEqual((await banco.ler()).usuarios[1].senhaHash, pessoa.senha);
    assert.equal((await visitante('/login', { usuario: pessoa.email, senha: pessoa.senha })).status, 303);
    await visitante('/');
    assert.equal((await visitante('/clientes')).status, 403);
    assert.equal((await visitante('/funcionarios')).status, 403);
    assert.equal((await visitante('/produtos', produto)).status, 403);
    const detalhe = await visitante('/produtos/XH001');
    const chave = detalhe.html.match(/name="chave" value="([^"]+)"/)[1];
    assert.equal((await visitante('/compras', { codigo: 'XH001', quantidade: '2', cupom: 'XHOPII10', pagamento: 'aprovado', chave })).status, 303);
    assert.ok((await visitante('/pedidos')).html.includes('107,82'));
    assert.ok(!(await admin('/pedidos')).html.includes('107,82'));
    assert.equal((await banco.ler()).produtos[0].quantidade, 169);
    assert.equal((await visitante('/compras', { codigo: 'XH001', quantidade: '2', cupom: 'XHOPII10', pagamento: 'aprovado', chave })).status, 303);
    assert.equal((await banco.ler()).pedidos.length, 1);
    const id = (await banco.ler()).clientes[0].id;
    await admin('/clientes/' + id + '/editar');
    assert.equal((await admin('/clientes/' + id + '/editar', { ...pessoa, nome: 'Ana Maria' })).status, 303);
    const funcionario = { ...pessoa, cargo: 'gerente', salario: '2000', anosTrabalho: '3', setor: 'Vendas', percentualBonus: '10' };
    assert.equal((await admin('/funcionarios', funcionario)).status, 303);
    assert.equal((await banco.ler()).funcionarios[0].dataNascimento, pessoa.dataNascimento);
    assert.equal((await admin('/funcionarios', { ...funcionario, dataNascimento: '2000-02-31' })).status, 400);
    assert.ok((await admin('/funcionarios')).html.includes('2.450,00'));
    const fid = (await banco.ler()).funcionarios[0].id;
    assert.equal((await admin(`/funcionarios/${fid}/editar`, { ...funcionario, cargo: 'diretor', quantidadeSetores: 4 })).status, 303);
    assert.ok((await admin(`/funcionarios/${fid}/editar`)).html.includes('value="2000-01-01"'));
    assert.equal((await admin(`/funcionarios/${fid}/excluir`, {})).status, 303);
    assert.equal((await admin(`/clientes/${id}/excluir`, {})).status, 303);
    assert.equal((await visitante('/')).location, '/login');
    assert.equal((await admin('/nao-existe')).status, 404);
    const anonimo = cliente();
    await anonimo('/login');
    for (let i = 0; i < 3; i++) assert.equal((await anonimo('/login', { usuario: 'admin', senha: 'errada' })).status, 401);
    assert.equal((await anonimo('/login', { usuario: 'admin', senha: 'errada' })).status, 429);
    assert.equal((await admin('/logout', {})).status, 302);
    assert.equal((await admin('/')).location, '/login');
  } finally { await new Promise(resolve => server.close(resolve)); await banco.fechar(); await rm(diretorio, { recursive: true, force: true }); }
});
