<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();

if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];
} else {
    $idProduto = 1;
}

$produto = buscarProduto((int)$idProduto);
$todos = listarProdutos();

if (!$produto) {
    if (count($todos) > 0) {
        $produto = $todos[0];
    } else {
        $produto = null;
    }
}

if ($produto) {
    $imagemProduto = $produto['imagem'];
    $nomeProduto = $produto['nome'];
    $valorProduto = $produto['valor'];
    $quantidadeProduto = $produto['quantidade'];
} else {
    $imagemProduto = 'img/produto1.png';
    $nomeProduto = 'Produto não encontrado';
    $valorProduto = 0;
    $quantidadeProduto = 0;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>xhoppi.com</title>
    <link rel="stylesheet" href="xhoppi.css">
</head>
<body>
    <header>
        <section class="cabecalho">
            <section class="cabecalho-logo">
                <img src="img/logo.png">
                <h1>Xhopii</h1>
            </section>
        </section>
        <section class="super-aba"><?php echo menuPrincipal(); ?></section>
    </header>

    <footer>
        <section class="roupas">
            <div class="roupas-pequenas">
                <img src="img/produto1.png">
                <img src="img/produto2.png">
                <img src="img/produto3.png">
                <img src="img/produto4.png">
                <img src="img/produto5.png">
            </div>

            <div class="roupa-grande">
                <img src="<?php echo h($imagemProduto); ?>">
            </div>

            <div class="infos">
                <h2><?php echo h($nomeProduto); ?></h2>
                <h3><?php echo dinheiro($valorProduto); ?></h3>
                <p><?php echo (int)$quantidadeProduto; ?> Peças Disponíveis</p>

                <p class="label">Modelos:</p>
                <div class="opcoes">
                    <button>Preto</button>
                    <button>Azul</button>
                    <button>Verde</button>
                    <button>Cinza</button>
                    <button>Rosa</button>
                </div>

                <p class="label">Tamanhos:</p>
                <div class="opcoes">
                    <button>P</button>
                    <button>M</button>
                    <button>G</button>
                    <button>GG</button>
                </div>

                <p>Tamanho Selecionado: P</p>
                <button class="comprar">Comprar Agora</button>
            </div>
        </section>
    </footer>
</body>
</html>
