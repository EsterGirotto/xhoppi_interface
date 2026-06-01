<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$mensagem = isset($_GET['mensagem']) ? 'Cupom cadastrado com sucesso.' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastrar Cupom Xhoppi</title><link rel="stylesheet" href="../assets/css/cadastrocliente.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <main class="container">
    <form class="login-box" method="post" action="../processamento/processamento.php">
      <h2>Cadastrar Cupom</h2>
      <input type="text" name="inputCodigoCupom" placeholder="Codigo" required>
      <input type="text" name="inputDescricaoCupom" placeholder="Descricao" required>
      <input type="number" step="0.01" name="inputDescontoCupom" placeholder="Desconto %" required>
      <input type="date" name="inputValidadeCupom" required>
      <button type="submit">CADASTRAR</button>
      <?php if ($mensagem) { ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?>
    </form>
  </main>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
