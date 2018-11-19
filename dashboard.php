<?php
require_once "funcoes.php";

// Pré=requisito [login]
if (empty($_SESSION['login'])) {
    necessarioLogin();
    header("Location:login.php");
    exit;
}

if (empty($pedidos)) {
    $titulo="<h3 class='text-center my-3'>Todos os pedidos</h3>";
    $ativo="todas";
    $pedidos=listarPedidosPorCliente($_SESSION['login']['id']);
}

if (!empty($_GET)) {
    switch ($_GET['compras']) {
    case 'pendentes':
        $titulo="<h3 class='text-center my-3'>Pedidos Pendentes</h3>";
        $ativo="pendentes";
        $pedidos=listarPedidosPorCliente($_SESSION['login']['id']);
        foreach ($pedidos as $indice => $pedido) {
            if (!empty($pedido['dt_pagamento'])) {
                unset($pedidos[$indice]);
            }
        }
        break;
    case 'finalizadas':
        $titulo="<h3 class='text-center my-3'>Pedidos Finalizados</h3>";
        $ativo="finalizadas";
        $pedidos=listarPedidosPorCliente($_SESSION['login']['id']);
        foreach ($pedidos as $indice => $pedido) {
            if (empty($pedido['dt_pagamento'])) {
                unset($pedidos[$indice]);
            }
        }
        break;
    case 'todas':
        $titulo="<h3 class='text-center my-3'>Todos os pedidos</h3>";
        $ativo="todas";
        $pedidos=listarPedidosPorCliente($_SESSION['login']['id']);
        break;
    default:
        //
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
    <?php require_once "head.php";?>

  <title>GamEsmaga - Dashboard</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>
<body>
    <?php require_once "header-cliente.php" ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
        <?php require_once "menu-lateral.php" ?>

      <!-- /.col-lg-3 -->
      <div class="col-lg-9">
        <?php echo $titulo?>
        <div class="card">
          <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
              <li class="nav-item">
                <a class="nav-link"><?php echo $_SESSION['login']['login']?></a>
              </li>
              <li class="nav-item ml-auto">
                <a class="nav-link <?php echo ($ativo=="pendentes")?"active":""?>" href="dashboard.php?compras=pendentes">Pendentes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo ($ativo=="finalizadas")?"active":""?>" href="dashboard.php?compras=finalizadas">Finalizados</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo ($ativo=="todas")?"active":""?>" href="dashboard.php?compras=todas">Todos</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div id="accordion" class="list-group">
                <?php if(!empty($pedidos)) {
                    foreach ($pedidos as $pedido) {
                        $itensDoPedido=listarItens($pedido['id']);

                        $totalDoPedido = 0.0;
                        foreach ($itensDoPedido as $item) {
                            $preco = floatval(str_replace(',', '.', str_replace('.', '', $item['vl_produto'])));
                            $totalDoPedido = $preco + $totalDoPedido;
                        }

                        if ($ativo=="todas") {
                            if (!empty($pedido['dt_pagamento'])) {
                                $status = "bg-success";
                            } else {
                                $status = "bg-warning ";
                            }
                        }

                        if ($pedido == end($pedidos)) {
                            $borda = "rounded-bottom";
                        } else {
                            $borda = "";
                        }
                        ?>
                  <div class="list-group-item <?php echo $status?> <?php echo $borda?>" data-toggle="collapse" data-target="#collapse<?php echo $pedido['id']?>" aria-expanded="false" aria-controls="collapse<?php echo $pedido['id']?>" id="heading<?php echo $pedido['id']?>">
                    <div class="row justify-content-between px-3">
                      <span>Pedido # <?php echo $pedido['id']?></span>
                      <span><?php echo $pedido['dt_compra']?></span>
                      <span><?php echo money_format('%n', ($totalDoPedido + $pedido['vl_frete']))?></span>
                    </div>
                  </button>
                </div>
                <div id="collapse<?php echo $pedido['id']?>" class="collapse list-group-item" aria-labelledby="heading<?php echo $pedido['id']?>" data-parent="#accordion">
                  <div class="">
                    <table class='table mt-3 table-hover table-borderless table-sm' id='checkout'>
                      <tr>
                        <thead class='thead-dark'>
                          <th>Jogo</th>
                          <th>Plataforma</th>
                          <th>Quantidade</th>
                          <th>Valor unitário</th>
                          <th>Valor total</th>
                        </thead>
                      </tr>
                        <?php
                          $itensDoPedido = array_unique($itensDoPedido, SORT_REGULAR);
                        foreach ($itensDoPedido as $item) {
                            $preco = floatval(str_replace(',', '.', str_replace('.', '', $item['vl_produto'])));
                            $quantidade = quantidadeDeItens($pedido['id'], $item['id_jogo']);
                            ?>

                        <tr class="border-bottom">
                          <td class="align-middle"><?php echo $item['nome']?><br> </td>
                          <td class="align-middle" align="center"><?php echo $item['nm_plataforma']?></td>
                          <td class="align-middle" align="center"><?php echo $quantidade?></td>
                          <td class="align-middle"><?php echo money_format('%n', floatval($preco))?></td>
                          <td class="align-middle" width="110px" align="center"><?php echo money_format('%n', ($quantidade*$preco))?></td>
                        </tr>
                        <?php } ?>

                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th scope="row">Subtotal</th>
                        <td class="align-middle" align="center"><?php echo money_format('%n', ($totalDoPedido))?></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th scope="row">Frete</th>
                        <td class="align-middle" align="center"><?php echo money_format('%n', floatval($pedido['vl_frete']))?></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th scope="row">Total do pedido</th>
                        <td class="align-middle" align="center"><?php echo money_format('%n', ($totalDoPedido + $pedido['vl_frete']))?></td>
                      </tr>
                    </table>
                  </div>
                </div>

                    <?php }
} else { ?>

              <h3 class='text-center my-3'>Não há pedidos a serem mostrados.</h3>

                <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once "footer.php"; ?>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
