<?php

session_start();

require_once __DIR__ . '/../controller/Controlador.php';

$controlador = new Controlador();

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['acao']) && $_POST['acao'] == 'login') {
    if ($controlador->loginUsuario($_POST['email'], $_POST['senha'])) {
        header('Location:../view/index.php');
    } else {
        header('Location:../view/login.php?erro=1');
    }
    die();
}

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['acao']) && $_POST['acao'] == 'redefinir_senha') {
    if ($controlador->redefinirSenha($_POST['email'], $_POST['senha'])) {
        header('Location:../view/redefinir_senha.php?mensagem=1');
    } else {
        header('Location:../view/redefinir_senha.php?erro=1');
    }
    die();
}

if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['cpf']) && isset($_POST['data_nascimento']) && isset($_POST['telefone']) && isset($_POST['email']) && isset($_POST['senha']) && !isset($_POST['cargo'])) {
    $controlador->cadastrarCliente($_POST);
    header('Location:../view/cadastrocliente.php?mensagem=1');
    die();
}

if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['cpf']) && isset($_POST['data_nascimento']) && isset($_POST['telefone']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['cargo']) && isset($_POST['salario'])) {
    $controlador->cadastrarFuncionario($_POST);
    header('Location:../view/cadastrofuncionario.php?mensagem=1');
    die();
}

if (isset($_POST['nome']) && isset($_POST['marca']) && isset($_POST['descricao']) && isset($_POST['valor']) && isset($_POST['quantidade'])) {
    $controlador->cadastrarProduto($_POST);
    header('Location:../view/cadastrarproduto.php?mensagem=1');
    die();
}

if (isset($_POST['nome']) && isset($_POST['cnpj']) && isset($_POST['endereco']) && isset($_POST['telefone'])) {
    $controlador->cadastrarLoja($_POST);
    header('Location:../view/cadastroloja.php?mensagem=1');
    die();
}

if (isset($_POST['codigo']) && isset($_POST['descricao']) && isset($_POST['desconto']) && isset($_POST['validade'])) {
    $controlador->cadastrarCupom($_POST);
    header('Location:../view/cadastrocupom.php?mensagem=1');
    die();
}

header('Location:../view/index.php');
die();

?>
