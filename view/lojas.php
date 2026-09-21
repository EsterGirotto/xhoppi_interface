<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->visualizarLojas();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Lojas Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Lojas</h3>
    <table class="tabela-dados"><tr><th>Nome</th><th>CNPJ</th><th>Endereco</th><th>Telefone</th></tr>
      <?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['nome']) ?></td><td><?php echo h($linha['cnpj']) ?></td><td><?php echo h($linha['endereco']) ?></td><td><?php echo h($linha['telefone']) ?></td></tr><?php } ?>
    </table>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
