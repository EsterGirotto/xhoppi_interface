<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$mensagem = isset($_GET['mensagem']) ? 'Cliente cadastrado com sucesso. Faca login para acessar a home.' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastrar Cliente Xhoppi</title><link rel="stylesheet" href="../assets/css/cadastrocliente.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal(!empty($_SESSION['usuario_id'])) ?>
  <main class="container">
    <form class="login-box" method="post" action="../processamento/processamento.php">
      <h2>Cadastrar Cliente</h2>
      <input type="text" name="inputNome" placeholder="Nome" required>
      <input type="text" name="inputSobrenome" placeholder="Sobrenome" required>
      <input type="number" name="inputCPF" placeholder="CPF" required>
      <input type="date" name="inputDataNasc" required>
      <input type="number" name="inputTelefone" placeholder="Telefone" required>
      <input type="email" name="inputEmail" placeholder="E-mail" required>
      <input type="password" name="inputSenha" placeholder="Senha" required>
      <small><h3 id="Foto">Selecionar foto de perfil</h3></small>
      <div class="upload-container"><label class="upload-label" for="file">Escolher arquivo</label><span id="file-name">Nenhum arquivo escolhido</span><input type="file" id="file"></div>
      <button type="submit">CADASTRAR</button>
      <?php if ($mensagem) { ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?>
    </form>
  </main>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
