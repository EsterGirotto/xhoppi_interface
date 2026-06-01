<?php
session_start();
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$erro = isset($_GET['erro']) ? 'E-mail ou senha invalidos.' : '';
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <title>Login Xhoppi</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>
  <body>
    <header>
      <section class="cabecalho">
        <section class="cabecalho-logo"><img src="../assets/img/logo.png"><h1>Xhopii</h1><h2>Entre</h2></section>
        <p>Precisa de ajuda?</p>
      </section>
    </header>
    <main class="container">
      <form class="login-box" method="post" action="../processamento/processamento.php">
        <h2>Login</h2>
        <input type="email" name="inputEmailLog" placeholder="E-mail" required>
        <input type="password" name="inputSenhaLog" placeholder="Senha" required>
        <button type="submit">ENTRE</button>
        <?php if ($erro) { ?><small class="mensagem-erro"><?php echo h($erro) ?></small><?php } ?>
        <p><a href="redefinir_senha.php">Esqueci minha senha</a><a href="#">Fazer login com SMS</a></p>
        <div class="divisor"><hr><span>OU</span><hr></div>
        <div class="redes"><button type="button"><i class="fab fa-facebook-f"></i> Facebook</button><button type="button"><i class="fab fa-google"></i> Google</button><button type="button"><i class="fab fa-apple"></i> Apple</button></div>
        <div class="cadastro"><p>Novo na Xhopii? <a href="cadastrocliente.php">Cadastrar</a></p></div>
      </form>
    </main>
    <?php require __DIR__ . '/rodape.php'; ?>
  </body>
</html>
