<?php
require_once __DIR__ . '/../controller/Controlador.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->listarRegistros('cupons');
?>
<html lang="pt-BR"><head><meta charset="UTF-8" /><title>Cupons Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="../assets/img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><h2>Sair</h2></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<section class="vitrini"><section class="produtos"><h3 class="produtos-titulo">Cupons</h3><table class="tabela-dados"><tr><th>Código</th><th>Descrição</th><th>Desconto</th><th>Validade</th></tr><?php foreach ($linhas as $linha) { ?><tr><td><?php echo h($linha['codigo']) ?></td><td><?php echo h($linha['descricao']) ?></td><td><?php echo h($linha['desconto']) ?>%</td><td><?php echo h($linha['validade']) ?></td></tr><?php } ?></table></section></section>
</body></html>



