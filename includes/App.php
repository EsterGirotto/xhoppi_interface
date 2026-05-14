<?php
class Database
{
    private $pdo;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'xhopii_integrado';
        $user = 'root';
        $pass = '';
        $pdo = new PDO('mysql:host=' . $host . ';charset=utf8', $user, $pass, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8 COLLATE utf8_general_ci");
        $pdo->exec("USE `$db`");
        $this->pdo = $pdo;
        $this->criarTabelas();
        $this->criarDadosIniciais();
    }

    public function conexao()
    {
        return $this->pdo;
    }

    private function criarTabelas()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(120) NOT NULL,
            email VARCHAR(160) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            tipo VARCHAR(30) NOT NULL DEFAULT 'cliente',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(80) NOT NULL,
            sobrenome VARCHAR(80) NOT NULL,
            cpf VARCHAR(20) NOT NULL,
            data_nascimento DATE NOT NULL,
            telefone VARCHAR(30) NOT NULL,
            email VARCHAR(160) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            foto VARCHAR(255) NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS funcionarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(80) NOT NULL,
            sobrenome VARCHAR(80) NOT NULL,
            cpf VARCHAR(20) NOT NULL,
            data_nascimento DATE NOT NULL,
            telefone VARCHAR(30) NOT NULL,
            cargo VARCHAR(90) NOT NULL,
            salario DECIMAL(10,2) NOT NULL,
            email VARCHAR(160) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            foto VARCHAR(255) NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(160) NOT NULL,
            marca VARCHAR(120) NOT NULL,
            descricao TEXT NOT NULL,
            valor DECIMAL(10,2) NOT NULL,
            quantidade INT NOT NULL,
            imagem VARCHAR(255) NOT NULL DEFAULT 'img/produto1.png',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS lojas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(140) NOT NULL,
            cnpj VARCHAR(30) NOT NULL,
            endereco VARCHAR(180) NOT NULL,
            telefone VARCHAR(30) NOT NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS cupons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(40) NOT NULL UNIQUE,
            descricao VARCHAR(180) NOT NULL,
            desconto DECIMAL(5,2) NOT NULL,
            validade DATE NOT NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    private function criarDadosIniciais()
    {
        if ((int)$this->pdo->query('SELECT COUNT(*) FROM usuarios')->fetchColumn() === 0) {
            $senha = password_hash('123456', PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?)');
            $stmt->execute(array('Administrador Xhopii', 'admin@xhopii.com', $senha, 'funcionario'));
        }

        if ((int)$this->pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn() === 0) {
            $stmt = $this->pdo->prepare('INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES (?, ?, ?, ?, ?, ?)');
            $imagens = array('img/produto1.png', 'img/produto2.png', 'img/produto3.png', 'img/produto4.png', 'img/produto5.png');
            foreach ($imagens as $imagem) {
                $stmt->execute(array('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, $imagem));
            }
        }
    }
}

abstract class Pessoa
{
    protected $nome;
    protected $email;
    protected $telefone;

    public function __construct($nome, $email, $telefone)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getTelefone() { return $this->telefone; }
}

class Cliente extends Pessoa
{
    private $sobrenome;
    private $cpf;
    private $dataNascimento;

    public function __construct($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email)
    {
        parent::__construct($nome, $email, $telefone);
        $this->sobrenome = $sobrenome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
    }

    public function verificarMaiorIdade()
    {
        return (new DateTime($this->dataNascimento))->diff(new DateTime())->y >= 18;
    }
}

class Funcionario extends Pessoa
{
    private $cargo;
    private $salario;

    public function __construct($nome, $email, $telefone, $cargo, $salario)
    {
        parent::__construct($nome, $email, $telefone);
        $this->cargo = $cargo;
        $this->salario = $salario;
    }
}

class Produto
{
    private $id;
    private $nome;
    private $marca;
    private $descricao;
    private $valor;
    private $quantidade;
    private $imagem;

    public function __construct($id, $nome, $marca, $descricao, $valor, $quantidade, $imagem)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->marca = $marca;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->quantidade = $quantidade;
        $this->imagem = $imagem;
    }

    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getMarca() { return $this->marca; }
    public function getDescricao() { return $this->descricao; }
    public function getValor() { return $this->valor; }
    public function getQuantidade() { return $this->quantidade; }
    public function getImagem() { return $this->imagem; }
    public function setValor($valor) { $this->valor = $valor; }

    public function atualizarValor($percentual)
    {
        $this->valor += $this->valor * ($percentual / 100);
    }
}

class Loja
{
    private $nome;
    private $cnpj;
    private $endereco;
    private $telefone;

    public function __construct($nome, $cnpj, $endereco, $telefone)
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
    }
}

class Cupom
{
    private $codigo;
    private $descricao;
    private $desconto;
    private $validade;

    public function __construct($codigo, $descricao, $desconto, $validade)
    {
        $this->codigo = $codigo;
        $this->descricao = $descricao;
        $this->desconto = $desconto;
        $this->validade = $validade;
    }
}

class Repositorio
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->conexao();
    }
}

class AuthService extends Repositorio
{
    public function login($email, $senha)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute(array($email));
        $usuario = $stmt->fetch();
        if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
            return false;
        }
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        return true;
    }

    public function redefinirSenha($email, $senha)
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('UPDATE usuarios SET senha_hash = ? WHERE email = ?');
        $stmt->execute(array($hash, $email));
        $ok = $stmt->rowCount() > 0;
        if (!$ok) {
            $stmtCliente = $this->pdo->prepare('SELECT nome FROM clientes WHERE email = ?');
            $stmtCliente->execute(array($email));
            $cliente = $stmtCliente->fetch();
            if ($cliente) {
                $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?)')->execute(array($cliente['nome'], $email, $hash, 'cliente'));
                $ok = true;
            }
        }
        return $ok;
    }
}

class ProdutoRepositorio extends Repositorio
{
    public function todos()
    {
        return $this->pdo->query('SELECT * FROM produtos ORDER BY id DESC')->fetchAll();
    }

    public function buscar($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id = ?');
        $stmt->execute(array($id));
        $produto = $stmt->fetch();
        return $produto ? $produto : null;
    }

    public function cadastrar($dados)
    {
        $imagem = isset($dados['imagem']) && $dados['imagem'] !== '' ? $dados['imagem'] : 'img/produto1.png';
        $stmt = $this->pdo->prepare('INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute(array($dados['nome'], $dados['marca'], $dados['descricao'], $dados['valor'], $dados['quantidade'], $imagem));
    }
}

class CadastroRepositorio extends Repositorio
{
    public function cliente($d)
    {
        $hash = password_hash($d['senha'], PASSWORD_DEFAULT);
        $this->pdo->prepare('INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, senha_hash) VALUES (?, ?, ?, ?, ?, ?, ?)')->execute(array($d['nome'], $d['sobrenome'], $d['cpf'], $d['data_nascimento'], $d['telefone'], $d['email'], $hash));
        $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE senha_hash = VALUES(senha_hash)')->execute(array($d['nome'], $d['email'], $hash, 'cliente'));
    }

    public function funcionario($d)
    {
        $hash = password_hash($d['senha'], PASSWORD_DEFAULT);
        $this->pdo->prepare('INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')->execute(array($d['nome'], $d['sobrenome'], $d['cpf'], $d['data_nascimento'], $d['telefone'], $d['cargo'], $d['salario'], $d['email'], $hash));
        $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE senha_hash = VALUES(senha_hash)')->execute(array($d['nome'], $d['email'], $hash, 'funcionario'));
    }

    public function loja($d)
    {
        $this->pdo->prepare('INSERT INTO lojas (nome, cnpj, endereco, telefone) VALUES (?, ?, ?, ?)')->execute(array($d['nome'], $d['cnpj'], $d['endereco'], $d['telefone']));
    }

    public function cupom($d)
    {
        $this->pdo->prepare('INSERT INTO cupons (codigo, descricao, desconto, validade) VALUES (?, ?, ?, ?)')->execute(array($d['codigo'], $d['descricao'], $d['desconto'], $d['validade']));
    }

    public function listar($tabela)
    {
        $permitidas = array('clientes', 'funcionarios', 'produtos', 'lojas', 'cupons');
        if (!in_array($tabela, $permitidas, true)) {
            return array();
        }
        return $this->pdo->query("SELECT * FROM $tabela ORDER BY id DESC")->fetchAll();
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
        <a href="cadastrofuncionario.php"><p>Cadastro Funcionário</p></a>
        <a href="cadastrarproduto.php"><p>Cadastro Produto</p></a>
        <a href="cadastroloja.php"><p>Cadastro Loja</p></a>
        <a href="cadastrocupom.php"><p>Cadastro Cupons</p></a>
        <a href="clientes.php"><p>Ver Clientes</p></a>
        <a href="funcionarios.php"><p>Ver Funcionários</p></a>
        <a href="produtos.php"><p>Ver Produtos</p></a>
        <a href="lojas.php"><p>Ver Lojas</p></a>
        <a href="cupons.php"><p>Ver Cupons</p></a>';
}

session_start();
?>
