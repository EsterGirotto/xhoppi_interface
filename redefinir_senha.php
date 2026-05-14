<?php
require_once __DIR__ . '/includes/App.php';
$mensagem = '';
$erro = '';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = '';
    }
    if (isset($_POST['senha'])) {
        $senha = $_POST['senha'];
    } else {
        $senha = '';
    }
    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e nova senha.';
    } elseif (redefinirSenha($email, $senha)) {
        $mensagem = 'Senha redefinida. Volte para o login.';
    } else {
        $erro = 'E-mail nÃƒÂ£o encontrado.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
  <head><meta charset="UTF-8" /><title>Redefinir Senha</title><link rel="stylesheet" href="rdefinir_senha.css" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /></head>
  <body>
    <header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1><h2>Redefinir Senha</h2></section><p>Precisa de ajuda?</p></section></header>
    <main class="container">
      <form class="redefinir-senha-box" method="post">
        <div class="redefinir-senha-header"><i class="fa-solid fa-arrow-left" onclick="window.location.href='login.php'"></i><h2>Redefinir Senha</h2></div>
        <input type="email" name="email" placeholder="E-mail" required />
        <input type="password" name="senha" placeholder="Nova senha" required />
        <button type="submit">Enviar</button>
        <?php if ($mensagem !== ''): ?><small style="color: green; text-align:center;"><?php echo h($mensagem) ?></small><?php endif; ?>
        <?php if ($erro !== ''): ?><small style="color: rgb(225, 96, 61); text-align:center;"><?php echo h($erro) ?></small><?php endif; ?>
      </form>
    </main>
  </body>
</html>



