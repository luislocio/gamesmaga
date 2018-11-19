<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (!empty($_SESSION['login']) && $_SESSION['login']['acesso']!="cliente") {
    header("Location:cadastro-home.php");
}
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Informações padrões do head -->
    <?php require_once "head.php";?>

  <title>Gamesmaga - Login Funcionário</title>
  <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">
  <form class="form-signin" method="POST" action="valida-funcionario.php">
    <h3 class="h3 mb-5 font-weight-normal">Login - Funcionários</h3>
    <a href="index.php">
    <img class="my-4" src="img/icone.png" alt="" width="72" height="72"></a>
    <h1 class="h3 mb-3 font-weight-normal">Seja bem vindo</h1>
      <label for="inputEmail" class="sr-only">Login</label>
      <input type="text" id="inputLogin" class="form-control" placeholder="Nome de usuário" name="login" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
    <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
  </form>

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
    <?php showAlert(); ?>
</body>
</html>
