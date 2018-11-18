<?php
require_once "funcoes.php";

// Controle do nivel de acesso
if (!empty($_SESSION['login'])) {
  header("Location:index.php");
  exit;
}


// Declaração de variáveis do formulário.
$id="";
$email="";
$login="";
$senha="";
$nomeCompleto="";
$cpf="";
$celular="";
$telefoneFixo="";
$sexo="";
$dataNascimento="";
$cep="";
$endereco="";
$numero="";
$complemento="";
$referencia="";
$bairro="";
$cidade="";
$estado="";

// Edição e exclusão de elementos
if (!empty($_GET)) {
  $id = $_GET['id'];
  // Carrega dados no formulário para edição
  if ($_GET['acao'] == 'editar') {
    $editarCliente = buscarCliente($id);
    $id=$editarCliente['id'];
    $email=$editarCliente['email'];
    $login=$editarCliente['login'];
    $senha=$editarCliente['senha'];
    $nomeCompleto=$editarCliente['nomecompleto'];
    $cpf=$editarCliente['cpf'];
    $celular=$editarCliente['celular'];
    $telefoneFixo=$editarCliente['telefonefixo'];
    $sexo=$editarCliente['sexo'];
    $dataNascimento=$editarCliente['datanascimento'];
    $cep=$editarCliente['cep'];
    $endereco=$editarCliente['endereco'];
    $numero=$editarCliente['numero'];
    $complemento=$editarCliente['complemento'];
    $referencia=$editarCliente['referencia'];
    $bairro=$editarCliente['bairro'];
    $cidade=$editarCliente['cidade'];
    $estado=$editarCliente['estado'];
  }
}

// Salvar elemento
if (!empty($_POST)) {
  $_POST['senha']=md5($_POST['senha']);
  if (empty($_POST['id'])) {
    salvarCliente($_POST);
  }
  header("location: index.php");
  exit;
}

// Atribuição de valor às variaveis principais
$clientes = listarClientes();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <!-- Informações padrões do head -->
  <?php include_once("head.php");?>

  <title>Gamesmaga - Cadastro</title>
  <link rel="stylesheet" href="css/shop-homepage.css">
  <script type="text/javascript">
  function carregarDados(sexo)  {
    var element = document.getElementById("sexo");
    element.value = sexo;
  }
  </script>
</head>

<body onload="carregarDados('<?=$sexo?>');">
  <?php include_once("header-cliente.php"); ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro pessoal</h3>
    <form action="cadastro.php" method="POST">
      <input type="hidden" name="id" value="<?=$id?>">
      <div class="border rounded mt-3 col">
        <h5 class="mt-2">Dados para acesso</h5>
        <div class="form-row">
          <div class="form-group col">
            <label for="login">Login</label>
            <input type="login" class="form-control" name="login" id="login" value="<?=$login?>">
          </div>
          <div class="form-group col">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha" value="<?=$senha?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?=$email?>">
          </div>
        </div>

      </div>

      <div class="form-row justify-content-between mt-3" >
        <div class="border rounded col">
          <h5 class="mt-2">Dados Pessoais</h5>
          <div class="mx-2">
            <div class="form-group">
              <label for="nomeCompleto">Nome Completo</label>
              <input type="text" class="form-control" name="nomeCompleto" id="nomeCompleto" value="<?=$nomeCompleto?>">
            </div>
            <div class="form-group">
              <label for="cpf">CPF</label>
              <input type="text" class="form-control" name="cpf" id="cpf" value="<?=$cpf?>">
            </div>
            <div class="form-group">
              <label for="celular">Celular</label>
              <input type="text" class="form-control" name="celular" id="celular" value="<?=$celular?>">
            </div>
            <div class="form-group">
              <label for="telefoneFixo">Telefone Fixo</label>
              <input type="text" class="form-control" name="telefoneFixo" id="telefoneFixo" value="<?=$telefoneFixo?>">
            </div>

            <!-- MENU DROPDOWN -->
            <div class="form-group">
              <label for="sexo">Sexo</label>
              <select class="custom-select" name="sexo" id="sexo">
                <option value="">Escolha...</option>
                <option value="Feminino">Menina</option>
                <option value="Masculino">Menino</option>
              </select>
            </div>
            <!-- /.MENU DROPDOWN -->

            <div class="form-group">
              <label for="dataNascimento">Data de Nascimento</label>
              <input type="date" class="form-control" name="dataNascimento" id="dataNascimento" value="<?=$dataNascimento?>">
            </div>
          </div>
        </div>

        <!-- ESPAÇAMENTO -->
        <div class="col-1">
        </div>
        <!-- /.ESPAÇAMENTO -->

        <div class="border rounded col ">
          <h5 class="mt-2">Endereço</h5>
          <div class="mx-2">
            <div class="form-group">
              <label for="cep">CEP</label>
              <input type="text" class="form-control" name="cep" id="cep" value="<?=$cep?>">
            </div>
            <div class="form-group">
              <label for="endereco">Endereço</label>
              <input type="text" class="form-control" name="endereco" id="endereco" value="<?=$endereco?>">
            </div>
            <div class="form-group">
              <label for="numero">Numero</label>
              <input type="text" class="form-control" name="numero" id="numero" value="<?=$numero?>">
            </div>
            <div class="form-group">
              <label for="complemento">Complemento</label>
              <input type="text" class="form-control" name="complemento" id="complemento" value="<?=$complemento?>">
            </div>
            <div class="form-group">
              <label for="referencia">Referência</label>
              <input type="text" class="form-control" name="referencia" id="referencia" value="<?=$referencia?>">
            </div>
            <div class="form-group">
              <label for="bairro">Bairro</label>
              <input type="text" class="form-control" name="bairro" id="bairro" value="<?=$bairro?>">
            </div>
            <div class="form-group">
              <label for="cidade">Cidade</label>
              <input type="text" class="form-control" name="cidade" id="cidade" value="<?=$cidade?>">
            </div>
            <div class="form-group">
              <label for="estado">Estado</label>
              <input type="text" class="form-control" name="estado" id="estado" value="<?=$estado?>">
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-end mt-4 ">
        <input type="submit" class="btn btn-success mb-4" value="Salvar"/>
      </div>
    </form>
  </main>

  <?php include_once("footer.php"); ?>
  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
