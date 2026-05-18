<?php
$conexao = null;

function conectarBanco()
{
    global $conexao;

    if ($conexao != null) {
        return $conexao;
    } else {
        $servidor = 'localhost';
        $usuario = 'root';
        $senha = '';
        $banco = 'xhopii_integrado';

        $conexao = mysqli_connect($servidor, $usuario, $senha);

        if (!$conexao) {
            die('Erro ao conectar no banco de dados.');
        } else {
            mysqli_query($conexao, "CREATE DATABASE IF NOT EXISTS $banco CHARACTER SET utf8 COLLATE utf8_general_ci");
            mysqli_select_db($conexao, $banco);
            mysqli_set_charset($conexao, 'utf8');
            criarTabelas($conexao);
            criarDadosIniciais($conexao);
            return $conexao;
        }
    }
}

function criarTabelas($conexao)
{
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, tipo VARCHAR(30) NOT NULL DEFAULT 'cliente')");
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS clientes (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, sobrenome VARCHAR(80) NOT NULL, cpf VARCHAR(20) NOT NULL, data_nascimento DATE NOT NULL, telefone VARCHAR(30) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, foto VARCHAR(255))");
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS funcionarios (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, sobrenome VARCHAR(80) NOT NULL, cpf VARCHAR(20) NOT NULL, data_nascimento DATE NOT NULL, telefone VARCHAR(30) NOT NULL, cargo VARCHAR(90) NOT NULL, salario DECIMAL(10,2) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, foto VARCHAR(255))");
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS produtos (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(160) NOT NULL, marca VARCHAR(120) NOT NULL, descricao TEXT NOT NULL, valor DECIMAL(10,2) NOT NULL, quantidade INT NOT NULL, imagem VARCHAR(255) NOT NULL DEFAULT 'img/produto1.png')");
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS lojas (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(140) NOT NULL, cnpj VARCHAR(30) NOT NULL, endereco VARCHAR(180) NOT NULL, telefone VARCHAR(30) NOT NULL)");
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS cupons (id INT AUTO_INCREMENT PRIMARY KEY, codigo VARCHAR(40) NOT NULL UNIQUE, descricao VARCHAR(180) NOT NULL, desconto DECIMAL(5,2) NOT NULL, validade DATE NOT NULL)");

    adicionarColunaSeFaltar($conexao, 'usuarios', 'senha', "ALTER TABLE usuarios ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
    adicionarColunaSeFaltar($conexao, 'clientes', 'senha', "ALTER TABLE clientes ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
    adicionarColunaSeFaltar($conexao, 'funcionarios', 'senha', "ALTER TABLE funcionarios ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
    deixarSenhaHashAntigaNula($conexao, 'usuarios');
    deixarSenhaHashAntigaNula($conexao, 'clientes');
    deixarSenhaHashAntigaNula($conexao, 'funcionarios');
}

function adicionarColunaSeFaltar($conexao, $tabela, $coluna, $sql)
{
    $resultado = mysqli_query($conexao, "SHOW COLUMNS FROM $tabela LIKE '$coluna'");
    if ($resultado) {
        if (mysqli_num_rows($resultado) == 0) {
            mysqli_query($conexao, $sql);
        }
    }
}

function deixarSenhaHashAntigaNula($conexao, $tabela)
{
    $resultado = mysqli_query($conexao, "SHOW COLUMNS FROM $tabela LIKE 'senha_hash'");
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            mysqli_query($conexao, "ALTER TABLE $tabela MODIFY senha_hash VARCHAR(255) NULL");
        }
    }
}

function criarDadosIniciais($conexao)
{
    $resultado = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM usuarios");
    $linha = mysqli_fetch_assoc($resultado);

    if ((int)$linha['total'] == 0) {
        mysqli_query($conexao, "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('Administrador Xhopii', 'admin@xhopii.com', '123456', 'funcionario')");
    } else {
        mysqli_query($conexao, "UPDATE usuarios SET senha = '123456' WHERE email = 'admin@xhopii.com'");
    }

    $resultado = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM produtos");
    $linha = mysqli_fetch_assoc($resultado);

    if ((int)$linha['total'] == 0) {
        mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto1.png')");
        mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto2.png')");
        mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto3.png')");
        mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto4.png')");
        mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto5.png')");
    }
}
?>
