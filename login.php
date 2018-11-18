<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (!empty($_SESSION['login'])) {
  header("Location:index.php");
  exit;
}
?>

<!doctype html>
<html lang="en">
<head>  <meta charset="utf-8">
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>Gamesmaga - Login</title>
  <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">
  <?php include_once("header-cliente.php"); ?>
  <form class="form-signin" method="POST" action="valida-cliente.php">
    <img class="mb-4" src="img/icone.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Faça seu login</h1>
    <label for="inputLogin" class="sr-only">login</label>
    <input type="text" id="inputLogin" class="form-control" placeholder="Nome de usuário" name="login" required autofocus>
    <label for="inputPassword" class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
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
  <?php showAlert() ?>
</body>
</html>
