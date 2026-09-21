<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$produto = $controlador->visualizarProduto(isset($_GET['id']) ? (int)$_GET['id'] : 1);
if (!$produto) {
    $produtos = $controlador->visualizarProdutos();
    $produto = mysqli_fetch_assoc($produtos);

    if (!$produto) {
        $produto = array('imagem' => 'img/produto1.png', 'nome' => 'Produto nao encontrado', 'valor' => 0, 'quantidade' => 0);
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Xhopii - Produto</title><link rel="stylesheet" href="../assets/css/xhoppi.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <footer>
    <section class="roupas">
      <div class="roupas-pequenas">
        <img src="../assets/img/produto1.png"><img src="../assets/img/produto2.png"><img src="../assets/img/produto3.png"><img src="../assets/img/produto4.png"><img src="../assets/img/produto5.png">
      </div>
      <div class="roupa-grande"><img src="<?php echo h(caminhoImagem($produto['imagem'])) ?>"></div>
      <div class="infos">
        <h2><?php echo h($produto['nome']) ?></h2>
        <h3><?php echo dinheiro($produto['valor']) ?></h3>
        <p><?php echo (int)$produto['quantidade'] ?> Pecas Disponiveis</p>
        <p class="label">Modelos:</p>
        <div class="opcoes"><button>Preto</button><button>Azul</button><button>Verde</button><button>Cinza</button><button>Rosa</button></div>
        <p class="label">Tamanhos:</p>
        <div class="opcoes"><button>P</button><button>M</button><button>G</button><button>GG</button></div>
        <p>Tamanho Selecionado: P</p>
        <button class="comprar">Comprar Agora</button>
      </div>
    </section>
  </footer>
</body>
</html>
