<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = (new CadastroRepositorio())->listar('lojas');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Lojas Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?= menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Lojas</h3><table class="tabela-dados"><tr><th>Nome</th><th>CNPJ</th><th>Endereço</th><th>Telefone</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?= h($linha['nome']) ?></td><td><?= h($linha['cnpj']) ?></td><td><?= h($linha['endereco']) ?></td><td><?= h($linha['telefone']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>

