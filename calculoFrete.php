<?php
require_once "funcoes.php";

$quantidadeDeProdutos = $_GET['quantidade'];
$quantidadeDeEmbalagens = ceil($quantidadeDeProdutos/5);
$peso = $quantidadeDeProdutos*0.3;
$cep = $_GET['cep'];
$resultado = calculaFrete(
  '41106',          // CÓDIGO DA OPERAÇÃO
  '80820320',       // CEP ORIGEM
  $cep,             // CEP DESTINO
  $peso,            // PESO DO PACOTE
  '8', '15', '20',  // DIMENSÕES DO PACOTE
  0);             // VALOR DECLARADO?

  $valor = floatval(str_replace(',', '.', str_replace('.', '', $resultado['valor'])));
  $freteTotal= floatval($valor * $quantidadeDeEmbalagens);
