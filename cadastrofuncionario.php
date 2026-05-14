<?php
require_once __DIR__ . '/includes/App.php';
exigirLogin();
$mensagem = '';
$erro = '';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try { (new CadastroRepositorio())->funcionario($_POST); $mensagem = 'Funcionário cadastrado com sucesso.'; }
    catch (Exception $e) { $erro = 'Não foi possível cadastrar o funcionário.'; }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="UTF-8" /><title>Cadastrar Funcionário Xhoppi</title><link rel="stylesheet" href="cadastrofuncionario.css" /></head><body>
<header><section class="cabecalho"><section class="cabecalho-logo"><img src="img/logo.png" /><h1>Xhopii</h1></section><a href="logout.php"><b><h4>Sair</h4></b></a></section><section class="super-aba"><?= menuPrincipal() ?></section></header>
<main class="container"><form class="login-box" method="post"><h2>Cadastrar Funcionário</h2><input type="text" name="nome" placeholder="Nome" required /><input type="text" name="sobrenome" placeholder="Sobrenome" required /><input type="number" name="cpf" placeholder="CPF" required /><input type="date" name="data_nascimento" required /><input type="number" name="telefone" placeholder="Telefone" required /><input type="text" name="cargo" placeholder="Cargo / Função" required /><input type="number" step="0.01" name="salario" placeholder="Sálario" required /><input type="email" name="email" placeholder="E-mail" required /><input type="password" name="senha" placeholder="Senha" required /><small><h3 id="Foto"><b>Selecionar foto de perfil</b></h3></small><div class="upload-container"><label class="upload-label">Escolher arquivo</label><span id="file-name">Nenhum arquivo escolhido</span><input type="file" id="file"></div><button type="submit">CADASTRAR</button><?php if ($mensagem): ?><small class="mensagem-ok"><?= h($mensagem) ?></small><?php endif; ?><?php if ($erro): ?><small class="mensagem-erro"><?= h($erro) ?></small><?php endif; ?></form></main>
</body></html>
