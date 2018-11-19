<?php
$total = count($jogos);
$limite = 10;
$paginas = ceil($total/$limite);
$pagina = min($paginas, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array('default'=> 1,'min_range' => 1,),)));
$offset = ($pagina - 1)  * $limite;
$start = $offset + 1;
$end = min(($offset + $limite), $total);

$botaoAnterior = ($pagina > 1) ? "" : "disabled";
$botaoProximo = ($pagina < $paginas) ? "" : "disabled";

if (empty($_GET['busca']) && empty($_GET['idPlataforma']) && empty($_GET['idGenero'])) {
    $get = "?";
} else {
    if (!empty($_GET['busca'])) {
        $get = "?busca=".$_GET['busca']."&";
    } else{

        if (!empty($_GET['idPlataforma'])) {
            $get = "?idPlataforma".$_GET['idPlataforma']."&";
        } elseif (!empty($_GET['idGenero'])) {
            $get = "?idGenero=".$_GET['idGenero']."&";
        }
    }
}
?>

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item <?php echo $botaoAnterior?>"><a class="page-link" href="<?php echo $get?>page=<?php echo $pagina-1?>">Anterior</a></li>
    <?php for ($i = 1; $i <= $paginas ; $i++) {
        $ativo = ($i==$pagina) ? "active" : ""; ?>
      <li class="page-item <?php echo $ativo?>"><a class="page-link" href="<?php echo $get?>page=<?php echo $i?>"><?php echo $i?></a></li>
    <?php } ?>
    <li class="page-item <?php echo $botaoProximo?>"><a class="page-link" href="<?php echo $get?>page=<?php echo $pagina+1?>">Proximo</a></li>
  </ul>
</nav>
<div class="row justify-content-around">
