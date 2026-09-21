export class Funcionario {
  constructor({ nome, cpf, salario, anosTrabalho = 0 }) { Object.assign(this, { nome, cpf, salario: Number(salario), anosTrabalho: Number(anosTrabalho) }); }
  getNome() { return this.nome; }
  setNome(v) { this.nome = v; }
  getCpf() { return this.cpf; }
  setCpf(v) { this.cpf = v; }
  getAnosTrabalho() { return this.anosTrabalho; }
  setAnosTrabalho(v) { this.anosTrabalho = Number(v); }
  setSalario(v) { this.salario = Number(v); }
  getSalario() { return Math.round((this.salario + this.calcularBonus()) * 100) / 100; }
  calcularBonus() { return this.salario * 0.02; }
  imprimir() { return `${this.nome} | CPF ${this.cpf} | ${this.anosTrabalho} anos | Salário com bônus: R$ ${this.getSalario().toFixed(2)}`; }
}
export class Gerente extends Funcionario {
  constructor(dados) { super(dados); this.setor = dados.setor; this.percentualBonus = Number(dados.percentualBonus ?? 2); }
  getSetor() { return this.setor; }
  setSetor(v) { this.setor = v; }
  getPercentualBonus() { return this.percentualBonus; }
  setPercentualBonus(v) { this.percentualBonus = Number(v); }
  calcularBonus() { return this.salario * this.percentualBonus / 100 + 250; }
  imprimir() { return `${super.imprimir()} | Setor: ${this.setor} | Bônus: ${this.percentualBonus}% + R$ 250,00`; }
}
export class Diretor extends Funcionario {
  constructor(dados) { super(dados); this.quantidadeSetores = Number(dados.quantidadeSetores); }
  getQuantidadeSetores() { return this.quantidadeSetores; }
  setQuantidadeSetores(v) { this.quantidadeSetores = Number(v); }
  calcularBonus() { return this.salario * 0.05 + 500; }
  imprimir() { return `${super.imprimir()} | Setores dirigidos: ${this.quantidadeSetores}`; }
}
export const criarFuncionario = dados => new ({ funcionario: Funcionario, gerente: Gerente, diretor: Diretor }[dados.cargo] ?? Funcionario)(dados);
