export class Mercado {
  constructor(nome, cnpj, endereco, redeSocial, produtos = []) {
    Object.assign(this, { nome, cnpj, endereco, redeSocial, produtos });
  }
  getNome() { return this.nome; }
  setNome(v) { this.nome = v; }
  getCnpj() { return this.cnpj; }
  setCnpj(v) { this.cnpj = v; }
  getEndereco() { return this.endereco; }
  setEndereco(v) { this.endereco = v; }
  getRedeSocial() { return this.redeSocial; }
  setRedeSocial(v) { this.redeSocial = v; }
  getProdutos() { return [...this.produtos]; }
  setProdutos(v) { this.produtos = [...v]; }
  adicionarProduto(produto) {
    if (this.buscarProduto(produto.codigo)) throw new Error('Código já cadastrado.');
    this.produtos.push(produto);
  }
  excluirProduto(codigo) { this.produtos = this.produtos.filter(p => p.codigo !== codigo); }
  buscarProduto(codigo) { return this.produtos.find(p => p.codigo === codigo); }
  encontrarProdutoMaisCaro() { return this.imprimirProdutos()[0] ?? null; }
  imprimirProdutos() { return [...this.produtos].sort((a, b) => b.preco - a.preco); }
  calcularValorMercado() { return this.produtos.reduce((total, p) => total + Math.round(p.preco * 100) * p.quantidade, 0) / 100; }
  imprimir() { return `${this.nome} | ${this.cnpj} | ${this.endereco} | ${this.redeSocial}\n${this.imprimirProdutos().map(p => p.imprimir()).join('\n')}`; }
}
