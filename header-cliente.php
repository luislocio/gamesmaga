<?php
include 'Mobile_Detect.php';
$detect = new Mobile_Detect();

// Declaração de variavéis da sessão
if (empty($_SESSION['login'])) {
  $_SESSION['login'] = [];
}

if (!empty($_SESSION['login']['id'])) {
  if ($_SESSION['login']['acesso']=="cliente") {
    $usuario=buscarCliente($_SESSION['login']['id']);
  } else {
    $usuario=buscarFuncionario($_SESSION['login']['id']);
  }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="index.php"><img src="./img/icone.png" width="40" class="d-inline-block img-thumbnail" style="background-color:#9CB66E" alt="GamEsmaga">
      <?php
      if ($detect->isMobile()){
        if (!empty($_SESSION['login']['id'])) {
          echo "<a class='nav-item active' style='color: white; text-decoration: none;' href='dashboard.php'>Olá, ".$usuario['login']."</a>";
        } else {  echo "GamEsmaga </a>";
        }
      }else{
        echo"<span class='ml-2'>GamEsmaga</span> </a>";
      }
      ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active border-right px-2">
          <a class="nav-link" >(41) 3035-9095</a>
        </li>
        <?php if (!empty($_SESSION['login']['id'])) {
          if ($_SESSION['login']['acesso']=="cliente") {
            $usuario=buscarCliente($_SESSION['login']['id']);
          } else {
            $usuario=buscarFuncionario($_SESSION['login']['id']);
          }
          if (!$detect->isMobile()){
            echo "<li class='nav-item active border-right px-2'>
              <a class='nav-link' href='dashboard.php'>Olá, ".$usuario['login']."</a>
            </li>";
          }
          ?>
          <!--
          <li class="nav-item border-right px-3">
            <a class="nav-link" href="dashboard.php">Olá, <?=$usuario['login']?> </a>
          </li> -->
          <li class="nav-item active border-right px-2">
            <a class="nav-link" onclick="return confirm('Voce esta certo disso?')" href="index.php?acao=logout"><i class="fas fa-sign-out-alt"></i></a>
          </li>
        <?php }else { ?>
          <li class="nav-item active border-right px-2">
            <a class="nav-link" href="login.php">Entrar</a>
          </li>
          <li class="nav-item active border-right px-2">
            <a class="nav-link" href="cadastro.php">Cadastrar</a>
          </li>
        <?php } ?>
        <li class="nav-item active px-2">
          <a class="nav-link" href="carrinho.php"><i class="fas fa-shopping-cart"></i></a>
        </li>
        <li class="d-block d-xl-inline-block list-inline-item ml-1">
          <form method="get" accept-charset="utf-8" action="index.php">
            <div class="input-group input-busca">
              <input type="text" name="busca" class="input-busca input-search form-control" placeholder="O que você procura?" required="required" id="busca">
              <div class="input-group-append">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
