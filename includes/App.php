<?php
session_start();
$conexao = null;
function conectarBanco()
{
    global $conexao;
if ($conexao !== null) {
        return $conexao;
    }

    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'xhopii_integrado';

    $conexao = mysqli_connect($servidor, $usuario, $senha);
    if (!$conexao) {
        die('Erro ao conectar no banco de dados.');
    }

    mysqli_query($conexao, "CREATE DATABASE IF NOT EXISTS $banco CHARACTER SET utf8 COLLATE utf8_general_ci");
    mysqli_select_db($conexao, $banco);
    mysqli_set_charset($conexao, 'utf8');
    criarTabelas($conexao);
    criarDadosIniciais($conexao);

    return $conexao;
}

function criarTabelas($conexao)
{
    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(160) NOT NULL UNIQUE,
        senha VARCHAR(100) NOT NULL,
        tipo VARCHAR(30) NOT NULL DEFAULT 'cliente'
    )");

    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(80) NOT NULL,
        sobrenome VARCHAR(80) NOT NULL,
        cpf VARCHAR(20) NOT NULL,
        data_nascimento DATE NOT NULL,
        telefone VARCHAR(30) NOT NULL,
        email VARCHAR(160) NOT NULL UNIQUE,
        senha VARCHAR(100) NOT NULL,
        foto VARCHAR(255)
    )");

    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS funcionarios (
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
    )");

    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(160) NOT NULL,
        marca VARCHAR(120) NOT NULL,
        descricao TEXT NOT NULL,
        valor DECIMAL(10,2) NOT NULL,
        quantidade INT NOT NULL,
        imagem VARCHAR(255) NOT NULL DEFAULT 'img/produto1.png'
    )");

    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS lojas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(140) NOT NULL,
        cnpj VARCHAR(30) NOT NULL,
        endereco VARCHAR(180) NOT NULL,
        telefone VARCHAR(30) NOT NULL
    )");

    mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS cupons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        codigo VARCHAR(40) NOT NULL UNIQUE,
        descricao VARCHAR(180) NOT NULL,
        desconto DECIMAL(5,2) NOT NULL,
        validade DATE NOT NULL
    )");

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
    if ($resultado && mysqli_num_rows($resultado) == 0) {
        mysqli_query($conexao, $sql);
    }
}

function deixarSenhaHashAntigaNula($conexao, $tabela)
{
    $resultado = mysqli_query($conexao, "SHOW COLUMNS FROM $tabela LIKE 'senha_hash'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        mysqli_query($conexao, "ALTER TABLE $tabela MODIFY senha_hash VARCHAR(255) NULL");
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
        $imagens = array('img/produto1.png', 'img/produto2.png', 'img/produto3.png', 'img/produto4.png', 'img/produto5.png');
        foreach ($imagens as $imagem) {
            mysqli_query($conexao, "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, '$imagem')");
        }
    }
}

class Produto
{
    private $nome;
    private $marca;
    private $descricao;
    private $valor;
    private $quantidade;
    private $imagem;

    public function __construct($nome, $marca, $descricao, $valor, $quantidade, $imagem)
    {
        $this->nome = $nome;
        $this->marca = $marca;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->quantidade = $quantidade;
        $this->imagem = $imagem;
    }

    public function getNome() { return $this->nome; }
    public function getMarca() { return $this->marca; }
    public function getDescricao() { return $this->descricao; }
    public function getValor() { return $this->valor; }
    public function getQuantidade() { return $this->quantidade; }
    public function getImagem() { return $this->imagem; }
    public function setValor($valor) { $this->valor = $valor; }
    public function atualizarValor($percentual) { $this->valor = $this->valor + ($this->valor * $percentual / 100); }
}

class Cliente
{
    private $nome;
    private $sobrenome;
    private $cpf;
    private $dataNascimento;
    private $telefone;
    private $email;
    private $senha;

    public function __construct($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha)
    {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function getNome() { return $this->nome; }
    public function getSobrenome() { return $this->sobrenome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
}

class Funcionario
{
    private $nome;
    private $sobrenome;
    private $cpf;
    private $dataNascimento;
    private $telefone;
    private $email;
    private $senha;
    private $cargo;
    private $salario;

    public function __construct($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha, $cargo, $salario)
    {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
        $this->cargo = $cargo;
        $this->salario = $salario;
    }

    public function getNome() { return $this->nome; }
    public function getSobrenome() { return $this->sobrenome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getCargo() { return $this->cargo; }
    public function getSalario() { return $this->salario; }
}
class Loja
{
    private $nome;
    private $cnpj;
    private $endereco;
    private $telefone;
    public function __construct($nome, $cnpj, $endereco, $telefone) { $this->nome = $nome; $this->cnpj = $cnpj; $this->endereco = $endereco; $this->telefone = $telefone; }
    public function getNome() { return $this->nome; }
    public function getCnpj() { return $this->cnpj; }
    public function getEndereco() { return $this->endereco; }
    public function getTelefone() { return $this->telefone; }
}

class Cupom
{
    private $codigo;
    private $descricao;
    private $desconto;
    private $validade;
    public function __construct($codigo, $descricao, $desconto, $validade) { $this->codigo = $codigo; $this->descricao = $descricao; $this->desconto = $desconto; $this->validade = $validade; }
    public function getCodigo() { return $this->codigo; }
    public function getDescricao() { return $this->descricao; }
    public function getDesconto() { return $this->desconto; }
    public function getValidade() { return $this->validade; }
}

function limpar($valor)
{
    return mysqli_real_escape_string(conectarBanco(), $valor);
}

function loginUsuario($email, $senha)
{
    $email = limpar($email);
    $senha = limpar($senha);
    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        return true;
    }
    return false;
}

function redefinirSenha($email, $senha)
{
    $email = limpar($email);
    $senha = limpar($senha);
    mysqli_query(conectarBanco(), "UPDATE usuarios SET senha = '$senha' WHERE email = '$email'");
    return mysqli_affected_rows(conectarBanco()) > 0;
}

function cadastrarCliente($dados)
{
    $cliente = new Cliente($dados['nome'], $dados['sobrenome'], $dados['cpf'], $dados['data_nascimento'], $dados['telefone'], $dados['email'], $dados['senha']);
    $sql = "INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, senha) VALUES ('" . limpar($cliente->getNome()) . "', '" . limpar($cliente->getSobrenome()) . "', '" . limpar($cliente->getCpf()) . "', '" . limpar($cliente->getDataNascimento()) . "', '" . limpar($cliente->getTelefone()) . "', '" . limpar($cliente->getEmail()) . "', '" . limpar($cliente->getSenha()) . "')";
    mysqli_query(conectarBanco(), $sql);
    mysqli_query(conectarBanco(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('" . limpar($cliente->getNome()) . "', '" . limpar($cliente->getEmail()) . "', '" . limpar($cliente->getSenha()) . "', 'cliente')");
}

function cadastrarFuncionario($dados)
{
    $funcionario = new Funcionario($dados['nome'], $dados['sobrenome'], $dados['cpf'], $dados['data_nascimento'], $dados['telefone'], $dados['email'], $dados['senha'], $dados['cargo'], $dados['salario']);
    mysqli_query(conectarBanco(), "INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha) VALUES ('" . limpar($funcionario->getNome()) . "', '" . limpar($funcionario->getSobrenome()) . "', '" . limpar($funcionario->getCpf()) . "', '" . limpar($funcionario->getDataNascimento()) . "', '" . limpar($funcionario->getTelefone()) . "', '" . limpar($funcionario->getCargo()) . "', '" . limpar($funcionario->getSalario()) . "', '" . limpar($funcionario->getEmail()) . "', '" . limpar($funcionario->getSenha()) . "')");
    mysqli_query(conectarBanco(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('" . limpar($funcionario->getNome()) . "', '" . limpar($funcionario->getEmail()) . "', '" . limpar($funcionario->getSenha()) . "', 'funcionario')");
}

function cadastrarProduto($dados)
{
    if ($dados['imagem'] != '') {
        $imagem = $dados['imagem'];
    } else {
        $imagem = 'img/produto1.png';
    }
    $produto = new Produto($dados['nome'], $dados['marca'], $dados['descricao'], $dados['valor'], $dados['quantidade'], $imagem);
    mysqli_query(conectarBanco(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('" . limpar($produto->getNome()) . "', '" . limpar($produto->getMarca()) . "', '" . limpar($produto->getDescricao()) . "', '" . limpar($produto->getValor()) . "', '" . limpar($produto->getQuantidade()) . "', '" . limpar($produto->getImagem()) . "')");
}

function cadastrarLoja($dados)
{
    $loja = new Loja($dados['nome'], $dados['cnpj'], $dados['endereco'], $dados['telefone']);
    mysqli_query(conectarBanco(), "INSERT INTO lojas (nome, cnpj, endereco, telefone) VALUES ('" . limpar($loja->getNome()) . "', '" . limpar($loja->getCnpj()) . "', '" . limpar($loja->getEndereco()) . "', '" . limpar($loja->getTelefone()) . "')");
}

function cadastrarCupom($dados)
{
    $cupom = new Cupom($dados['codigo'], $dados['descricao'], $dados['desconto'], $dados['validade']);
    mysqli_query(conectarBanco(), "INSERT INTO cupons (codigo, descricao, desconto, validade) VALUES ('" . limpar($cupom->getCodigo()) . "', '" . limpar($cupom->getDescricao()) . "', '" . limpar($cupom->getDesconto()) . "', '" . limpar($cupom->getValidade()) . "')");
}

function listarRegistros($tabela)
{
    $permitidas = array('clientes', 'funcionarios', 'produtos', 'lojas', 'cupons');
    if (!in_array($tabela, $permitidas)) { return array(); }
    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM $tabela ORDER BY id DESC");
    $dados = array();
    while ($linha = mysqli_fetch_assoc($resultado)) { $dados[] = $linha; }
    return $dados;
}

function listarProdutos()
{
    return listarRegistros('produtos');
}

function buscarProduto($id)
{
    $id = (int)$id;
    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM produtos WHERE id = $id");
    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}

function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function dinheiro($valor)
{
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
}

function exigirLogin()
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}

function menuPrincipal()
{
    return '<a href="index.php"><p>Home</p></a>
        <a href="cadastrocliente.php"><p>Cadastro Cliente</p></a>
        <a href="cadastrofuncionario.php"><p>Cadastro FuncionÃƒÆ’Ã‚Â¡rio</p></a>
        <a href="cadastrarproduto.php"><p>Cadastro Produto</p></a>
        <a href="cadastroloja.php"><p>Cadastro Loja</p></a>
        <a href="cadastrocupom.php"><p>Cadastro Cupons</p></a>
        <a href="clientes.php"><p>Ver Clientes</p></a>
        <a href="funcionarios.php"><p>Ver FuncionÃƒÆ’Ã‚Â¡rios</p></a>
        <a href="produtos.php"><p>Ver Produtos</p></a>
        <a href="lojas.php"><p>Ver Lojas</p></a>
        <a href="cupons.php"><p>Ver Cupons</p></a>';
}
?>




