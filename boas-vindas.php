<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (empty($_SESSION['login']) || $_SESSION['login']['acesso']=="cliente") {
  acessoRestrito();
  header("Location:login-funcionario.php");
  exit;
}

// Atribuição de valor às variáveis principais
$funcionario=buscarFuncionario($_SESSION['login']['id']);
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>GamEsmaga - Sistema de Cadastro</title>
  <link href="css/cover.css" rel="stylesheet">
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
</div>

<!-- Bootstrap core JavaScript -->
<script src="js/popper.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
