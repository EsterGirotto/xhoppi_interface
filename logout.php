<?php
require_once __DIR__ . '/includes/App.php';
session_destroy();
header('Location: login.php');
exit;


