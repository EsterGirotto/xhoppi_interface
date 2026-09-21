import test from 'node:test';
import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import { createHash } from 'node:crypto';
const arquivo = caminho => readFile(new URL(`../${caminho}`, import.meta.url), 'utf8');

test('CSS original preservado, sem folhas ou estilos adicionais nas telas', async () => {
  const css = await readFile(new URL('../assets/css/style.css', import.meta.url));
  assert.equal(createHash('sha256').update(css).digest('hex'), '827ea4113086b9c537c46cb36c9ad9a368ccc91a58a6cca0d339ead19057129a');
  for (const nome of ['login', 'home', 'ver-produto', 'cadastrar-clientes', 'cadastrar-funcionarios', 'cadastrar-produtos', 'clientes', 'funcionarios', 'produto', 'pedidos', 'erro', 'ajuda', 'recuperar-senha']) {
    const html = await arquivo(`views/app/${nome}.ejs`);
    assert.deepEqual([...html.matchAll(/<link[^>]+rel="stylesheet"[^>]+href="([^"]+)"/g)].map(m => m[1]), ['/css/style.css'], nome);
    assert.ok(!/<style\b|\sstyle=/.test(html), nome);
  }
});

test('Formulários mantêm campos visíveis, classes, IDs e rodapé originais', async () => {
  const pares = [['login.html', 'login'], ['cadastrar-cliente.html', 'cadastrar-clientes'], ['cadastrar-funcionario.html', 'cadastrar-funcionarios'], ['cadastrar-produto.html', 'cadastrar-produtos'], ['recuperar-senha.html', 'recuperar-senha']];
  for (const [origem, ativo] of pares) {
    const original = await arquivo(`views/${origem}`);
    const adaptado = await arquivo(`views/app/${ativo}.ejs`);
    // Ignora apenas expressões EJS e campos ocultos necessários ao servidor.
    const limpo = adaptado.replace(/<%[\s\S]*?%>/g, '').replace(/<input\b[^>]*type="hidden"[^>]*>/g, '');
    for (const atributo of ['class', 'id', 'name']) {
      const valores = texto => [...texto.matchAll(new RegExp(`\\b${atributo}="([^"]*)"`, 'g'))].map(m => m[1]).filter(v => v !== 'csrf-token');
      assert.deepEqual(valores(limpo), valores(original), `${ativo}: ${atributo}`);
    }
    assert.equal(adaptado.slice(adaptado.indexOf('<footer')), original.slice(original.indexOf('<footer')), `${ativo}: rodapé`);
  }
});

test('Home e listagens conservam os contêineres e o rodapé das telas fornecidas', async () => {
  for (const [origem, ativo] of [['home.html', 'home'], ['ver-produto.html', 'ver-produto'], ['visualizar-cliente.ejs', 'clientes'], ['visualizar-funcionario.html', 'funcionarios']]) {
    const original = await arquivo(`views/${origem}`);
    const adaptado = await arquivo(`views/app/${ativo}.ejs`);
    const classes = texto => [...new Set([...texto.matchAll(/\bclass="([^"]*)"/g)].map(m => m[1]))];
    const permitidas = classes(original);
    // A listagem de funcionários era um espaço vazio; usa o mesmo bloco de clientes.
    if (ativo === 'funcionarios') permitidas.push('conteudo-bloco');
    assert.deepEqual(classes(adaptado).sort(), permitidas.sort(), ativo);
    assert.equal(adaptado.slice(adaptado.indexOf('<footer')), original.slice(original.indexOf('<footer')), `${ativo}: rodapé`);
    const nav = texto => texto.match(/<nav[\s\S]*?<\/nav>/)[0].replace(/href="[^"]*"/g, 'href=""');
    assert.equal(nav(adaptado), nav(original), `${ativo}: menu`);
  }
});

test('Detalhes não reutilizam o contêiner flex da listagem e separam o rodapé', async () => {
  const html = await arquivo('views/app/produto.ejs');
  assert.ok(!html.includes('conteudo-visualizar'));
  assert.ok(html.includes('<main>\n<section class="produto-imagem">'));
  assert.ok(html.includes('<section class="produto-detalhes">'));
  assert.ok(html.indexOf('<br clear="all">') < html.indexOf('<footer'));
});
