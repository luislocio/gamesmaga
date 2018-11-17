<?php
session_start();

require_once "funcoes.php";

$quantidadeDeProdutos = $_GET['quantidade'];
$quantidadeDeEmbalagens = ceil($quantidadeDeProdutos/5);
$peso = $quantidadeDeProdutos*0.3;
$cep = $_GET['cep'];
$resultado = calculaFrete(
  '41106',
  '80820320',
  $cep,
  $peso,
  '8', '15', '20', 0 );
  $valor = floatval(str_replace(',', '.', str_replace('.', '', $resultado['valor'])));
  $freteTotal= floatval($valor * $quantidadeDeEmbalagens);
  console_log($freteTotal);
