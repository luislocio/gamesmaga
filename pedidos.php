<?php
require_once "funcoes.php";

// Pré-requisito [login]
if (empty($_SESSION['login'])) {
    necessarioLogin();
    header("Location:login.php");
    exit;
}

// Cria a lista de pedidos a serem mostrados na tela
if (empty($pedidos)) {
    $titulo="<h3 class='text-center my-3'>Todos os pedidos</h3>";
    $ativo="todas";
    $pedidos=listarPedidos();
}


// Filtra os pedidos
if (!empty($_GET)) {
    $pedidos=listarPedidos();
    switch ($_GET['status']) {
    // Apenas pedidos pendentes
    case 'pendente':
        $titulo="<h3 class='text-center my-3'>Pedidos Pendentes</h3>";
        $ativo="pendentes";
        foreach ($pedidos as $indice => $pedido) {
            if (!empty($pedido['dt_pagamento'])) {
                unset($pedidos[$indice]);
            }
        }
        break;
    // Apenas pedidos finalizados
    case 'finalizados':
        $titulo="<h3 class='text-center my-3'>Pedidos Finalizados</h3>";
        $ativo="finalizados";
        foreach ($pedidos as $indice => $pedido) {
            if (empty($pedido['dt_pagamento'])) {
                unset($pedidos[$indice]);
            }
        }
        break;
    // Todos os pedidos
    case 'todas':
        $titulo="<h3 class='text-center my-3'>Todos os pedidos</h3>";
        $ativo="todas";
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

  <title>Cadastro - Relatório de pedidos</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
    <?php require_once "header-funcionario.php"; ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Relatório de pedidos</h3>
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-pills card-header-pills">
          <li class="nav-item">
            <a class="nav-link"><?php echo $_SESSION['login']['login']?></a>
          </li>
          <li class="nav-item ml-auto">
            <a class="nav-link" href="pedidos.php?status=pendente">Pendentes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pedidos.php?status=finalizados">finalizados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pedidos.php?status=todas">Todas</a>
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

                    if ($_GET['status']=="todas") {
                        if (!empty($pedido['dt_pagamento'])) {
                            $status = "Finalizado";
                        } else {
                            $status = "Pendente";
                        }
                    }else {
                        $status ="";
                    }

                    if ($pedido == end($pedidos)) {
                        $borda = "rounded-bottom";
                    } else {
                        $borda = "";
                    }
                    ?>
              <div class="list-group-item <?php echo $borda?>" data-toggle="collapse" data-target="#collapse<?php echo $pedido['id']?>" aria-expanded="false" aria-controls="collapse<?php echo $pedido['id']?>" id="heading<?php echo $pedido['id']?>">
                <div class="row justify-content-between px-3">
                  <span>Pedido # <?php echo $pedido['id']?></span>
                  <span>Cliente # <?php echo $pedido['id_cliente']?></span>
                  <span><?php echo $pedido['dt_compra']?></span>
                    <?php if (!empty($status)) { ?>
                    <span><?php echo $status?></span>
                    <?php } ?>
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
</main>

<?php require_once "footer.php"; ?>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>
