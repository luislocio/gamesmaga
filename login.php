<?php
session_start();

if (!empty($_SESSION['login'])) {
    header("Location:index.php");
}
 ?>

<!doctype html>
<html lang="en">
<head>  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/sticky-footer-navbar.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krub">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <link rel="stylesheet" href="css/shop-homepage.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <title>Gamesmaga - Login</title>
</head>

<body class="text-center">
  <?php
  include_once("header-cliente.php");
  ?>
  <form class="form-signin" method="POST" action="valida-cliente.php">
    <img class="mb-4" src="img/icone.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Faça seu login</h1>
      <label for="inputLogin" class="sr-only">login</label>
      <input type="text" id="inputLogin" class="form-control" placeholder="Nome de usuário" name="login" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <!--      <div class="checkbox mb-3">
      <label>
      <input type="checkbox" value="remember-me"> Remember me </label>
    </div> -->
    <button class="btn btn-lg btn-success btn-block" type="submit">Entrar</button>
    <div class="container text-center mt-3">
      <p class="mt-3">Ainda não é cadastrado?<br>
        <a href="cadastro.php">
          <strong>criar conta agora</strong>
        </a>
      </p>
    </div>
  </form>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
