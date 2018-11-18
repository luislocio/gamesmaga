<?php
$generos = listarGeneros();
$plataformas = listarPlataformas();
?>
<div class="col-lg-3 mb-3">
  <a href="index.php"><img class="img rounded" width="100%" src="img/hulkMain.png" alt=""></a>

  <h3 class="mt-4">Generos</h3>
  <div class="list-group">
    <?php foreach ($generos as $genero) {
      if (!empty($_GET)) {
        $estadoGenero="";
        if (!empty($_GET['idGenero']) && $genero['id']==$_GET['idGenero']) {
          $estadoGenero="active";
        }
      } ?>
      <a href="index.php?idGenero=<?=$genero['id']?>" class="list-group-item <?=$estadoGenero?>"><?=$genero['nm_genero']?></a>
    <?php } ?>
  </div>

  <h3 class="mt-5">Plataformas</h3>
  <div class="list-group">
    <?php foreach ($plataformas as $plataforma) {
      if (!empty($_GET)) {
        $estadoPlataforma="";
        if (!empty($_GET['idPlataforma']) && $plataforma['id']==$_GET['idPlataforma']) {
          $estadoPlataforma="active";
        }
      } ?>
      <a href="index.php?idPlataforma=<?=$plataforma['id']?>" class="list-group-item <?=$estadoPlataforma?>"><?=$plataforma['nm_plataforma']?></a>
    <?php } ?>
  </div>
</div>
