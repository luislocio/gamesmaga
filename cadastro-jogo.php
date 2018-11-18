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
$nome="";
$ano="";
$desenvolvedora="";
$distribuidora="";
$plataforma="";
$genero="";
$preco="";
$descricao="";

// Trata a imagem, move para a pasta de imagens salvas e armazena o caminha na variavel URL, para ser armazendo no banco de dados
if (!empty($_FILES)) {
  $caminho_arquivo = "/var/www/html/gamesmaga/img/salvas/";
  $nome_arquivo = $_FILES['image']['name'];
  console_log($_FILES);

  //Armazena a extensão do arquivo
  $extensao = substr($nome_arquivo, strripos($nome_arquivo, '.'));

  //Armazena e trata o nome do jogo, retirado os espaços e deixando em camel case
  $nome_jogo = $_POST['nome'];
  $nome_jogo = ucwords(strtolower($nome_jogo));
  $nome_jogo = str_replace(" ", "", $nome_jogo);

  //Armazena e trata o nome da plataforma, retirado os espaços
  $nome_plataforma = buscarPlataforma($_POST['plataforma']);
  $nome_plataforma = str_replace(" ", "", $nome_plataforma['nm_plataforma']);

  //Concatena o nome final do arquivo
  $novo_nome = limpaString($nome_jogo.$nome_plataforma).$extensao;
  move_uploaded_file($_FILES['image']['tmp_name'], $caminho_arquivo.$novo_nome);

  //Verifica se o arquivo possui extensão, para auxiliar no if que oculta a imagem
  if (empty($extensao)) {
    $url="";
  } else {
    $url = 'img/salvas/'.$novo_nome;
  }
  $nome="";
  $plataforma="";
}

// Edição e exclusão de elementos
if (!empty($_GET)) {
  $id = $_GET['id'];
  // Carrega dados no formulário para edição
  if ($_GET['acao'] == 'editar') {
    $editarJogo = buscarJogo($id);
    $id=$editarJogo['id'];
    $nome=$editarJogo['nome'];
    $ano=$editarJogo['ano'];
    $desenvolvedora=$editarJogo['desenvolvedora'];
    $distribuidora=$editarJogo['distribuidora'];
    $plataforma=$editarJogo['plataforma'];
    $genero=$editarJogo['genero'];
    $url=$editarJogo['url'];
    $preco=$editarJogo['preco'];
    $descricao=$editarJogo['descricao'];
  }
  // Exclui elemento
  if ($_GET['acao'] == 'excluir' && $_SESSION['login']['acesso'] != 'logistica') {
    excluirJogo($id);
    header("location: cadastro-jogo.php");
    exit;
  }
}

// Salvar elemento
if (!empty($_POST)) {
  $_POST['url'] = $url;
  if (empty($_POST['id'])) {
    salvarJogo($_POST);
  } else {
    editarJogo($_POST);
  }
  header("location: cadastro-jogo.php");
  exit;
}

// Atribuição de valor às variaveis do menu dropdown
$desenvolvedoras = listarDesenvolvedoras();
$generos = listarGeneros();
$plataformas = listarPlataformas();
$distribuidoras = listarDistribuidoras();
$jogos = listarJogos();
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
  <title>GamEsmaga - Cadastro de Jogos</title>


  <script type="text/javascript">
  function carregarDados(desenvolvedora, distribuidora, plataforma, genero)  {
    var element = document.getElementById("desenvolvedora");
    element.value = desenvolvedora;

    element = document.getElementById("distribuidora");
    element.value = distribuidora;

    element = document.getElementById("plataforma");
    element.value = plataforma;

    element = document.getElementById("genero");
    element.value = genero;
  }
  </script>

</head>

<body onload="carregarDados('<?=$desenvolvedora?>', '<?=$distribuidora?>', '<?=$plataforma?>', '<?=$genero?>');">
  <?php
  include_once("header-funcionario.php");
  ?>

  <!-- Begin page content -->
  <main role="main" class="container">
    <h3>Cadastro de jogos</h3>
    <form action="cadastro-jogo.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="hidden" name="url" value="<?=$url?>">
      <?php if (!empty($url) && $url !='img/salvas/') {
        ?>
        <div class="row justify-content-around mt-5">
          <img src="<?=$url?>" class="img" id="capaDoJogo" height="200"/>
        </div>
        <?php
      } ?>
      <div class="row justify-content-around ">
        <div class="form-group">
          <label for="image">Capa do jogo</label>
          <input type="file" name="image" class="form-control-file " id="capaDoJogo">
        </div>
        <div class="form-group col-3">
          <label for="nome">Preço</label>
          <input type="text" class="form-control" name="preco" id="preco" placeholder="Informe o preço do jogo" value="<?=$preco?>" required>
        </div>
      </div>


    </div>
  </div>
  <div class="row">
    <div class="form-group col">
      <label for="nome">Nome do jogo</label>
      <input type="text" class="form-control" name="nome" id="nome" placeholder="Informe o nome do jogo" value="<?=$nome?>" required>
    </div>
    <div class="form-group col">
      <label for="ano-lancamento">Ano de lancamento</label>
      <input type="text" class="form-control" name="ano" id="nome" placeholder="Informe o ano de lançamento" value="<?=$ano?>" required>
    </div>
  </div>

  <div class="row justify-content-around">
    <div class="form-group mb-3 col">
      <label for="desenvolvedora">Desenvolvedora</label>
      <select class="custom-select" id="desenvolvedora" name="desenvolvedora" required>
        <option value="">Escolha...</option>
        <?php
        foreach ($desenvolvedoras as $id => $desenvolvedora) {
          ?>
          <option value="<?= $desenvolvedora['id'] ?>"><?= $desenvolvedora['nm_desenvolvedora'] ?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="form-group mb-3 col">
      <label for="distribuidora">Distribuidora</label>
      <select class="custom-select" id="distribuidora" name="distribuidora" required>
        <option value="">Escolha...</option>
        <?php
        foreach ($distribuidoras as $id => $distribuidora) {
          ?>
          <option value="<?= $distribuidora['id'] ?>"><?= $distribuidora['nm_distribuidora'] ?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

</div>

<div class="row justify-content-around">
  <div class="form-group mb-3 col">
    <label for="plataforma">Plataforma</label>
    <select class="custom-select" id="plataforma" name="plataforma" required>
      <option value="">Escolha...</option>
      <?php
      foreach ($plataformas as $id => $plataforma) {
        ?>
        <option value="<?= $plataforma['id'] ?>"><?= $plataforma['nm_plataforma'] ?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group mb-3 col">
    <label for="Genero">Genero</label>
    <select class="custom-select" id="genero" name="genero" value="<?=$genero?>" required>
      <option value="">Escolha...</option>
      <?php
      foreach ($generos as $id => $genero) {
        ?>
        <option value="<?= $genero['id'] ?>"><?= $genero['nm_genero'] ?></option>
        <?php
      }
      ?>
    </select>
  </div>

</div>
<div class="form-group">
  <label for="exampleFormControlTextarea1">Descrição</label>
  <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?=$descricao?></textarea>
</div>
</div>

<div class="row justify-content-end mt-4">
  <input type="submit" class="btn btn-success" value="Salvar"/>
</div>
</form>

<table class="table mt-3 table-sm table-bordered table-hover">
  <tr>
    <th>ID</th>
    <th>CAPA</th>
    <th>NOME</th>
    <th>ANO</th>
    <th>DESENVOLVEDORA</th>
    <th>DISTRIBUIDORA</th>
    <th>PLATAFORMA</th>
    <th>GENERO</th>
    <th>PRECO</th>
    <th>&nbsp;</th>
    <?php if ($_SESSION['login']['acesso'] != "logistica") {
      ?>
      <th>&nbsp;</th>
      <?php
    } ?>
  </tr>

  <?php
  foreach ($jogos as $jogo) {
    $desenvolvedora=buscarDesenvolvedora($jogo['desenvolvedora']);
    $distribuidora=buscarDistribuidora($jogo['distribuidora']);
    $plataforma=buscarPlataforma($jogo['plataforma']);
    $genero=buscarGenero($jogo['genero']); ?>

    <tr>
      <td><?=$jogo['id']?></td>
      <td><img src="<?=$jogo['url']?>" height="50px" alt="Capa do jogo" class="img"></td>
      <td><?=$jogo['nome']?></td>
      <td><?=$jogo['ano']?></td>
      <td><?=$desenvolvedora['nm_desenvolvedora']?></td>
      <td><?=$distribuidora['nm_distribuidora']?></td>
      <td><?=$plataforma['nm_plataforma']?></td>
      <td><?=$genero['nm_genero']?></td>
      <td>R$ <?=$jogo['preco']?></td>
      <td class="text-center"><a class="btn btn-primary" href="cadastro-jogo.php?acao=editar&id=<?=$jogo['id']?>">Editar</a></td>
      <td class="text-center"><a class="btn btn-danger" href="cadastro-jogo.php?acao=excluir&id=<?=$jogo['id']?>">Excluir</a></td>
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
