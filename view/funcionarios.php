<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->visualizarFuncionarios();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Funcionarios Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Funcionarios</h3>
    <table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Cargo</th><th>Salario</th><th>E-mail</th></tr>
      <?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?php echo h($linha['cpf']) ?></td><td><?php echo h($linha['cargo']) ?></td><td><?php echo dinheiro($linha['salario']) ?></td><td><?php echo h($linha['email']) ?></td></tr><?php } ?>
    </table>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
