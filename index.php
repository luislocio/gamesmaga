<?php
require_once "funcoes.php";

// Cria a lista de jogos a serem mostrados na tela
$jogos = listarJogos();
if (!empty($_GET)) {
    // Filtra por genero
    if (!empty($_GET['idGenero'])) {
        $jogos = filtroPorGenero($_GET['idGenero']);
    }
    // Filtra por plataforma
    if (!empty($_GET['idPlataforma'])) {
        $jogos = filtroPorPlataforma($_GET['idPlataforma']);
    }
    // Filtra de acordo com a busca
    if (!empty($_GET['busca'])) {
        $jogos = barraDeBusca($_GET['busca']);
    }
}

// Realiza o logout do usuário
if (!empty($_GET)) {
    if (!empty($_GET['acao']) && $_GET['acao'] == 'logout') {
        unset($_SESSION['login']);
        header('Location:index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Informações padrões do head -->
    <?php require_once "head.php";?>

  <title>GamEsmaga</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
  <!-- Navigation -->
    <?php require_once "header-cliente.php" ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
        <?php require_once "menu-lateral.php" ?>
      <!-- /.col-lg-3-->
      <div class="col-lg-9">
        <div id="carouselExampleIndicators" class="carousel slide mb-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox" >
            <div class="carousel-item active" align="center">
              <a href="index.php?busca=red+dead+redemption+2"><img class="d-block img-fluid rounded" src="img/banner-red-dead.png" alt="First slide"></a>
            </div>
            <div class="carousel-item" align="center">
              <a href="index.php?busca=Assassin%27s+Creed+Odyssey"><img class="d-block img-fluid rounded" src="img/banner-assassins.png" alt="Second slide"></a>
            </div>
            <div class="carousel-item" align="center">
              <a href="index.php?busca=Call+of+Duty%3A+Black+Ops+4"><img class="d-block img-fluid rounded" src="img/banner-cod.png" alt="Third slide"></a>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>


        <?php
        try {

            include_once "barra-de-paginas.php";
            if (count($jogos) > 0) {
                $menuItems = array_slice($jogos, ($start-1), $limite);
                // Display the results
                foreach ($menuItems as $jogo) {
                    $plataforma=buscarPlataforma($jogo['plataforma']);
                    $genero=buscarGenero($jogo['genero']);
                    $borda=corDaBorda($plataforma['fabricante']); ?>
              <div class="col-md-6">
                <div class="card border-<?php echo $borda?> flex-md-row mb-2 shadow-sm h-md-250">
                  <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-auto text-<?php echo $borda?>"><?php echo $jogo['nome']?></strong>
                    <a href="index.php?idGenero=<?php echo $genero['id']?>" class="text-muted small"><?php echo $genero['nm_genero']?></a>
                    <a href="index.php?idPlataforma=<?php echo $plataforma['id']?>" class="mb-1 text-muted small"><?php echo $plataforma['nm_plataforma']?></a>
                    <div id="rodape" class="" style="width: 100%">
                      <strong >R$<?php echo $jogo['preco']?></strong>
                      <a class="btn btn-outline-<?php echo $borda?> btn-sm ml-auto" role="button" href="jogo.php?id=<?php echo $jogo['id']?>">Detalhes</a>
                    </div>
                  </div>
                  <img class="card-img-right flex-auto d-none d-lg-block border-left p-1" alt="Thumbnail [200x250]" src="<?php echo $jogo['url']?>" style="height: 150px;">
                </div>
              </div>
                    <?php
                }
            } else {
                echo '<h5>Não há resultados.</h5>';
            }
        } catch (Exception $e) {
            console_log($e->getMessage());
        }
        ?>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col-lg-9 -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->

<?php require_once "footer.php"; ?>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
