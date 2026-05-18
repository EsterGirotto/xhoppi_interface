<?php
function cadastrarCupom($dados)
{
    $cupom = new Cupom($dados['codigo'], $dados['descricao'], $dados['desconto'], $dados['validade']);
    $codigo = limpar($cupom->getCodigo());
    $descricao = limpar($cupom->getDescricao());
    $desconto = limpar($cupom->getDesconto());
    $validade = limpar($cupom->getValidade());
    mysqli_query(conectarBanco(), "INSERT INTO cupons (codigo, descricao, desconto, validade) VALUES ('$codigo', '$descricao', '$desconto', '$validade')");
}
?>
