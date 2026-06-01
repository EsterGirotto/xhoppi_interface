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
    private $bancoDeDados;

    public function __construct()
    {
        $this->bancoDeDados = new BancoDeDados('localhost', 'root', '', 'xhopii_integrado');
    }

    public function getBancoDeDados()
    {
        return $this->bancoDeDados;
    }

    public function cadastrarCliente($dados)
    {
        $cliente = new Cliente(
            $dados['nome'],
            $dados['sobrenome'],
            $dados['cpf'],
            $dados['data_nascimento'],
            $dados['telefone'],
            $dados['email'],
            $dados['senha']
        );

        $this->bancoDeDados->inserirCliente($cliente);
    }

    public function cadastrarFuncionario($dados)
    {
        $funcionario = new Funcionario(
            $dados['nome'],
            $dados['sobrenome'],
            $dados['cpf'],
            $dados['data_nascimento'],
            $dados['telefone'],
            $dados['email'],
            $dados['senha'],
            $dados['cargo'],
            $dados['salario']
        );

        $this->bancoDeDados->inserirFuncionario($funcionario);
    }

    public function cadastrarProduto($dados)
    {
        if (!empty($dados['imagem'])) {
            $imagem = $dados['imagem'];
        } else {
            $imagem = 'img/produto1.png';
        }

        $produto = new Produto(
            $dados['nome'],
            $dados['marca'],
            $dados['descricao'],
            $dados['valor'],
            $dados['quantidade'],
            $imagem
        );

        $this->bancoDeDados->inserirProduto($produto);
    }

    public function cadastrarLoja($dados)
    {
        $loja = new Loja($dados['nome'], $dados['cnpj'], $dados['endereco'], $dados['telefone']);
        $this->bancoDeDados->inserirLoja($loja);
    }

    public function cadastrarCupom($dados)
    {
        $cupom = new Cupom($dados['codigo'], $dados['descricao'], $dados['desconto'], $dados['validade']);
        $this->bancoDeDados->inserirCupom($cupom);
    }

    public function listarRegistros($tabela)
    {
        return $this->bancoDeDados->retornarRegistros($tabela);
    }

    public function listarProdutos()
    {
        return $this->bancoDeDados->retornarProdutos();
    }

    public function buscarProduto($id)
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

function appControlador()
{
    static $controlador = null;

    if ($controlador == null) {
        $controlador = new Controlador();
    }

    return $controlador;
}

function limpar($valor)
{
    return mysqli_real_escape_string(conectarBanco(), (string)$valor);
}

?>
