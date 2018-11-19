<?php
require_once "funcoes.php";

// Declaração de variáveis da sessão
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = [];
}

// Instancia conexão com o banco de dados
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
        header('Location: index.php');
        exit;
    } else {
        loginInvalido();
        header('Location: login.php');
        exit;
    }
} else {
    loginInvalido();
    header('Location: login.php');
    exit;
}
