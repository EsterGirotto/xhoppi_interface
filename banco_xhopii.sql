CREATE DATABASE IF NOT EXISTS xhopii_integrado CHARACTER SET utf8 COLLATE utf8_general_ci;
USE xhopii_integrado;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    tipo VARCHAR(30) NOT NULL DEFAULT 'cliente'
);

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    sobrenome VARCHAR(80) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    foto VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    sobrenome VARCHAR(80) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    cargo VARCHAR(90) NOT NULL,
    salario DECIMAL(10,2) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL,
    foto VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(160) NOT NULL,
    marca VARCHAR(120) NOT NULL,
    descricao TEXT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL,
    imagem VARCHAR(255) NOT NULL DEFAULT 'img/produto1.png'
);

CREATE TABLE IF NOT EXISTS lojas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(140) NOT NULL,
    cnpj VARCHAR(30) NOT NULL,
    endereco VARCHAR(180) NOT NULL,
    telefone VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(40) NOT NULL UNIQUE,
    descricao VARCHAR(180) NOT NULL,
    desconto DECIMAL(5,2) NOT NULL,
    validade DATE NOT NULL
);

DELETE FROM usuarios WHERE email = 'funcionario@xhopii.com';
DELETE FROM funcionarios WHERE email = 'funcionario@xhopii.com';
DELETE FROM usuarios WHERE email = 'admin@xhopii.com';
DELETE FROM produtos;

INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha)
VALUES ('Funcionario', 'Teste', '12345678900', '2000-01-01', '18999999999', 'Atendente', 1800.00, 'funcionario@xhopii.com', '123456');

INSERT INTO usuarios (nome, email, senha, tipo)
VALUES ('Funcionario Teste', 'funcionario@xhopii.com', '123456', 'funcionario');

INSERT INTO usuarios (nome, email, senha, tipo)
VALUES ('Administrador Xhopii', 'admin@xhopii.com', '123456', 'funcionario');

INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto1.png');

INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto2.png');

INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto3.png');

INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto4.png');

INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem)
VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto5.png');
