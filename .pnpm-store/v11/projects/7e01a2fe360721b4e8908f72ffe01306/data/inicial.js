import { gerarHash } from '../services/senhas.js';
export function dadosIniciais() {
  return {
    usuarios: [{ id: 'admin', nome: 'Administrador', usuario: 'admin', senhaHash: gerarHash('Xhopii123!'), papel: 'admin' }],
    clientes: [], funcionarios: [], pedidos: [],
    produtos: [
      { codigo: 'XH001', nome: 'Camisa Desenvolvedor Front-End CSS', descricao: 'Uma camisa ideal para quem ama desenvolver interfaces.', marca: 'Eletiva Uniformes', preco: 59.90, quantidade: 171, imagem: '/img/produto1.png' },
      { codigo: 'XH002', nome: 'Camisa Dev • Coleção 02', descricao: 'Conforto para acompanhar sua rotina de estudos e programação.', marca: 'Eletiva Uniformes', preco: 64.90, quantidade: 48, imagem: '/img/produto2.png' },
      { codigo: 'XH003', nome: 'Camisa Dev • Coleção 03', descricao: 'Estilo e tecnologia no seu dia a dia.', marca: 'Eletiva Uniformes', preco: 69.90, quantidade: 32, imagem: '/img/produto3.png' },
      { codigo: 'XH004', nome: 'Camisa Dev • Coleção 04', descricao: 'Uma peça para levar sua paixão por código a qualquer lugar.', marca: 'Eletiva Uniformes', preco: 74.90, quantidade: 20, imagem: '/img/produto4.png' },
      { codigo: 'XH005', nome: 'Camisa Dev • Coleção 05', descricao: 'Sua próxima favorita para criar novos projetos.', marca: 'Eletiva Uniformes', preco: 79.90, quantidade: 15, imagem: '/img/produto5.png' }
    ]
  };
}
