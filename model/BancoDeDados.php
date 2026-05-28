<?php

class BancoDeDados
{
    private $host;
    private $usuario;
    private $senha;
    private $banco;
    private $conexao;

    public function __construct($host = 'localhost', $usuario = 'root', $senha = '', $banco = 'xhopii_integrado')
    {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->banco = $banco;
        $this->conexao = null;
    }

    public function conectarBD()
    {
        if ($this->conexao != null) {
            return $this->conexao;
        }

        $this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha);

        if (!$this->conexao) {
            die('Erro ao conectar no banco de dados.');
        }

        mysqli_query($this->conexao, "CREATE DATABASE IF NOT EXISTS {$this->banco} CHARACTER SET utf8 COLLATE utf8_general_ci");
        mysqli_select_db($this->conexao, $this->banco);
        mysqli_set_charset($this->conexao, 'utf8');

        $this->criarTabelas();
        $this->criarDadosIniciais();

        return $this->conexao;
    }

    public function escapar($valor)
    {
        return mysqli_real_escape_string($this->conectarBD(), (string)$valor);
    }

    public function inserirCliente($cliente)
    {
        $nome = $this->escapar($cliente->getNome());
        $sobrenome = $this->escapar($cliente->getSobrenome());
        $cpf = $this->escapar($cliente->getCpf());
        $dataNascimento = $this->escapar($cliente->getDataNascimento());
        $telefone = $this->escapar($cliente->getTelefone());
        $email = $this->escapar($cliente->getEmail());
        $senha = $this->escapar($cliente->getSenha());

        mysqli_query($this->conectarBD(), "INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, senha) VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$email', '$senha')");
        mysqli_query($this->conectarBD(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', 'cliente')");
    }

    public function inserirFuncionario($funcionario)
    {
        $nome = $this->escapar($funcionario->getNome());
        $sobrenome = $this->escapar($funcionario->getSobrenome());
        $cpf = $this->escapar($funcionario->getCpf());
        $dataNascimento = $this->escapar($funcionario->getDataNascimento());
        $telefone = $this->escapar($funcionario->getTelefone());
        $cargo = $this->escapar($funcionario->getCargo());
        $salario = $this->escapar($funcionario->getSalario());
        $email = $this->escapar($funcionario->getEmail());
        $senha = $this->escapar($funcionario->getSenha());

        mysqli_query($this->conectarBD(), "INSERT INTO funcionarios (nome, sobrenome, cpf, data_nascimento, telefone, cargo, salario, email, senha) VALUES ('$nome', '$sobrenome', '$cpf', '$dataNascimento', '$telefone', '$cargo', '$salario', '$email', '$senha')");
        mysqli_query($this->conectarBD(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', 'funcionario')");
    }

    public function inserirProduto($produto)
    {
        $nome = $this->escapar($produto->getNome());
        $marca = $this->escapar($produto->getMarca());
        $descricao = $this->escapar($produto->getDescricao());
        $valor = $this->escapar($produto->getValor());
        $quantidade = $this->escapar($produto->getQuantidade());
        $imagem = $this->escapar($produto->getImagem());

        mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('$nome', '$marca', '$descricao', '$valor', '$quantidade', '$imagem')");
    }

    public function inserirLoja($loja)
    {
        $nome = $this->escapar($loja->getNome());
        $cnpj = $this->escapar($loja->getCnpj());
        $endereco = $this->escapar($loja->getEndereco());
        $telefone = $this->escapar($loja->getTelefone());

        mysqli_query($this->conectarBD(), "INSERT INTO lojas (nome, cnpj, endereco, telefone) VALUES ('$nome', '$cnpj', '$endereco', '$telefone')");
    }

    public function inserirCupom($cupom)
    {
        $codigo = $this->escapar($cupom->getCodigo());
        $descricao = $this->escapar($cupom->getDescricao());
        $desconto = $this->escapar($cupom->getDesconto());
        $validade = $this->escapar($cupom->getValidade());

        mysqli_query($this->conectarBD(), "INSERT INTO cupons (codigo, descricao, desconto, validade) VALUES ('$codigo', '$descricao', '$desconto', '$validade')");
    }

    public function retornarRegistros($tabela)
    {
        $permitidas = array('clientes', 'funcionarios', 'produtos', 'lojas', 'cupons');

        if (!in_array($tabela, $permitidas)) {
            return array();
        }

        $resultado = mysqli_query($this->conectarBD(), "SELECT * FROM $tabela ORDER BY id DESC");
        return $this->resultadoParaArray($resultado);
    }

    public function retornarProdutos()
    {
        return $this->retornarRegistros('produtos');
    }

    public function retornarProdutoPorId($id)
    {
        $id = (int)$id;
        $resultado = mysqli_query($this->conectarBD(), "SELECT * FROM produtos WHERE id = $id");

        if ($resultado) {
            return mysqli_fetch_assoc($resultado);
        }

        return null;
    }

    public function autenticarUsuario($email, $senha)
    {
        $email = $this->escapar($email);
        $senha = $this->escapar($senha);
        $resultado = mysqli_query($this->conectarBD(), "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }

        return null;
    }

    public function redefinirSenha($email, $senha)
    {
        $email = $this->escapar($email);
        $senha = $this->escapar($senha);
        mysqli_query($this->conectarBD(), "UPDATE usuarios SET senha = '$senha' WHERE email = '$email'");
        return mysqli_affected_rows($this->conectarBD()) > 0;
    }

    private function resultadoParaArray($resultado)
    {
        $dados = array();

        if ($resultado) {
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $dados[] = $linha;
            }
        }

        return $dados;
    }

    private function criarTabelas()
    {
        $conexao = $this->conectarBD();

        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, tipo VARCHAR(30) NOT NULL DEFAULT 'cliente')");
        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS clientes (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, sobrenome VARCHAR(80) NOT NULL, cpf VARCHAR(20) NOT NULL, data_nascimento DATE NOT NULL, telefone VARCHAR(30) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, foto VARCHAR(255))");
        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS funcionarios (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, sobrenome VARCHAR(80) NOT NULL, cpf VARCHAR(20) NOT NULL, data_nascimento DATE NOT NULL, telefone VARCHAR(30) NOT NULL, cargo VARCHAR(90) NOT NULL, salario DECIMAL(10,2) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE, senha VARCHAR(100) NOT NULL, foto VARCHAR(255))");
        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS produtos (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(160) NOT NULL, marca VARCHAR(120) NOT NULL, descricao TEXT NOT NULL, valor DECIMAL(10,2) NOT NULL, quantidade INT NOT NULL, imagem VARCHAR(255) NOT NULL DEFAULT 'img/produto1.png')");
        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS lojas (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(140) NOT NULL, cnpj VARCHAR(30) NOT NULL, endereco VARCHAR(180) NOT NULL, telefone VARCHAR(30) NOT NULL)");
        mysqli_query($conexao, "CREATE TABLE IF NOT EXISTS cupons (id INT AUTO_INCREMENT PRIMARY KEY, codigo VARCHAR(40) NOT NULL UNIQUE, descricao VARCHAR(180) NOT NULL, desconto DECIMAL(5,2) NOT NULL, validade DATE NOT NULL)");

        $this->adicionarColunaSeFaltar('usuarios', 'senha', "ALTER TABLE usuarios ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
        $this->adicionarColunaSeFaltar('clientes', 'senha', "ALTER TABLE clientes ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
        $this->adicionarColunaSeFaltar('funcionarios', 'senha', "ALTER TABLE funcionarios ADD senha VARCHAR(100) NOT NULL DEFAULT '123456'");
        $this->deixarSenhaHashAntigaNula('usuarios');
        $this->deixarSenhaHashAntigaNula('clientes');
        $this->deixarSenhaHashAntigaNula('funcionarios');
    }

    private function adicionarColunaSeFaltar($tabela, $coluna, $sql)
    {
        $resultado = mysqli_query($this->conectarBD(), "SHOW COLUMNS FROM $tabela LIKE '$coluna'");

        if ($resultado && mysqli_num_rows($resultado) == 0) {
            mysqli_query($this->conectarBD(), $sql);
        }
    }

    private function deixarSenhaHashAntigaNula($tabela)
    {
        $resultado = mysqli_query($this->conectarBD(), "SHOW COLUMNS FROM $tabela LIKE 'senha_hash'");

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            mysqli_query($this->conectarBD(), "ALTER TABLE $tabela MODIFY senha_hash VARCHAR(255) NULL");
        }
    }

    private function criarDadosIniciais()
    {
        $resultado = mysqli_query($this->conectarBD(), "SELECT COUNT(*) AS total FROM usuarios");
        $linha = mysqli_fetch_assoc($resultado);

        if ((int)$linha['total'] == 0) {
            mysqli_query($this->conectarBD(), "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('Administrador Xhopii', 'admin@xhopii.com', '123456', 'funcionario')");
        } else {
            mysqli_query($this->conectarBD(), "UPDATE usuarios SET senha = '123456' WHERE email = 'admin@xhopii.com'");
        }

        $resultado = mysqli_query($this->conectarBD(), "SELECT COUNT(*) AS total FROM produtos");
        $linha = mysqli_fetch_assoc($resultado);

        if ((int)$linha['total'] == 0) {
            mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto1.png')");
            mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto2.png')");
            mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto3.png')");
            mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto4.png')");
            mysqli_query($this->conectarBD(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('Camisa Desenvolvedor Front-End CSS', 'Eletiva Uniformes', 'Uma Camisa ideal para programar por mais de 12 horas', 59.90, 171, 'img/produto5.png')");
        }
    }
}

function conectarBanco()
{
    static $bancoDeDados = null;

    if ($bancoDeDados == null) {
        $bancoDeDados = new BancoDeDados();
    }

    return $bancoDeDados->conectarBD();
}

?>
