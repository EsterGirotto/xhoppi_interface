export class Produto {
  constructor({ codigo, nome, descricao, marca, quantidade, preco, imagem = '/img/produto1.png' }) {
    Object.assign(this, { codigo, nome, descricao, marca, quantidade: Number(quantidade), preco: Number(preco), imagem });
  }
  getCodigo() { return this.codigo; }
  setCodigo(valor) { this.codigo = valor; }
  getNome() { return this.nome; }
  setNome(valor) { this.nome = valor; }
  getDescricao() { return this.descricao; }
  setDescricao(valor) { this.descricao = valor; }
  getMarca() { return this.marca; }
  setMarca(valor) { this.marca = valor; }
  getQuantidade() { return this.quantidade; }
  setQuantidade(valor) { this.quantidade = Number(valor); }
  getPreco() { return this.preco; }
  setPreco(valor) { this.preco = Number(valor); }
  aplicarCupomDesconto(percentual) {
    if (!Number.isFinite(percentual) || percentual < 0 || percentual > 100) throw new Error('Desconto inválido.');
    return Math.round(this.preco * (1 - percentual / 100) * 100) / 100;
  }
  imprimir() { return `${this.codigo}: ${this.nome} | ${this.descricao} | ${this.marca} | ${this.quantidade} unidades | R$ ${this.preco.toFixed(2)}`; }
}
