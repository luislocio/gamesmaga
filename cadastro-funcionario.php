<?php
session_start();
require_once "funcoes.php";

if (empty($_SESSION['login']) || $_SESSION['login']['acesso']!="admin") {
    header("Location:login-funcionario.php");
}

$id="";
$login="";
$senha="";
$acesso="";

if (!empty($_GET)) {
    $id = $_GET['id'];
    if ($_GET['acao'] == 'editar') {
        $editarFuncionario = buscarFuncionario($id);
        $id=$editarFuncionario['id'];
        $login=$editarFuncionario['login'];
        $senha=$editarFuncionario['senha'];
        $acesso=$editarFuncionario['acesso'];
    }
    if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] == 'admin') {
        excluirFuncionario($id);
        header("location: cadastro-funcionario.php");
    }
}

if (!empty($_POST)) {
    $_POST['senha']=md5($_POST['senha']);
    if (empty($_POST['id'])) {
        salvarFuncionario($_POST);
    } else {
        editarFuncionario($_POST);
    }
    header("location: cadastro-funcionario.php");
}

$funcionarios = listarFuncionarios();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer-navbar.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Krub">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
  <link rel="stylesheet" href="css/shop-homepage.css">
  <title>Cadastro - Funcionarios</title>

  <script type="text/javascript">
  function carregarDados(acesso)  {
    var element = document.getElementById("acesso");
    element.value = acesso;
  }
  </script>

</head >

<body onload="carregarDados('<?=$acesso?>')";>
  <?php
  include_once("header-funcionario.php");
  ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de Funcionarios</h3>
    <form action="cadastro-funcionario.php" method="POST">
      <input type="hidden" name="id" value="<?=$id?>">
      <div class="container">

      <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" name="login" id="login" placeholder="Nome de usuário" value="<?=$login?>" required>
      </div>
      <div class="form-group">
        <label for="login">Senha</label>
        <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha do usuário" value="<?=$login?>" required>
      </div>
      <!-- MENU DROPDOWN -->
      <div class="form-group">
        <label for="acesso">Acesso</label>
        <select class="custom-select" name="acesso" id="acesso">
          <option value="">Escolha...</option>
          <option value="admin">Admin</option>
          <option value="gerencia">Gerencia</option>
          <option value="logistica">Logistica</option>
        </select>
      </div>
      </div>
      <div class="row justify-content-end mt-4">
        <input type="submit" class="btn btn-success" value="Salvar"/>
      </div>
    </form>

    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>LOGIN</th>
        <th>SENHA</th>
        <th>ACESSO</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") {
      ?>
      <th>&nbsp;</th>
    <?php
  } ?>
      </tr>

      <?php
      foreach ($funcionarios as $funcionario) {
          ?>

        <tr>
          <td><?=$funcionario['id']?></td>
          <td><?=$funcionario['login']?></td>
          <td><?=$funcionario['senha']?></td>
          <td><?=$funcionario['acesso']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-funcionario.php?acao=editar&id=<?=$funcionario['id']?>">Editar</a></td>
          <td class="text-center"><a class="btn btn-danger" href="cadastro-funcionario.php?acao=excluir&id=<?=$funcionario['id']?>">Excluir</a></td>
        </tr>

        <?php
      }
      ?>
    </table>
  </main>

  <?php include_once("footer.php"); ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
