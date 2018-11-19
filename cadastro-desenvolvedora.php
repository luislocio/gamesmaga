<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (($_SESSION['login']['acesso']=="cliente") || (empty($_SESSION['login']))) {
    acessoRestrito();
    header("Location:login-funcionario.php");
    exit;
}

// Declaração de variáveis do formulário
$id="";
$desenvolvedora="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
    $id = $_GET['id'];
    // Carrega dados no formulário para edição
    if ($_GET['acao'] == 'editar') {
        $editarDesenvolvedora = buscarDesenvolvedora($id);
        $id = $editarDesenvolvedora['id'];
        $desenvolvedora = $editarDesenvolvedora['nm_desenvolvedora'];
    }
    // Exclui elemento
    if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
        excluirDesenvolvedora($id);
        header("location: cadastro-desenvolvedora.php");
        exit;
    }
}

// Salvar elemento
if (!empty($_POST)) {
    if (empty($_POST['id'])) {
        salvarDesenvolvedora($_POST);
    } else {
        editarDesenvolvedora($_POST);
    }
    header("location: cadastro-desenvolvedora.php");
    exit;
}

// Atribuição de valor às variaveis principais
$desenvolvedoras = listarDesenvolvedoras();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
    <?php require_once "head.php";?>

  <title>Cadastro - Desenvolvedoras de jogos</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
</head>

<body>
    <?php require_once "header-funcionario.php"; ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de desenvolvedoras</h3>
    <form action="cadastro-desenvolvedora.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id?>">
      <div class="form-group">
        <label for="desenvolvedora">Desenvolvedora</label>
        <input type="text" class="form-control" name="desenvolvedora" id="desenvolvedora" placeholder="Desenvolvedora de jogos" value="<?php echo $desenvolvedora?>" required>
      </div>
      <div class="row justify-content-end mt-4">
        <input type="submit" class="btn btn-success" value="Salvar"/>
      </div>
    </form>
    <table class="table mt-3 table-sm table-bordered table-hover">
      <tr>
        <th>ID</th>
        <th>DESENVOLVEDORA</th>
        <th>&nbsp;</th>
        <?php if ($_SESSION['login']['acesso'] != "logistica") { ?>
          <th>&nbsp;</th>
        <?php } ?>
      </tr>
        <?php foreach ($desenvolvedoras as $desenvolvedora) { ?>
        <tr>
          <td><?php echo $desenvolvedora['id']?></td>
          <td><?php echo $desenvolvedora['nm_desenvolvedora']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-desenvolvedora.php?acao=editar&id=<?php echo $desenvolvedora['id']?>">Editar</a></td>
            <?php if ($_SESSION['login']['acesso'] != "logistica") { ?>
            <td class="text-center"><a class="btn btn-danger" href="cadastro-desenvolvedora.php?acao=excluir&id=<?php echo $desenvolvedora['id']?>">Excluir</a></td>
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
