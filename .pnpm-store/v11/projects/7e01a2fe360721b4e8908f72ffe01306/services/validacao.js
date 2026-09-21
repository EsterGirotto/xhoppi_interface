import { falha } from './compra.js';
const texto = (dados, campo, minimo = 1, maximo = 150) => {
  const valor = typeof dados[campo] === 'string' ? dados[campo].trim() : '';
  if (valor.length < minimo || valor.length > maximo) falha(`Campo ${campo}: informe entre ${minimo} e ${maximo} caracteres.`);
  return valor;
};
const numero = (dados, campo, minimo, maximo, inteiro = false) => {
  if (dados[campo] === '' || dados[campo] == null) falha(`Preencha ${campo}.`);
  const valor = Number(dados[campo]);
  if (!Number.isFinite(valor) || valor < minimo || valor > maximo || (inteiro && !Number.isInteger(valor))) falha(`Valor inválido para ${campo}.`);
  return valor;
};
const nascimento = dados => {
  const valor = texto(dados, 'dataNascimento');
  const data = new Date(`${valor}T00:00:00Z`);
  if (!/^\d{4}-\d{2}-\d{2}$/.test(valor) || !Number.isFinite(data.getTime()) || data.toISOString().slice(0, 10) !== valor || data > new Date() || data.getUTCFullYear() < 1900) falha('Data de nascimento inválida.');
  return valor;
};
export function validar(tipo, dados, editando = false) {
  if (tipo === 'produtos') {
    const imagem = texto(dados, 'imagem');
    if (!/^\/img\/produto[1-5]\.png$/.test(imagem)) falha('Selecione uma imagem da coleção.');
    const codigo = texto(dados, 'codigo', 1, 30);
    if (!/^[a-zA-Z0-9_-]+$/.test(codigo)) falha('Código deve conter apenas letras, números, hífen ou sublinhado.');
    return { codigo, nome: texto(dados, 'nome', 2), marca: texto(dados, 'marca'), descricao: texto(dados, 'descricao', 2, 1000), preco: Math.round(numero(dados, 'preco', 0.01, 1000000) * 100) / 100, quantidade: numero(dados, 'quantidade', 0, 1000000, true), imagem };
  }
  const cpf = texto(dados, 'cpf').replace(/\D/g, '');
  if (cpf.length !== 11) falha('CPF deve conter 11 dígitos.');
  const email = texto(dados, 'email', 3).toLowerCase();
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) falha('E-mail inválido.');
  const pessoa = { nome: texto(dados, 'nome', 2), sobrenome: texto(dados, 'sobrenome', 2), cpf, email, telefone: texto(dados, 'telefone', 8, 25) };
  if (tipo === 'clientes') {
    const dataNascimento = nascimento(dados);
    return { ...pessoa, dataNascimento, ...(!editando ? { senha: texto(dados, 'senha', 8, 128) } : {}) };
  }
  const cargo = texto(dados, 'cargo');
  if (!['funcionario', 'gerente', 'diretor'].includes(cargo)) falha('Cargo inválido.');
  return { ...pessoa, ...(dados.dataNascimento ? { dataNascimento: nascimento(dados) } : {}), cargo, salario: numero(dados, 'salario', 0.01, 1000000), anosTrabalho: numero(dados, 'anosTrabalho', 0, 80, true), setor: cargo === 'gerente' ? texto(dados, 'setor') : '', percentualBonus: cargo === 'gerente' ? numero(dados, 'percentualBonus', 0, 100) : 2, quantidadeSetores: cargo === 'diretor' ? numero(dados, 'quantidadeSetores', 1, 1000, true) : 0 };
}
