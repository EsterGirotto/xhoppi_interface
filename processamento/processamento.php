<?php

session_start();

require_once __DIR__ . '/../controller/Controlador.php';

$controlador = new Controlador();

// Login
if (isset($_POST['inputEmailLog']) && isset($_POST['inputSenhaLog'])) {
    $email = $_POST['inputEmailLog'];
    $senha = $_POST['inputSenhaLog'];

    if ($controlador->loginUsuario($email, $senha)) {
        header('Location:../view/index.php');
    } else {
        header('Location:../view/login.php?erro=1');
    }
    die();
}

// Redefinir senha
if (isset($_POST['inputEmailRedefinir']) && isset($_POST['inputSenhaRedefinir'])) {
    $email = $_POST['inputEmailRedefinir'];
    $senha = $_POST['inputSenhaRedefinir'];

    if ($controlador->redefinirSenha($email, $senha)) {
        header('Location:../view/redefinir_senha.php?mensagem=1');
    } else {
        header('Location:../view/redefinir_senha.php?erro=1');
    }
    die();
}

// Cadastro de Cliente
if (isset($_POST['inputNome']) && isset($_POST['inputSobrenome']) &&
    isset($_POST['inputCPF']) && isset($_POST['inputDataNasc']) &&
    isset($_POST['inputTelefone']) && isset($_POST['inputEmail']) &&
    isset($_POST['inputSenha'])) {

    $nome = $_POST['inputNome'];
    $sobrenome = $_POST['inputSobrenome'];
    $cpf = $_POST['inputCPF'];
    $dataNascimento = $_POST['inputDataNasc'];
    $telefone = $_POST['inputTelefone'];
    $email = $_POST['inputEmail'];
    $senha = $_POST['inputSenha'];

    $controlador->cadastrarCliente($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha);

    header('Location:../view/cadastrocliente.php?mensagem=1');
    die();
}

// Cadastro de Funcionario
if (isset($_POST['inputNomeFunc']) && isset($_POST['inputSobrenomeFunc']) &&
    isset($_POST['inputCPFFunc']) && isset($_POST['inputDataNascFunc']) &&
    isset($_POST['inputTelefoneFunc']) && isset($_POST['inputEmailFunc']) &&
    isset($_POST['inputSenhaFunc']) && isset($_POST['inputCargoFunc']) &&
    isset($_POST['inputSalarioFunc'])) {

    $nome = $_POST['inputNomeFunc'];
    $sobrenome = $_POST['inputSobrenomeFunc'];
    $cpf = $_POST['inputCPFFunc'];
    $dataNascimento = $_POST['inputDataNascFunc'];
    $telefone = $_POST['inputTelefoneFunc'];
    $email = $_POST['inputEmailFunc'];
    $senha = $_POST['inputSenhaFunc'];
    $cargo = $_POST['inputCargoFunc'];
    $salario = $_POST['inputSalarioFunc'];

    $controlador->cadastrarFuncionario($nome, $sobrenome, $cpf, $dataNascimento, $telefone, $email, $senha, $cargo, $salario);

    header('Location:../view/cadastrofuncionario.php?mensagem=1');
    die();
}

// Cadastro de Produto
if (!empty($_POST['inputNomeProd']) && !empty($_POST['inputFabricanteProd']) &&
    !empty($_POST['inputDescricaoProd']) && !empty($_POST['inputValorProd']) &&
    !empty($_POST['inputQuantidadeProd'])) {

    $nome = $_POST['inputNomeProd'];
    $marca = $_POST['inputFabricanteProd'];
    $descricao = $_POST['inputDescricaoProd'];
    $valor = $_POST['inputValorProd'];
    $quantidade = $_POST['inputQuantidadeProd'];
    $imagem = isset($_POST['inputImagemProd']) ? $_POST['inputImagemProd'] : '';

    $controlador->cadastrarProduto($nome, $marca, $descricao, $valor, $quantidade, $imagem);

    header('Location:../view/cadastrarproduto.php?mensagem=1');
    die();
}

// Cadastro de Loja
if (isset($_POST['inputNomeLoja']) && isset($_POST['inputCnpjLoja']) &&
    isset($_POST['inputEnderecoLoja']) && isset($_POST['inputTelefoneLoja'])) {

    $nome = $_POST['inputNomeLoja'];
    $cnpj = $_POST['inputCnpjLoja'];
    $endereco = $_POST['inputEnderecoLoja'];
    $telefone = $_POST['inputTelefoneLoja'];

    $controlador->cadastrarLoja($nome, $cnpj, $endereco, $telefone);

    header('Location:../view/cadastroloja.php?mensagem=1');
    die();
}

// Edicao e exclusao de Cupom
if (isset($_POST['acaoCupom']) && $_POST['acaoCupom'] == 'editar' &&
    isset($_POST['inputIdCupom']) && isset($_POST['inputCodigoCupom']) &&
    isset($_POST['inputDescricaoCupom']) && isset($_POST['inputDescontoCupom']) &&
    isset($_POST['inputValidadeCupom'])) {

    $id = $_POST['inputIdCupom'];
    $codigo = $_POST['inputCodigoCupom'];
    $descricao = $_POST['inputDescricaoCupom'];
    $desconto = $_POST['inputDescontoCupom'];
    $validade = $_POST['inputValidadeCupom'];

    $controlador->editarCupom($id, $codigo, $descricao, $desconto, $validade);

    header('Location:../view/cupons.php?mensagem=editado');
    die();
}

if (isset($_POST['acaoCupom']) && $_POST['acaoCupom'] == 'excluir' &&
    isset($_POST['inputIdCupom'])) {

    $id = $_POST['inputIdCupom'];

    $controlador->excluirCupom($id);

    header('Location:../view/cupons.php?mensagem=excluido');
    die();
}

// Cadastro de Cupom
if (isset($_POST['inputCodigoCupom']) && isset($_POST['inputDescricaoCupom']) &&
    isset($_POST['inputDescontoCupom']) && isset($_POST['inputValidadeCupom'])) {

    $codigo = $_POST['inputCodigoCupom'];
    $descricao = $_POST['inputDescricaoCupom'];
    $desconto = $_POST['inputDescontoCupom'];
    $validade = $_POST['inputValidadeCupom'];

    $controlador->cadastrarCupom($codigo, $descricao, $desconto, $validade);

    header('Location:../view/cadastrocupom.php?mensagem=1');
    die();
}

header('Location:../view/index.php');
die();

?>
