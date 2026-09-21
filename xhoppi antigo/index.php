<?php
// Ponto de entrada: redireciona para a home (logado) ou para o login.

session_start();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: view/index.php');
} else {
    header('Location: view/login.php');
}

exit;

?>
