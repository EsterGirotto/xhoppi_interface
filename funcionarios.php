<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = listarRegistros('funcionarios');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>FuncionÃƒÂ¡rios Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">FuncionÃƒÂ¡rios</h3><table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Cargo</th><th>SalÃƒÂ¡rio</th><th>E-mail</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?php echo h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?php echo h($linha['cpf']) ?></td><td><?php echo h($linha['cargo']) ?></td><td><?php echo dinheiro((float)$linha['salario']) ?></td><td><?php echo h($linha['email']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>



