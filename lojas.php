<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = listarRegistros('lojas');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Lojas Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Lojas</h3><table class="tabela-dados"><tr><th>Nome</th><th>CNPJ</th><th>EndereÃƒÂ§o</th><th>Telefone</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?php echo h($linha['nome']) ?></td><td><?php echo h($linha['cnpj']) ?></td><td><?php echo h($linha['endereco']) ?></td><td><?php echo h($linha['telefone']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>



