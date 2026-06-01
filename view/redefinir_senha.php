<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$mensagem = '';
$erro = '';
if (isset($_GET['mensagem'])) {
    $mensagem = 'Senha redefinida. Volte para o login.';
}
if (isset($_GET['erro'])) {
    $erro = 'E-mail nao encontrado.';
}
?>
<!doctype html>
<html lang="pt-BR">
  <head><meta charset="UTF-8" /><title>Redefinir Senha</title><link rel="stylesheet" href="../assets/css/rdefinir_senha.css" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /></head>
  <body>
    <header><section class="cabecalho"><section class="cabecalho-logo"><img src="../assets/img/logo.png" /><h1>Xhopii</h1><h2>Redefinir Senha</h2></section><p>Precisa de ajuda?</p></section></header>
    <main class="container">
      <form class="redefinir-senha-box" method="post" action="../processamento/processamento.php">
        <input type="hidden" name="acao" value="redefinir_senha" />
        <div class="redefinir-senha-header"><i class="fa-solid fa-arrow-left" onclick="window.location.href='login.php'"></i><h2>Redefinir Senha</h2></div>
        <input type="email" name="email" placeholder="E-mail" required />
        <input type="password" name="senha" placeholder="Nova senha" required />
        <button type="submit">Enviar</button>
        <?php if ($mensagem !== '') { ?><small style="color: green; text-align:center;"><?php echo h($mensagem) ?></small><?php } ?>
        <?php if ($erro !== '') { ?><small style="color: rgb(225, 96, 61); text-align:center;"><?php echo h($erro) ?></small><?php } ?>
      </form>
    </main>
  </body>
</html>
