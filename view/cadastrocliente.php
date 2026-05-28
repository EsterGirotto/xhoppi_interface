<?php
require_once __DIR__ . '/../controller/Controlador.php';
$mensagem = '';
$erro = '';
if (isset($_GET['mensagem'])) {
    $mensagem = 'Cliente cadastrado com sucesso. Faça login para acessar a home.';
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Cliente Xhoppi</title>
    <link rel="stylesheet" href="../assets/css/cadastrocliente.css" />
</head>

<body>
    <header>
        <section class="cabecalho">
            <section class="cabecalho-logo"><img src="../assets/img/logo.png" />
                <h1>Xhopii</h1>
            </section><?php if (!empty($_SESSION['usuario_id'])) { ?><a href="logout.php"><b>
                        <h4>Sair</h4>
                    </b></a><?php } else { ?><a href="login.php"><b>
                        <h4>Login</h4>
                    </b></a><?php } ?>
        </section>
        <section class="super-aba"><?php echo menuPrincipal() ?></section>
    </header>
    <main class="container">
        <form class="login-box" method="post" action="../processamento/processamento.php">
            <h2>Cadastrar Cliente</h2><input type="text" name="nome" placeholder="Nome" required /><input type="text"
                name="sobrenome" placeholder="Sobrenome" required /><input type="number" name="cpf" placeholder="CPF"
                required /><input type="date" name="data_nascimento" required /><input type="number" name="telefone"
                placeholder="Telefone" required /><input type="email" name="email" placeholder="E-mail"
                required /><input type="password" name="senha" placeholder="Senha" required /><small>
                <h3 id="Foto"><b>Selecionar foto de perfil</b></h3>
            </small>
            <div class="upload-container"><label class="upload-label">Escolher arquivo</label><span
                    id="file-name">Nenhum arquivo escolhido</span><input type="file" id="file"></div><button
                type="submit">CADASTRAR</button><?php if ($mensagem) { ?><small
                    class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?><?php if ($erro) { ?><small
                    class="mensagem-erro"><?php echo h($erro) ?></small><?php } ?>
        </form>
    </main>
</body>

</html>
