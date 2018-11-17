<?php
session_start();
setlocale(LC_MONETARY, 'pt_BR');

require_once "funcoes.php";

if (empty($_SESSION['carrinho'])) {
  $_SESSION['carrinho'] = [];
}

if (empty($_SESSION['frete'])) {
  $_SESSION['frete']['valor'] = 0;
  $_SESSION['frete']['cep'] = "";
}

$carrinho = $_SESSION['carrinho'];

if (!empty($_POST)) {
  $jogo = buscarJogo($_POST['id']);
  $estaNoCarrinho = false;
  foreach ($carrinho as $indice => $jogoDoCarrinho) {
    if ($jogoDoCarrinho['nome']==$jogo['nome']) {
      $_SESSION['carrinho'][$indice]['quantidade'] +=  1;
      $estaNoCarrinho = true;
      break;
    }
  }
  if($estaNoCarrinho == false) {
    $jogo['quantidade'] = 1;
    array_push($_SESSION['carrinho'], $jogo);
  }
  header("Location:carrinho.php");
}

if (!empty($_GET)) {
  switch ($_GET['acao']) {
    case 'menos':
    foreach ($carrinho as $indice => $jogoDoCarrinho) {
      if ($jogoDoCarrinho['id']==$_GET['id']) {
        $_SESSION['carrinho'][$indice]['quantidade'] -=  1;
        break;
      }
    }
    break;
    case 'mais':
    foreach ($carrinho as $indice => $jogoDoCarrinho) {
      if ($jogoDoCarrinho['id']==$_GET['id']) {
        $_SESSION['carrinho'][$indice]['quantidade'] +=  1;
        break;
      }
    }
    break;
    case 'remover':
    foreach ($carrinho as $indice => $jogoDoCarrinho) {
      if ($jogoDoCarrinho['id']==$_GET['id']) {
        unset($_SESSION['carrinho'][$indice]);
        break;
      }
    }
    break;
    case 'frete':
    $quantidadeDeProdutos = $_GET['quantidade'];
    $quantidadeDeEmbalagens = ceil($quantidadeDeProdutos/5);
    $peso = $quantidadeDeProdutos*0.3;
    $_SESSION['frete']['cep'] = $_GET['cep'];
    $resultado = calculaFrete(
      '41106',
      '80820320',
      $_SESSION['frete']['cep'],
      $peso,
      '8', '15', '20', 0 );
      $valor = floatval(str_replace(',', '.', str_replace('.', '', $resultado['valor'])));
      $freteTotal= floatval($valor * $quantidadeDeEmbalagens);
      $_SESSION['frete']['valor']=$freteTotal;
    break;
    default:
    // code...
    break;
  }



    header("Location:carrinho.php");
  }

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
          <h4>Meu Carrinho</h4>
          <hr class="pb-1" style="color:grey;background-color:grey;" >

          <?php
          $carrinho = $_SESSION['carrinho'];
          if (empty($carrinho)) {
            echo "<div align='center'>
            <i class='fas fa-shopping-cart'></i>
            <p>Não há produtos no carrinho.</p>
            </div>";
          } else {
            ?>
            <table class="table mt-3 table-hover table-borderless table-sm">
              <?php
              $totalDaCompra=0;
              $quantidadeDeProdutos=0;
              foreach ($carrinho as $produto) {
                $plataforma=buscarPlataforma($produto['plataforma']);

                $preco = floatval(str_replace(',', '.', str_replace('.', '', $produto['preco'])));
                $totalDoProduto= $preco * $produto['quantidade'];
                $totalDaCompra+=$totalDoProduto;
                $totalDoProduto = money_format('%n', $totalDoProduto);

                $quantidadeDeProdutos+=$produto['quantidade'];

                $botaoAnterior = ($produto['quantidade'] > 1) ? "" : "disabled";
                ?>
                <tr class="border-bottom">
                  <td ><img src="<?=$produto['url']?>" height="100px" alt="Capa do jogo" class="img"></td>
                  <td class="align-middle"><?=$produto['nome']?><br> <span class="small"><?=$plataforma['nm_plataforma']?></span></td>

                  <td class="align-middle">
                    <nav aria-label="Quantidade de Produtos">
                      <ul class="pagination justify-content-center">
                        <li class="page-item <?=$botaoAnterior?>"><a class="page-link" href="?acao=menos&id=<?=$produto['id']?>">-</a></li>
                        <li class="page-link disabled" align="center"><?=$produto['quantidade']?></li>
                        <li class="page-item"><a class="page-link" href="?acao=mais&id=<?=$produto['id']?>">+</a></li>
                      </ul>
                    </nav>
                  </td>

                  <td class="align-middle" width="110px" align="center"><?=$totalDoProduto?>
                    <?php if ($produto['quantidade'] > 1){ ?>
                      <br><span class="small" align="center"><?=money_format('%n',floatval($preco))?> cada</span>
                    <?php } ?>
                  </td>
                  <td class="align-middle"><a  href="?acao=remover&id=<?=$produto['id']?>"><i class="fas fa-trash-alt text-danger"></i></a></span></td>
                </tr>
                <?php
              }
              ?>
            </table>

            <div class="row justify-content-between mt-4">
              <div class="col-lg-3">
                <form class="" action="carrinho.php" method="get">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="acao" id="acao" value="frete">
                    <input type="hidden" class="form-control" name="quantidade" id="quantidade" value="<?=$quantidadeDeProdutos?>">
                    <h5>Calcule o frete</h5>
                    <input type="text" class="form-control" name="cep" id="cep" required value="<?=$_SESSION['frete']['cep']?>">
                    <input type="submit" class="btn btn-primary mt-2" value="Calcular"/>
                  </div>
                </form>


              </div>

              <div class="col-lg-6">
                <h5>Resumo do pedido</h5>
                <table class=" table">
                  <tr>
                    <th scope="row">Subtotal</th>
                    <td align="right"><?=money_format('%n',floatval($totalDaCompra))?></td>
                  </tr>
                  <?php if ($_SESSION['frete']['valor']!=0){ ?>
                  <tr>
                    <th scope="row">Frete</th>
                    <td align="right"><?=money_format('%n',floatval($_SESSION['frete']['valor']))?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <th scope="row">Total do pedido</th>
                    <td align="right"><?=money_format('%n',floatval($totalDaCompra+$_SESSION['frete']['valor']))?></td>
                  </tr>
                </table>
                <?php
                  $botao="secondary disabled";
                 if ($_SESSION['frete']['valor'] > 0) {
                    $botao="primary";
                }
                  ?>
                  <div class="row justify-content-end m-2">
                    <a class="btn btn-<?=$botao?>" href="checkout.php">Finalizar Compra</a>
                  </div>
              </div>
            </div>


          </div>
          <?php
        }

        ?>

      </div>
    </div>
  </div>
  <?php
  include_once("footer.php");
  ?>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
