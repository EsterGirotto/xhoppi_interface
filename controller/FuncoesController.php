<?php
function limpar($valor)
{
    return mysqli_real_escape_string(conectarBanco(), $valor);
}

function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function dinheiro($valor)
{
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
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
?>
