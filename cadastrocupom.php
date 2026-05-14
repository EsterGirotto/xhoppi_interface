<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$mensagem = '';
$erro = '';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try { (new CadastroRepositorio())->cupom($_POST); $mensagem = 'Cupom cadastrado com sucesso.'; }
    catch (Exception $e) { $erro = 'Não foi possível cadastrar o cupom.'; }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="UTF-8" /><title>Cadastrar Cupons Xhoppi</title><link rel="stylesheet" href="cadastrocliente.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><b><h4>Sair</h4></b></a></section><section class="super-aba"><?= menuPrincipal() ?></section></header>
<main class="container"><form class="login-box" method="post"><h2>Cadastrar Cupons</h2><input type="text" name="codigo" placeholder="Código" required /><input type="text" name="descricao" placeholder="Descrição" required /><input type="number" step="0.01" name="desconto" placeholder="Desconto %" required /><input type="date" name="validade" required /><button type="submit">CADASTRAR</button><?php if ($mensagem): ?><small class="mensagem-ok"><?= h($mensagem) ?></small><?php endif; ?><?php if ($erro): ?><small class="mensagem-erro"><?= h($erro) ?></small><?php endif; ?></form></main>
</body></html>
