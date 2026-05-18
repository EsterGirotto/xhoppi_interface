<?php
function listarRegistros($tabela)
{
    $permitidas = array('clientes', 'funcionarios', 'produtos', 'lojas', 'cupons');
    $permitido = false;

    foreach ($permitidas as $item) {
        if ($item == $tabela) {
            $permitido = true;
        }
    }

    if ($permitido == false) {
        return array();
    }

    $resultado = mysqli_query(conectarBanco(), "SELECT * FROM $tabela ORDER BY id DESC");
    $dados = array();

    if ($resultado) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $dados[] = $linha;
        }
    }

    return $dados;
}
?>
