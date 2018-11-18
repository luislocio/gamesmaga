<?php
require_once "funcoes.php";

if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
}

$id="";
$distribuidora="";

if (!empty($_GET)) {
  $id = $_GET['id'];
  if ($_GET['acao'] == 'editar') {
    $editarDistribuidora = buscarDistribuidora($id);
    $id = $editarDistribuidora['id'];
    $distribuidora = $editarDistribuidora['nm_distribuidora'];
  }
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
    excluirDistribuidora($id);
    header("location: cadastro-distribuidora.php");
  }
}

if (!empty($_POST)) {
  if (empty($_POST['id'])) {
    salvarDistribuidora($_POST);
  } else {
    editarDistribuidora($_POST);
  }
  header("location: cadastro-distribuidora.php");
}

$distribuidoras = listarDistribuidoras();
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
  <title>Cadastro - Distribuidora de jogos</title>

</head>

<body>
  <?php
  include_once("header-funcionario.php");
  ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de Distribuidoras</h3>
    <form action="cadastro-distribuidora.php" method="POST">
      <input type="hidden" name="id" value="<?=$id?>">
      <div class="form-group">
        <label for="distribuidora">Distribuidora</label>
        <input type="text" class="form-control" name="distribuidora" id="distribuidora" placeholder="Distribuidora de jogos" value="<?=$distribuidora?>" required>
      </div>
      <div class="row justify-content-end mt-4">
        <input type="submit" class="btn btn-success" value="Salvar"/>
      </div>
    </form>

    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>DISTRIBUIDORA</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") {
          ?>
          <th>&nbsp;</th>
          <?php
        } ?>
      </tr>

      <?php
      foreach ($distribuidoras as $distribuidora) {
        ?>

        <tr>
          <td><?=$distribuidora['id']?></td>
          <td><?=$distribuidora['nm_distribuidora']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-distribuidora.php?acao=editar&id=<?=$distribuidora['id']?>">Editar</a></td>
          <?php
          if ($_SESSION['login']['acesso'] != "logistica") {
            ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-distribuidora.php?acao=excluir&id=<?=$distribuidora['id']?>">Excluir</a></td>
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
