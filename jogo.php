<?php
session_start();
require_once "funcoes.php";

if (!empty($_GET)) {
    $jogo = buscarJogo($_GET['id']);
} else {
    header("Location:index.php");
}

$generos=listarGeneros();
$plataformas=listarPlataformas();
$plataforma=buscarPlataforma($jogo['plataforma']);
$genero=buscarGenero($jogo['genero']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer-navbar.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krub">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <link rel="stylesheet" href="css/shop-homepage.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <title>GamEsmaga</title>
</head>

<body>

  <!-- Navigation -->
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
        $plataforma=buscarPlataforma($jogo['plataforma']);
        $genero=buscarGenero($jogo['genero']);
        ?>
        <div class="card">
          <div class="titulo">
            <img src="<?=$jogo['url']?>"  class="blur p-1">
            <img class="card-img-top img-fluid" src="<?=$jogo['url']?>" alt="">
          </div>
          <div class="card-body">
          <h3 class="card-title mb-2"><?=$jogo['nome']?></h3>
              <span class="ml-2">
                <a class="text-muted " href="index.php?idGenero=<?=$genero['id']?>"><?=$genero['nm_genero']?></a>
                <a class="text-muted mx-2 p-2 border-left" href="index.php?idPlataforma=<?=$plataforma['id']?>"><?=$plataforma['nm_plataforma']?></a>
              </span>
            </div>
            <pre class="card-text mx-3 p-3 "><?=$jogo['descricao']?>
            </pre>
            <h4 class="m-0 mr-2 ml-auto">R$ <?=$jogo['preco']?></h4>
            <form class="" action="carrinho.php" method="post">
              <input type="hidden" name="id" value="<?=$jogo['id']?>">
            <div class="row justify-content-end m-2">
              <input type="submit" class="btn btn-success" value="Adicionar ao carrinho"/>
            </div>
            </form>
          </div>
        </div>

  <!-- /.card -->

</div>
<!-- /.col-lg-9 -->

</div>

</div>
<!-- /.container -->

<!-- Footer -->
<?php include_once("footer.php"); ?>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>
