<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
  acessoRestrito();
  header("Location:login-funcionario.php");
  exit;
}

// Declaração de variáveis do formulário.
$id="";
$distribuidora="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
  $id = $_GET['id'];
  // Carrega dados no formulário para edição
  if ($_GET['acao'] == 'editar') {
    $editarDistribuidora = buscarDistribuidora($id);
    $id = $editarDistribuidora['id'];
    $distribuidora = $editarDistribuidora['nm_distribuidora'];
  }
  // Exclui elemento
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
    excluirDistribuidora($id);
    header("location: cadastro-distribuidora.php");
    exit;
  }
}

// Salvar elemento
if (!empty($_POST)) {
  if (empty($_POST['id'])) {
    salvarDistribuidora($_POST);
  } else {
    editarDistribuidora($_POST);
  }
  header("location: cadastro-distribuidora.php");
  exit;
}

// Atribuição de valor às variaveis principais
$distribuidoras = listarDistribuidoras();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>Cadastro - Distribuidora de jogos</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
  <?php include_once("header-funcionario.php"); ?>

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
        <?php if ($_SESSION['login']['acesso'] != "logistica") {          ?>
          <th>&nbsp;</th>
          <?php } ?>
      </tr>
      <?php foreach ($distribuidoras as $distribuidora) { ?>
        <tr>
          <td><?=$distribuidora['id']?></td>
          <td><?=$distribuidora['nm_distribuidora']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-distribuidora.php?acao=editar&id=<?=$distribuidora['id']?>">Editar</a></td>
          <?php if ($_SESSION['login']['acesso'] != "logistica") { ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-distribuidora.php?acao=excluir&id=<?=$distribuidora['id']?>">Excluir</a></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
  </main>

  <?php include_once("footer.php"); ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
