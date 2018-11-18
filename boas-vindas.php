<?php
require_once "funcoes.php";

if (empty($_SESSION['login']) || $_SESSION['login']['acesso']=="cliente") {
  acessoRestrito();
  header("Location:login-funcionario.php");
}

if (!empty($_GET)) {
  if ($_GET['acao'] == 'logout') {
    unset($_SESSION['login']);
    header('Location:index.php');
  }
}

$funcionario=buscarFuncionario($_SESSION['login']['id']);

?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="refresh" content="2;url=cadastro-home.php">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <title>GamEsmaga - Sistema de Cadastro</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/cover.css" rel="stylesheet">

</script>
</head>

<body class="text-center">

  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
      <div class="inner">
        <h3>GamEsmaga - Sistema de Cadastros</h3>
      </div>
    </header>

    <main role="main" class="inner cover">
      <h1 class="cover-heading">Seja bem vindo, <?=$funcionario['login']?>.</h1>
    </main>

    <footer class="mastfoot mt-auto">
      <!--<div class="inner">
      <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    </div>-->
  </footer>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/popper.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
