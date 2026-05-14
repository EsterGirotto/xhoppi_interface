<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = listarRegistros('clientes');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Clientes Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Clientes</h3><table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Nascimento</th><th>Telefone</th><th>E-mail</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?php echo h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?php echo h($linha['cpf']) ?></td><td><?php echo h($linha['data_nascimento']) ?></td><td><?php echo h($linha['telefone']) ?></td><td><?php echo h($linha['email']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>



