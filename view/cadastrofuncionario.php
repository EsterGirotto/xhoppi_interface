<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$mensagem = isset($_GET['mensagem']) ? 'Funcionario cadastrado com sucesso.' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastrar Funcionario Xhoppi</title><link rel="stylesheet" href="../assets/css/cadastrofuncionario.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <main class="container">
    <form class="login-box" method="post" action="../processamento/processamento.php">
      <h2>Cadastrar Funcionario</h2>
      <input type="text" name="inputNomeFunc" placeholder="Nome" required>
      <input type="text" name="inputSobrenomeFunc" placeholder="Sobrenome" required>
      <input type="number" name="inputCPFFunc" placeholder="CPF" required>
      <input type="date" name="inputDataNascFunc" required>
      <input type="number" name="inputTelefoneFunc" placeholder="Telefone" required>
      <input type="text" name="inputCargoFunc" placeholder="Cargo / Funcao" required>
      <input type="number" step="0.01" name="inputSalarioFunc" placeholder="Salario" required>
      <input type="email" name="inputEmailFunc" placeholder="E-mail" required>
      <input type="password" name="inputSenhaFunc" placeholder="Senha" required>
      <button type="submit">CADASTRAR</button>
      <?php if ($mensagem) { ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?>
    </form>
  </main>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
