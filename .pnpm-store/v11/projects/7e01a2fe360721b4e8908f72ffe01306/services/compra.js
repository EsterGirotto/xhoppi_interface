import { randomUUID } from 'node:crypto';
import { Produto } from '../models/Produto.js';
const aguardar = ms => new Promise(resolve => setTimeout(resolve, ms));
export function falha(mensagem, status = 400) { const erro = new Error(mensagem); erro.status = status; throw erro; }
export async function comprar(banco, { codigo, quantidade, cupom, pagamento, chave }, usuarioId, atraso = 200) {
  quantidade = Number(quantidade);
  if (!Number.isSafeInteger(quantidade) || quantidade < 1 || quantidade > 999) falha('Informe uma quantidade entre 1 e 999.');
  cupom = String(cupom ?? '').trim().toUpperCase();
  if (cupom && cupom !== 'XHOPII10') falha('Cupom inválido. Use XHOPII10 para 10% de desconto.');
  if (!['aprovado', 'recusado'].includes(pagamento)) falha('Selecione o resultado do pagamento simulado.');
  if (typeof chave !== 'string' || chave.length < 10 || chave.length > 100) falha('Identificador de compra inválido. Atualize a página.');
  return banco.alterar(async dados => {
    const anterior = dados.pedidos.find(p => p.chave === chave && p.usuarioId === usuarioId);
    if (anterior) return anterior;
    const produtos = dados.produtos.map(p => new Produto(p));
    const produto = produtos.find(p => p.codigo === codigo);
    // Promises encadeadas: estoque -> pagamento -> envio. Nenhuma cobrança real.
    return Promise.resolve().then(async () => {
      await aguardar(atraso);
      if (!produto) falha('Produto não encontrado.', 404);
      if (produto.quantidade < quantidade) falha('Estoque insuficiente.', 409);
      return produto.aplicarCupomDesconto(cupom ? 10 : 0);
    }).then(async preco => {
      await aguardar(atraso);
      if (pagamento === 'recusado') falha('Pagamento simulado recusado. Seu estoque não foi alterado.');
      return Math.round(preco * 100) * quantidade / 100;
    }).then(async total => {
      await aguardar(atraso);
      dados.produtos.find(p => p.codigo === codigo).quantidade -= quantidade;
      const pedido = { id: randomUUID(), chave, usuarioId, codigo, nome: produto.nome, quantidade, total, cupom, status: 'Envio simulado', criadoEm: new Date().toISOString(), etapas: ['Estoque verificado', 'Pagamento simulado aprovado', 'Envio simulado'] };
      dados.pedidos.push(pedido);
      return pedido;
    });
  });
}
