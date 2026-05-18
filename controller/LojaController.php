<?php
function cadastrarLoja($dados)
{
    $loja = new Loja($dados['nome'], $dados['cnpj'], $dados['endereco'], $dados['telefone']);
    $nome = limpar($loja->getNome());
    $cnpj = limpar($loja->getCnpj());
    $endereco = limpar($loja->getEndereco());
    $telefone = limpar($loja->getTelefone());
    mysqli_query(conectarBanco(), "INSERT INTO lojas (nome, cnpj, endereco, telefone) VALUES ('$nome', '$cnpj', '$endereco', '$telefone')");
}
?>
