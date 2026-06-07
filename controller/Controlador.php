<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/BancoDeDados.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../model/Funcionario.php';
require_once __DIR__ . '/../model/Loja.php';
require_once __DIR__ . '/../model/Cupom.php';

class Controlador
{
    // Atributo
    private $bancoDeDados;

    // Construtor
    public function __construct()
    {
        $this->bancoDeDados = new BancoDeDados('localhost', 'root', '', 'xhopii_integrado');
    }

    public function cadastrarCliente($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha)
    {
        $cliente = new Cliente($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha);
        $this->bancoDeDados->inserirCliente($cliente);
    }

    public function cadastrarFuncionario($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha, $cargo, $salario)
    {
        $funcionario = new Funcionario($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha, $cargo, $salario);
        $this->bancoDeDados->inserirFuncionario($funcionario);
    }

    public function cadastrarProduto($nome, $marca, $descricao, $valor, $quantidade, $imagem)
    {
        $produto = new Produto($nome, $marca, $descricao, $valor, $quantidade, $imagem);
        $this->bancoDeDados->inserirProduto($produto);
    }

    public function cadastrarLoja($nome, $cnpj, $endereco, $telefone)
    {
        $loja = new Loja($nome, $cnpj, $endereco, $telefone);
        $this->bancoDeDados->inserirLoja($loja);
    }

    public function cadastrarCupom($codigo, $descricao, $desconto, $validade)
    {
        $cupom = new Cupom($codigo, $descricao, $desconto, $validade);
        $this->bancoDeDados->inserirCupom($cupom);
    }

    public function editarCupom($id, $codigo, $descricao, $desconto, $validade)
    {
        $cupom = new Cupom($codigo, $descricao, $desconto, $validade);
        return $this->bancoDeDados->alterarCupom($id, $cupom);
    }

    public function excluirCupom($id)
    {
        return $this->bancoDeDados->excluirCupom($id);
    }

    public function visualizarClientes()
    {
        return $this->bancoDeDados->retornarClientes();
    }

    public function visualizarFuncionarios()
    {
        return $this->bancoDeDados->retornarFuncionarios();
    }

    public function visualizarProdutos()
    {
        return $this->bancoDeDados->retornarProdutos();
    }

    public function visualizarLojas()
    {
        return $this->bancoDeDados->retornarLojas();
    }

    public function visualizarCupons()
    {
        return $this->bancoDeDados->retornarCupons();
    }

    public function visualizarProduto($id)
    {
        return $this->bancoDeDados->retornarProdutoPorId($id);
    }

    public function loginUsuario($email, $senha)
    {
        $usuario = $this->bancoDeDados->autenticarUsuario($email, $senha);

        if ($usuario == null) {
            return false;
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        return true;
    }

    public function redefinirSenha($email, $senha)
    {
        return $this->bancoDeDados->redefinirSenha($email, $senha);
    }

    public function exigirLogin()
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: login.php');
            exit;
        }
    }
}

?>
