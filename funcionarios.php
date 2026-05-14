<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$linhas = (new CadastroRepositorio())->listar('funcionarios');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Funcionários Xhopii</title><link rel="stylesheet" href="produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?= menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Funcionários</h3><table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Cargo</th><th>Salário</th><th>E-mail</th></tr><?php foreach ($linhas as $linha): ?><tr><td><?= h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?= h($linha['cpf']) ?></td><td><?= h($linha['cargo']) ?></td><td><?= dinheiro((float)$linha['salario']) ?></td><td><?= h($linha['email']) ?></td></tr><?php endforeach; ?></table></section></section>
</body></html>

