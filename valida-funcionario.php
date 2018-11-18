<?php
session_start();

if (empty($_SESSION['login'])) {
  $_SESSION['login'] = [];
}

define("DSN", "mysql");
define("SERVIDOR", "localhost");
define("USUARIO", "luislocio");
define("SENHA", "73917391");
define("BANCODEDADOS", "gamesmaga");

function conectar()
{
  try {
    $conn = new PDO(DSN.':host='.SERVIDOR.';dbname='.BANCODEDADOS, USUARIO, SENHA);
    return $conn;
  } catch (PDOException $e) {
    echo ''.$e->getMessage();
  }
}

$conn = conectar();

$login = $_POST['login'];
$senha = $_POST['senha'];

$statement = $conn->prepare("SELECT login, senha, id, acesso FROM FUNCIONARIOS WHERE login=:login LIMIT 1");
$statement->bindParam(':login', $login);
$statement->execute();
$retorno = $statement->fetch(PDO::FETCH_ASSOC);

if ($retorno) {
  if (md5($_POST['senha']) == $retorno['senha']) {
    $_SESSION['login']['login']=$retorno['login'];
    $_SESSION['login']['id']=$retorno['id'];
    $_SESSION['login']['acesso']=$retorno['acesso'];
    header('Location: boas-vindas.php');
  }else {
    loginInvalido()
    header('Location: login-funcionario.php');
  }
} else {
  loginInvalido()
  header('Location: login-funcionario.php');
}
