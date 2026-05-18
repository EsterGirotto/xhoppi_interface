<?php
session_start();

require_once __DIR__ . '/../model/BancoDeDados.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../model/Funcionario.php';
require_once __DIR__ . '/../model/Loja.php';
require_once __DIR__ . '/../model/Cupom.php';

require_once __DIR__ . '/../controller/FuncoesController.php';
require_once __DIR__ . '/../controller/RelatorioController.php';
require_once __DIR__ . '/../controller/ProdutoController.php';
require_once __DIR__ . '/../controller/ClienteController.php';
require_once __DIR__ . '/../controller/FuncionarioController.php';
require_once __DIR__ . '/../controller/LojaController.php';
require_once __DIR__ . '/../controller/CupomController.php';
require_once __DIR__ . '/../controller/UsuarioController.php';
?>
