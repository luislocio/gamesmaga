<?php
session_start();
setlocale(LC_MONETARY, 'pt_BR');

require_once "funcoes.php";

if (empty($_SESSION['login']) || empty($_SESSION['carrinho'])) {
  header("Location:login.php");
}


if ($_SESSION['frete']['valor'] <= 0) {
  header("Location:carrinho.php");
}


$carrinho = $_SESSION['carrinho'];

$generos = listarGeneros();
$plataformas = listarPlataformas();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer-navbar.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krub">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <link rel="stylesheet" href="css/shop-homepage.css">
  <title>GamEsmaga</title>
</head>
<body>
  <?php
  include_once("header-cliente.php")
  ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <?php
      include_once("menu-lateral.php")
      ?>
      <!-- /.col-lg-3 -->
      <div class="col-lg-9">
        <?php
        if (!empty($_SESSION['login']) && !empty($_SESSION['carrinho'])) {
          try {
            criarPedido($_SESSION['login']['id'], $_SESSION['carrinho'], $_SESSION['frete']['valor']);
            echo "<h3 class='text-center'>Compra realizada com sucesso!</h3>";
            echo "<table class='table mt-3 table-hover table-borderless table-sm' id='checkout'>
            <tr>
            <thead class='thead-dark'>
            <th>Jogo</th>
            <th>Plataforma</th>
            <th>Quantidade</th>
            <th>Valor unitário</th>
            <th>Valor total</th>
            </thead>
            </tr>";


            $totalDaCompra=0;
            $quantidadeDeProdutos=0;
            foreach ($carrinho as $produto) {
              $plataforma=buscarPlataforma($produto['plataforma']);
              $preco = floatval(str_replace(',', '.', str_replace('.', '', $produto['preco'])));
              $totalDoProduto= $preco * $produto['quantidade'];
              $totalDaCompra+=$totalDoProduto;
              $totalDoProduto = money_format('%n', $totalDoProduto);
              ?>
              <tr class="border-bottom">
                <td class="align-middle"><?=$produto['nome']?><br> </td>
                <td class="align-middle"><?=$plataforma['nm_plataforma']?></td>
                <td class="align-middle" align="center"><?=$produto['quantidade']?></td>
                <td class="align-middle"><?=money_format('%n',floatval($preco))?></td>
                <td class="align-middle" width="110px" align="center"><?=$totalDoProduto?> </td>
              </tr>
              <?php
            }
            ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <th scope="row">Subtotal</th>
              <td class="align-middle" align="center"><?=money_format('%n',floatval($totalDaCompra))?></td>
            </tr>
            <?php if ($_SESSION['frete']['valor']!=0){ ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <th scope="row">Frete</th>
                <td class="align-middle" align="center"><?=money_format('%n',floatval($_SESSION['frete']['valor']))?></td>
              </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <th scope="row">Total do pedido</th>
              <td class="align-middle" align="center"><?=money_format('%n',floatval($totalDaCompra+$_SESSION['frete']['valor']))?></td>
            </tr>
          </table>
        </div>
        <?php
        unset($_SESSION['carrinho']);
        unset($_SESSION['frete']);
      } catch (\Exception $e) {
        echo "<h3>Falha na transacao. Entre em contato com o administrador</h3>";
      }
    } ?>
  </div>
  <?php include_once("footer.php"); ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
