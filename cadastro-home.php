<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
  exit;
}

if (!empty($_GET)) {
    if ($_GET['acao'] == 'logout') {
        unset($_SESSION['login']);
        header('Location:login-funcionario.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>GamEsmaga - Sistema de Cadastro</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
  <?php include_once("header-funcionario.php"); ?>

  <!-- Begin page content -->
  <main role="main" class="container pb-3">
    <?php
    $tirinha = rand(1,2067);
    $url = 'http://xkcd.com/'.$tirinha.'/info.0.json';
    $json = file_get_contents($url);
    $obj = json_decode($json);
    ?>
    <div class=ml-auto>
      <h3 class="mb-2"><?=$obj->safe_title?></h3>
      <img class="img mb-2" src="<?=$obj->img?>" alt="">
      <p class="muted" width="100%"><?=$obj->alt?></p>
    </div>
  </main>

  <?php include_once("footer.php"); ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
