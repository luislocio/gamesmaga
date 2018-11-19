<?php
// Declaração de variavéis da sessão
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = [];
}

$funcionario=buscarFuncionario($_SESSION['login']['id']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="index.php"><img src="./img/icone.png" width="40" class="d-inline-block mr-2 img-thumbnail" style="background-color:#9CB66E" alt="GamEsmaga"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <?php if ($funcionario['acesso']=="admin") { ?>
          <li class="nav-item active border-right">
            <a class="nav-link" href="cadastro-cliente.php">Cliente</a>
          </li>
          <li class="nav-item active border-right">
            <a class="nav-link" href="cadastro-funcionario.php">Funcionario</a>
          </li>
        <?php } ?>
        <li class="nav-item active border-right">
          <a class="nav-link" href="cadastro-desenvolvedora.php">Desenvolvedora</a>
        </li>
        <li class="nav-item active border-right">
          <a class="nav-link" href="cadastro-distribuidora.php">Distribuidora</a>
        </li>
        <li class="nav-item active border-right">
          <a class="nav-link" href="cadastro-genero.php">Genero</a>
        </li>
        <li class="nav-item active border-right">
          <a class="nav-link" href="cadastro-plataforma.php">Plataforma</a>
        </li>
    <li class="nav-item active border-right">
          <a class="nav-link" href="cadastro-jogo.php">Jogo</a>
        </li>
    <li class="nav-item active border-right">
          <a class="nav-link" href="pedidos.php">Pedidos</a>
        </li>
        <li class="nav-item active border-right">
          <a class="nav-link">Olá, <?php echo $funcionario['login']?> </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" onclick="return confirm('Voce esta certo disso?')" href="cadastro-home.php?acao=logout"><i class="fas fa-sign-out-alt"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
