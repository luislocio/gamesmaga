<?php
session_start();
require_once "funcoes.php";

if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
}

if (!empty($_GET)) {
  if ($_GET['acao'] == 'logout') {
    unset($_SESSION['login']);
    header('Location:index.php');
  }
}
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
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <title>GamEsmaga - Sistema de Cadastro</title>

</head>

<body>
  <?php
  include_once("header-funcionario.php");
  ?>

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
