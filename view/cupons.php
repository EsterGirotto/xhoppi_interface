<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->visualizarCupons();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cupons Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Cupons</h3>
    <table class="tabela-dados"><tr><th>Codigo</th><th>Descricao</th><th>Desconto</th><th>Validade</th></tr>
      <?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['codigo']) ?></td><td><?php echo h($linha['descricao']) ?></td><td><?php echo h($linha['desconto']) ?>%</td><td><?php echo h($linha['validade']) ?></td></tr><?php } ?>
    </table>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
