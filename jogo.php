<?php
require_once "funcoes.php";

// Verifica se algum jogo está sendo carregado
if (!empty($_GET)) {
    $jogo = buscarJogo($_GET['id']);
} else {
    header("Location:index.php");
    exit;
}

// Atribuição de valor às variaveis principais
$generos=listarGeneros();
$plataformas=listarPlataformas();
$plataforma=buscarPlataforma($jogo['plataforma']);
$genero=buscarGenero($jogo['genero']);
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
      <!-- /.col-lg-3 -->
      <div class="col-lg-9">
        <?php
        $plataforma=buscarPlataforma($jogo['plataforma']);
        $genero=buscarGenero($jogo['genero']);
        ?>
        <div class="card">
          <div class="titulo">
            <img src="<?php echo $jogo['url']?>"  class="blur p-1">
            <img class="card-img-top img-fluid" src="<?php echo $jogo['url']?>" alt="">
          </div>
          <div class="card-body">
            <h3 class="card-title mb-2"><?php echo $jogo['nome']?></h3>
            <span class="ml-2">
              <a class="text-muted " href="index.php?idGenero=<?php echo $genero['id']?>"><?php echo $genero['nm_genero']?></a>
              <a class="text-muted mx-2 p-2 border-left" href="index.php?idPlataforma=<?php echo $plataforma['id']?>"><?php echo $plataforma['nm_plataforma']?></a>
            </span>
          </div>
          <pre class="card-text mx-3 p-3 "><?php echo $jogo['descricao']?>
          </pre>
          <h4 class="m-0 mr-2 ml-auto">R$ <?php echo $jogo['preco']?></h4>
          <form class="" action="carrinho.php" method="post">
            <input type="hidden" name="id" value="<?php echo $jogo['id']?>">
            <div class="row justify-content-end m-2">
              <input type="submit" class="btn btn-success" value="Adicionar ao carrinho"/>
            </div>
          </form>
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
