<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$produtos = $controlador->visualizarProdutos();
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <title>Xhopii.com</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../assets/js/carrossel.js" defer></script>
  </head>
  <body>
    <?php echo cabecalhoPrincipal() ?>

    <div class="carousel-wrapper">
      <div class="carousel slide" data-carrossel>
        <div class="carousel-indicators">
          <button type="button" class="active" data-carrossel-indicador="0" aria-label="Slide 1"></button>
          <button type="button" data-carrossel-indicador="1" aria-label="Slide 2"></button>
          <button type="button" data-carrossel-indicador="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active"><img src="../assets/img/xhopii_1.png" alt="Oferta Xhopii"></div>
          <div class="carousel-item"><img src="../assets/img/xhopii_2.png" alt="Promocao Xhopii"></div>
          <div class="carousel-item"><img src="../assets/img/xhopii_3.png" alt="Novidades Xhopii"></div>
        </div>
        <button class="carousel-control-prev" type="button" data-carrossel-anterior aria-label="Slide anterior"><span>&#10094;</span></button>
        <button class="carousel-control-next" type="button" data-carrossel-proximo aria-label="Proximo slide"><span>&#10095;</span></button>
      </div>
    </div>

    <div class="imagem"><img src="../assets/img/xhopii_4.png" alt="Beneficios Xhopii"></div>

    <section class="descobertas">
      <h3 class="descobertas-titulo">DESCOBERTAS DO DIA</h3>
      <div class="produtos-grid">
        <?php foreach ($produtos as $produto) { ?>
          <div class="produto-card">
            <a href="xhoppi.php?id=<?php echo (int)$produto['id'] ?>"><img src="<?php echo h(caminhoImagem($produto['imagem'])) ?>" alt="<?php echo h($produto['nome']) ?>"></a>
            <p class="produto-nome"><?php echo h($produto['nome']) ?></p>
            <div class="produto-info">
              <span class="produto-preco"><?php echo dinheiro($produto['valor']) ?></span>
              <span class="produto-estoque"><?php echo (int)$produto['quantidade'] ?> disponiveis</span>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>

    <?php require __DIR__ . '/rodape.php'; ?>
  </body>
</html>
