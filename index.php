<?php
require_once __DIR__ . '/includes/App.php';
$produtos = listarProdutos();
?>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <title>Xhopii.com</title>
    <link rel="stylesheet" href="index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  </head>

  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <header>
      <section class="cabecalho">
        <section class="cabecalho-logo">
          <img src="img/logo.png" />
          <h1>Xhopii</h1>
        </section>
        <?php if (!empty($_SESSION['usuario_id'])): ?>
          <a href="logout.php"><h2>Sair</h2></a>
        <?php else: ?>
          <a href="login.php"><h2>Login</h2></a>
        <?php endif; ?>
      </section>

      <section class="super-aba">
        <?php echo menuPrincipal() ?>
      </section>
    </header>

    <div class="carousel-wrapper">
      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active"><img src="img/xhopii_1.png" class="d-block w-100" alt="..." /></div>
          <div class="carousel-item"><img src="img/xhopii_2.png" class="d-block w-100" alt="..." /></div>
          <div class="carousel-item"><img src="img/xhopii_3.png" class="d-block w-100" alt="..." /></div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
      </div>
    </div>

    <div class="imagem"><img src="img/xhopii_4.png" /></div>

    <section class="descobertas">
      <h3 class="descobertas-titulo">DESCOBERTAS DO DIA</h3>
      <div class="produtos-grid">
        <?php foreach ($produtos as $produto): ?>
          <div class="produto-card">
            <a href="xhoppi.php?id=<?php echo (int)$produto['id'] ?>"><img src="<?php echo h($produto['imagem']) ?>" alt="<?php echo h($produto['nome']) ?>" /></a>
            <p class="produto-nome"><?php echo h($produto['nome']) ?></p>
            <div class="produto-info">
              <span class="produto-preco"><?php echo dinheiro($produto['valor']) ?></span>
              <span class="produto-estoque"><?php echo (int)$produto['quantidade'] ?> disponÃ­veis</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </body>
</html>

