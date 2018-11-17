<?php
session_start();

require_once "funcoes.php";

if (empty($_SESSION['login'])) {
    $_SESSION['login'] = [];
}

$conn = conectar();

$login = $_POST['login'];
$senha = $_POST['senha'];
$statement = $conn->prepare("SELECT login, senha, id FROM CLIENTES WHERE login=:login LIMIT 1");
$statement->bindParam(':login', $login);
$statement->execute();
$retorno = $statement->fetch(PDO::FETCH_ASSOC);

if ($retorno) {
    if (md5($_POST['senha']) == $retorno['senha']) {
        $_SESSION['login']['login'] = $retorno['login'];
        $_SESSION['login']['id'] = $retorno['id'];
        $_SESSION['login']['acesso'] = "cliente";
        console_log($_SESSION);
        header('Location: index.php');
    } else {
      console_log("Senha ou login invalido");
      header('Location: login.php');
    }
} else {
    console_log("Senha ou login invalido");
    header('Location: login.php');
}
