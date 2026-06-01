<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->listarRegistros('funcionarios');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Funcionários Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="../assets/img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Funcionários</h3><table class="tabela-dados"><tr><th>Nome</th><th>CPF</th><th>Cargo</th><th>Salário</th><th>E-mail</th></tr><?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['nome'] . ' ' . $linha['sobrenome']) ?></td><td><?php echo h($linha['cpf']) ?></td><td><?php echo h($linha['cargo']) ?></td><td><?php echo dinheiro((float)$linha['salario']) ?></td><td><?php echo h($linha['email']) ?></td></tr><?php } ?></table></section></section>
</body></html>



