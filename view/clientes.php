<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->visualizarClientes();
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Clientes Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Clientes</h3>
    <table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Nascimento</th><th>Telefone</th><th>E-mail</th></tr>
      <?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?php echo h($linha['cpf']) ?></td><td><?php echo h($linha['data_nascimento']) ?></td><td><?php echo h($linha['telefone']) ?></td><td><?php echo h($linha['email']) ?></td></tr><?php } ?>
    </table>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
