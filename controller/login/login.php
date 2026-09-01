<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

// 🔒 Bloqueia acesso direto
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php");
    exit;
}

// 🔒 Validação básica
if (empty($_POST['login']) || empty($_POST['senha'])) {
    header("Location: ../../index.php?erro=1");
    exit;
}

$login = trim($_POST['login']);
$senha = trim($_POST['senha']);

$loginEntity = new Entity();
$usuario = $loginEntity->login("funcionario", $login);

if (!$usuario) {
    echo "<script>
        alert('Login e/ou senha incorretos');
        window.location.href='../../index.php';
    </script>";
    exit;
}

if (!password_verify($senha, $usuario['senha'])) {
    echo "<script>
        alert('Login e/ou senha incorretos');
        window.location.href='../../index.php';
    </script>";
    exit;
}

// 🔑 Login válido
session_regenerate_id(true);

$_SESSION['usuario'] = $usuario['login'];
$_SESSION['id']      = $usuario['id'];
$_SESSION['logado']  = true;

header("Location: ../../view/menu/menu.php");
exit;

