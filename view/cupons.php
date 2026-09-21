<?php
require_once __DIR__ . '/../controller/Controlador.php';
require_once __DIR__ . '/funcoes.php';
$controlador = new Controlador();
$controlador->exigirLogin();
$linhas = $controlador->visualizarCupons();
$cupons = [];
foreach ($linhas as $linha) {
    $cupons[] = $linha;
}
$mensagens = [
    'editado' => 'Cupom editado com sucesso.',
    'excluido' => 'Cupom excluido com sucesso.'
];
$mensagem = (isset($_GET['mensagem']) && isset($mensagens[$_GET['mensagem']])) ? $mensagens[$_GET['mensagem']] : '';
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cupons Xhopii</title><link rel="stylesheet" href="../assets/css/produtos.css"><link rel="stylesheet" href="../assets/css/rodape.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <?php echo cabecalhoPrincipal() ?>
  <section class="vitrini"><section class="produtos">
    <h3 class="produtos-titulo">Cupons</h3>
    <?php if ($mensagem) { ?><small class="mensagem-ok"><?php echo h($mensagem) ?></small><?php } ?>
    <?php foreach ($cupons as $linha) { ?>
      <form id="editar-cupom-<?php echo h($linha['id']) ?>" method="post" action="../processamento/processamento.php"></form>
    <?php } ?>
    <table class="tabela-dados"><tr><th>Codigo</th><th>Descricao</th><th>Desconto</th><th>Validade</th><th>Acoes</th></tr>
      <?php foreach ($cupons as $linha) { ?>
        <tr>
          <td>
            <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="text" name="inputCodigoCupom" value="<?php echo h($linha['codigo']) ?>" required>
          </td>
          <td>
            <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="text" name="inputDescricaoCupom" value="<?php echo h($linha['descricao']) ?>" required>
          </td>
          <td>
            <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="number" step="0.01" name="inputDescontoCupom" value="<?php echo h($linha['desconto']) ?>" required>
          </td>
          <td>
            <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="date" name="inputValidadeCupom" value="<?php echo h($linha['validade']) ?>" required>
          </td>
          <td>
            <div class="acoes-cupom">
              <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="hidden" name="inputIdCupom" value="<?php echo h($linha['id']) ?>">
              <input form="editar-cupom-<?php echo h($linha['id']) ?>" type="hidden" name="acaoCupom" value="editar">
              <button form="editar-cupom-<?php echo h($linha['id']) ?>" class="botao-cupom" type="submit">Editar</button>
              <form method="post" action="../processamento/processamento.php" onsubmit="return confirm('Deseja excluir este cupom?');">
                <input type="hidden" name="inputIdCupom" value="<?php echo h($linha['id']) ?>">
                <input type="hidden" name="acaoCupom" value="excluir">
                <button class="botao-cupom excluir" type="submit">Excluir</button>
              </form>
            </div>
          </td>
        </tr>
      <?php } ?>
      <?php if (empty($cupons)) { ?><tr><td colspan="5">Nenhum cupom cadastrado.</td></tr><?php } ?>
    </table>
  </section></section>
  <?php require __DIR__ . '/rodape.php'; ?>
</body>
</html>
