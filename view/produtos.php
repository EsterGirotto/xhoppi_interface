<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$produtos = $controlador->visualizarProdutos();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Produtos Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Produtos</h3>
    <div class="produtos-grid">
      <?php foreach ($produtos as $produto) { ?>
      <div class="produto-card">
        <a href="xhoppi.php?id=<?php echo (int)$produto['id'] ?>"><img src="<?php echo h(caminhoImagem($produto['imagem'])) ?>" alt="<?php echo h($produto['nome']) ?>"></a>
        <p class="produto-nome"><?php echo h($produto['nome']) ?></p>
        <p class="produto-descricao"><b>Fabricante: </b><span class="produto-desc"><?php echo h($produto['marca']) ?></span></p>
        <p class="produto-descricao"><b>Descricao: </b><span class="produto-desc"><?php echo h($produto['descricao']) ?></span></p>
        <div class="produto-info"><span class="produto-preco"><?php echo dinheiro($produto['valor']) ?></span><span class="produto-estoque"><?php echo (int)$produto['quantidade'] ?> disponiveis</span></div>
      </div>
      <?php } ?>
    </div>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
