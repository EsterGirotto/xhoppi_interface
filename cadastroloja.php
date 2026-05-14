<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$mensagem = '';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') { cadastrarLoja($_POST); $mensagem = 'Loja cadastrada com sucesso.'; }
?>
<!doctype html><html lang="pt-BR"><head><meta charset="UTF-8" /><title>Cadastrar Loja Xhoppi</title><link rel="stylesheet" href="cadastrocliente.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><b><h4>Sair</h4></b></a></section><section class="super-aba"><?php echo menuPrincipal() ?></section></header>
<main class="container"><form class="login-box" method="post"><h2>Cadastrar Loja</h2><input type="text" name="nome" placeholder="Nome da loja" required /><input type="text" name="cnpj" placeholder="CNPJ" required /><input type="text" name="endereco" placeholder="EndereÃ§o" required /><input type="number" name="telefone" placeholder="Telefone" required /><button type="submit">CADASTRAR</button><?php if ($mensagem): ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php endif; ?></form></main>
</body></html>

