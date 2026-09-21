<?php

session_start();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: view/index.php');
} else {
    header('Location: view/login.php');
}

exit;

?>
