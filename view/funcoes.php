<?php

function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function dinheiro($valor)
{
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
}

function caminhoImagem($imagem)
{
    if (strpos($imagem, 'http') === 0 || strpos($imagem, '../') === 0) {
        return $imagem;
    }

    if (strpos($imagem, 'img/') === 0) {
        return '../assets/' . $imagem;
    }

    return $imagem;
}

function menuPrincipal()
{
    return '<p><a href="index.php">Home</a></p>
        <p><a href="cadastrocliente.php">Cadastro Cliente</a></p>
        <p><a href="cadastrofuncionario.php">Cadastro Funcionario</a></p>
        <p><a href="cadastrarproduto.php">Cadastro Produto</a></p>
        <p><a href="cadastroloja.php">Cadastro Loja</a></p>
        <p><a href="cadastrocupom.php">Cadastro Cupons</a></p>
        <p><a href="clientes.php">Ver Clientes</a></p>
        <p><a href="funcionarios.php">Ver Funcionarios</a></p>
        <p><a href="produtos.php">Ver Produtos</a></p>
        <p><a href="lojas.php">Ver Lojas</a></p>
        <p><a href="cupons.php">Ver Cupons</a></p>';
}

function cabecalhoPrincipal($autenticado = true)
{
    $url = $autenticado ? 'logout.php' : 'login.php';
    $texto = $autenticado ? 'Sair' : 'Login';

    return '<header>
        <section class="cabecalho">
            <section class="cabecalho-logo">
                <img src="../assets/img/logo.png">
                <h1>Xhopii</h1>
            </section>
            <a href="' . $url . '"><h2>' . $texto . '</h2></a>
        </section>
        <section class="super-aba">' . menuPrincipal() . '</section>
    </header>';
}

?>
