<?php
require_once "funcoes.php";

if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
}

$id="";
$plataforma="";
$fabricante="";

if (!empty($_GET)) {
  $id = $_GET['id'];
  if ($_GET['acao'] == 'editar') {
    $editarPlataforma = buscarPlataforma($id);
    $id = $editarPlataforma['id'];
    $plataforma = $editarPlataforma['nm_plataforma'];
    $fabricante = $editarPlataforma['fabricante'];
  }
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
    excluirPlataforma($id);
    header("location: cadastro-plataforma.php");
  }
}

if (!empty($_POST)) {
  if (empty($_POST['id'])) {
    salvarPlataforma($_POST);
  } else {
    editarPlataforma($_POST);
  }
  header("location: cadastro-plataforma.php");
}

$plataformas = listarPlataformas();

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
  <title>Cadastro - Plataformas de jogos</title>
</head>

<body>

  <?php
  include_once("header-funcionario.php");
  ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de plataformas</h3>
    <form action="cadastro-plataforma.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?=$id?>">
      <div class="form-group">
        <label for="plataforma">Plataforma</label>
        <input type="text" class="form-control" name="plataforma" id="plataforma" placeholder="Plataforma de jogos" value="<?=$plataforma?>" required>
      </div>
      <div class="form-group">
        <label for="fabricante">Fabricante</label>
        <input type="text" class="form-control" name="fabricante" id="fabricante" placeholder="Fabricante da plataforma" value="<?=$fabricante?>" required>
      </div>
      <input type="submit" class="btn btn-success" value="Salvar"/>
    </form>

    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>PLATAFORMA</th>
        <th>FABRICANTE</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") {
          ?>
          <th>&nbsp;</th>
          <?php
        } ?>

      </tr>

      <?php
      foreach ($plataformas as $plataforma) {
        ?>

        <tr>
          <td><?=$plataforma['id']?></td>
          <td><?=$plataforma['nm_plataforma']?></td>
          <td><?=$plataforma['fabricante']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-plataforma.php?acao=editar&id=<?=$plataforma['id']?>">Editar</a></td>
          <?php
          if ($_SESSION['login']['acesso'] != "logistica") {
            ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-plataforma.php?acao=excluir&id=<?=$plataforma['id']?>">Excluir</a></td>
            <?php
          } ?>

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
