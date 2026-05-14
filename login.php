<?php
require_once __DIR__ . '/includes/App.php';
$erro = '';
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthService();
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    if ($auth->login($email, $senha)) {
        header('Location: index.php');
        exit;
    }
    $erro = 'E-mail ou senha inválidos.';
}
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <title>Login Xhoppi</title>
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  </head>
  <body>
    <header>
      <section class="cabecalho">
        <section class="cabecalho-logo">
          <img src="img/logo.png" />
          <h1>Xhopii</h1>
          <h2>Entre</h2>
        </section>
        <p>Precisa de ajuda?</p>
      </section>
    </header>

    <main class="container">
      <form class="login-box" method="post" action="login.php">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="E-mail" required />
        <input type="password" name="senha" placeholder="Senha" required />
        <button type="submit">ENTRE</button>
        <?php if ($erro !== ''): ?><small style="color: rgb(225, 96, 61); text-align:center;"><?= h($erro) ?></small><?php endif; ?>
        <p><a href="redefinir_senha.php">Esqueci minha senha</a><a href="#">Fazer login com SMS</a></p>
        <div class="divisor"><hr /><span>OU</span><hr /></div>
        <div class="redes"><button type="button"><i class="fab fa-facebook-f"></i> Facebook</button><button type="button"><i class="fab fa-google"></i> Google</button><button type="button"><i class="fab fa-apple"></i> Apple</button></div>
        <div class="cadastro"><p>Novo na Xhopii? <a href="cadastrocliente.php">Cadastrar</a></p></div>
      </form>
    </main>
  </body>
</html>
