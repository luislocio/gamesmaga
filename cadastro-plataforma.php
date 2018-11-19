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
$plataforma="";
$fabricante="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
    $id = $_GET['id'];
    // Carrega dados no formulário para edição
    if ($_GET['acao'] == 'editar') {
        $editarPlataforma = buscarPlataforma($id);
        $id = $editarPlataforma['id'];
        $plataforma = $editarPlataforma['nm_plataforma'];
        $fabricante = $editarPlataforma['fabricante'];
    }
    // Exclui elemento
    if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
        excluirPlataforma($id);
        header("location: cadastro-plataforma.php");
        exit;
    }
}

// Salvar elemento
if (!empty($_POST)) {
    if (empty($_POST['id'])) {
        salvarPlataforma($_POST);
    } else {
        editarPlataforma($_POST);
    }
    header("location: cadastro-plataforma.php");
    exit;
}

// Atribuição de valor às variaveis principais
$plataformas = listarPlataformas();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
    <?php require_once "head.php";?>

  <title>Cadastro - Plataformas de jogos</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
    <?php  require_once "header-funcionario.php"; ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de plataformas</h3>
    <form action="cadastro-plataforma.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id?>">
      <div class="form-group">
        <label for="plataforma">Plataforma</label>
        <input type="text" class="form-control" name="plataforma" id="plataforma" placeholder="Plataforma de jogos" value="<?php echo $plataforma?>" required>
      </div>
      <div class="form-group">
        <label for="fabricante">Fabricante</label>
        <input type="text" class="form-control" name="fabricante" id="fabricante" placeholder="Fabricante da plataforma" value="<?php echo $fabricante?>" required>
      </div>
      <input type="submit" class="btn btn-success" value="Salvar"/>
    </form>

    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>PLATAFORMA</th>
        <th>FABRICANTE</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") { ?>
          <th>&nbsp;</th>
        <?php } ?>
      </tr>
        <?php foreach ($plataformas as $plataforma) { ?>
        <tr>
          <td><?php echo $plataforma['id']?></td>
          <td><?php echo $plataforma['nm_plataforma']?></td>
          <td><?php echo $plataforma['fabricante']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-plataforma.php?acao=editar&id=<?php echo $plataforma['id']?>">Editar</a></td>
            <?php if ($_SESSION['login']['acesso'] != "logistica") { ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-plataforma.php?acao=excluir&id=<?php echo $plataforma['id']?>">Excluir</a></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
  </main>

    <?php require_once "footer.php"; ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
