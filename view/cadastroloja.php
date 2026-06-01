<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$mensagem = isset($_GET['mensagem']) ? 'Loja cadastrada com sucesso.' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastrar Loja Xhoppi</title><link rel="stylesheet" href="../assets/css/cadastrocliente.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <main class="container">
    <form class="login-box" method="post" action="../processamento/processamento.php">
      <h2>Cadastrar Loja</h2>
      <input type="text" name="inputNomeLoja" placeholder="Nome da loja" required>
      <input type="text" name="inputCnpjLoja" placeholder="CNPJ" required>
      <input type="text" name="inputEnderecoLoja" placeholder="Endereco" required>
      <input type="number" name="inputTelefoneLoja" placeholder="Telefone" required>
      <button type="submit">CADASTRAR</button>
      <?php if ($mensagem) { ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?>
    </form>
  </main>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
