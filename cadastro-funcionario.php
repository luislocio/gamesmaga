<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (empty($_SESSION['login']) || $_SESSION['login']['acesso']!="admin") {
  acessoRestrito();
  header("Location:login-funcionario.php");
  exit;
}

// Declaração de variáveis do formulário.
$id="";
$login="";
$senha="";
$acesso="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
  $id = $_GET['id'];
  // Carrega dados no formulário para edição
  if ($_GET['acao'] == 'editar') {
    $editarFuncionario = buscarFuncionario($id);
    $id=$editarFuncionario['id'];
    $login=$editarFuncionario['login'];
    $senha=$editarFuncionario['senha'];
    $acesso=$editarFuncionario['acesso'];
  }
  // Exclui elemento
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] == 'admin') {
    excluirFuncionario($id);
    header("location: cadastro-funcionario.php");
    exit;
  }
}

// Salvar elemento
if (!empty($_POST)) {
  $_POST['senha']=md5($_POST['senha']);
  if (empty($_POST['id'])) {
    salvarFuncionario($_POST);
  } else {
    editarFuncionario($_POST);
  }
  header("location: cadastro-funcionario.php");
  exit;
}

// Atribuição de valor às variaveis principais
$funcionarios = listarFuncionarios();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>Cadastro - Funcionarios</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
  <script type="text/javascript">
  function carregarDados(acesso)  {
    var element = document.getElementById("acesso");
    element.value = acesso;
  }
  </script>
</head >

<body onload="carregarDados('<?=$acesso?>')";>
  <?php include_once("header-funcionario.php"); ?>

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
        <?php if ($_SESSION['login']['acesso'] == "admin") { ?>
          <th>&nbsp;</th>
        <?php } ?>
      </tr>

      <?php foreach ($funcionarios as $funcionario) { ?>
        <tr>
          <td><?=$funcionario['id']?></td>
          <td><?=$funcionario['login']?></td>
          <td><?=$funcionario['senha']?></td>
          <td><?=$funcionario['acesso']?></td>
          <td class="text-center"><a class="btn btn-primary" href="cadastro-funcionario.php?acao=editar&id=<?=$funcionario['id']?>">Editar</a></td>
          <td class="text-center"><a class="btn btn-danger" href="cadastro-funcionario.php?acao=excluir&id=<?=$funcionario['id']?>">Excluir</a></td>
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
