<?php
function cadastrarProduto($dados)
{
    if ($dados['imagem'] != '') {
        $imagem = $dados['imagem'];
    } else {
        $imagem = 'img/produto1.png';
    }

    $produto = new Produto($dados['nome'], $dados['marca'], $dados['descricao'], $dados['valor'], $dados['quantidade'], $imagem);

    $nome = limpar($produto->getNome());
    $marca = limpar($produto->getMarca());
    $descricao = limpar($produto->getDescricao());
    $valor = limpar($produto->getValor());
    $quantidade = limpar($produto->getQuantidade());
    $imagem = limpar($produto->getImagem());

    mysqli_query(conectarBanco(), "INSERT INTO produtos (nome, marca, descricao, valor, quantidade, imagem) VALUES ('$nome', '$marca', '$descricao', '$valor', '$quantidade', '$imagem')");
}

function listarProdutos()
{
    return listarRegistros('produtos');
}

function buscarProduto($id)
{
    $id = (int)$id;
    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM produtos WHERE id = $id");

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}
?>
