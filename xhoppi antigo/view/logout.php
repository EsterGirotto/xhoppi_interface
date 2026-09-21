<?php
// View: encerra a sessao e volta para o login.
session_start();
session_destroy();
header('Location: login.php');
exit;


