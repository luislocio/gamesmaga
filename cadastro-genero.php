<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
}

// Declaração de variáveis do formulário
$id="";
$genero="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
  $id = $_GET['id'];
  // Carrega dados no formulário para edição
  if ($_GET['acao'] == 'editar') {
    $editarGenero = buscarGenero($id);
    $id = $editarGenero['id'];
    $genero = $editarGenero['nm_genero'];
  }
  // Exclui elemento
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
    excluirGenero($id);
    header("location: cadastro-genero.php");
  }
}

// Salvar elemento
if (!empty($_POST)) {
  if (empty($_POST['id'])) {
    salvarGenero($_POST);
  } else {
    editarGenero($_POST);
  }
  header("location: cadastro-genero.php");
}

// Atribuição de valor às variaveis principais
$generos = listarGeneros();
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
  <title>Cadastro - Generos de jogos</title>

</head>

<body>
  <?php
  include_once("header-funcionario.php");
  ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de generos</h3>
    <form action="cadastro-genero.php" method="POST">
      <input type="hidden" name="id" value="<?=$id?>">
      <div class="form-group">
        <label for="genero">Genero</label>
        <input type="text" class="form-control" name="genero" id="genero" placeholder="Genero de jogos" value="<?=$genero?>" required>
      </div>
      <input type="submit" class="btn btn-success" value="Salvar"/>
    </form>

    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>GENERO</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") {
          ?>
          <th>&nbsp;</th>
          <?php
        } ?>
      </tr>

      <?php
      foreach ($generos as $genero) {
        ?>
        <tr>
          <td><?=$genero['id']?></td>
          <td><?=$genero['nm_genero']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-genero.php?acao=editar&id=<?=$genero['id']?>">Editar</a></td>
          <?php
          if ($_SESSION['login']['acesso'] != "logistica") {
            ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-genero.php?acao=excluir&id=<?=$genero['id']?>">Excluir</a></td>
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
