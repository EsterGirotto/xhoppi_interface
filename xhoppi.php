<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$repo = new ProdutoRepositorio();
$produto = $repo->buscar((int)(isset($_GET['id']) ? $_GET['id'] : 1));
$todos = $repo->todos();
if (!$produto) { $produto = count($todos) > 0 ? $todos[0] : null; }
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
        <section class="cabecalho-logo"><img src="img/logo.png"><h1>Xhopii</h1></section>
    </section>
    <section class="super-aba"><?= menuPrincipal() ?></section>
    </header>

    <footer>
    <section class="roupas">
        <div class="roupas-pequenas">
            <img src="img/produto1.png"><img src="img/produto2.png"><img src="img/produto3.png"><img src="img/produto4.png"><img src="img/produto5.png">
        </div>
        <div class="roupa-grande"><img src="<?= h(isset($produto['imagem']) ? $produto['imagem'] : 'img/produto1.png') ?>"></div>
        <div class="infos">
            <h2><?= h(isset($produto['nome']) ? $produto['nome'] : 'Produto não encontrado') ?></h2>
            <h3><?= dinheiro(isset($produto['valor']) ? $produto['valor'] : 0) ?></h3>
            <p><?= (int)(isset($produto['quantidade']) ? $produto['quantidade'] : 0) ?> Peças Disponíveis</p>
            <p class="label">Modelos:</p>
            <div class="opcoes"><button>Preto</button><button>Azul</button><button>Verde</button><button>Cinza</button><button>Rosa</button></div>
            <p class="label">Tamanhos:</p>
            <div class="opcoes"><button>P</button><button>M</button><button>G</button><button>GG</button></div>
            <p>Tamanho Selecionado: P</p>
            <button class="comprar">Comprar Agora</button>
        </div>
    </section>
</footer>
</body>
</html>
