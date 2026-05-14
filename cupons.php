<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = (new CadastroRepositorio())->listar('cupons');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Cupons Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?= menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Cupons</h3><table class="tabela-dados"><tr><th>Código</th><th>Descrição</th><th>Desconto</th><th>Validade</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?= h($linha['codigo']) ?></td><td><?= h($linha['descricao']) ?></td><td><?= h($linha['desconto']) ?>%</td><td><?= h($linha['validade']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>

