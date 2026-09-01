<?php

include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

$funcEntity = new Entity();

$data = $_POST;
$id = $_POST["id"];

unset($data['id']);

if (!empty($data['senha'])) {
    $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
} else {
    unset($data['senha']);
}

if (!empty($data)) {

    $funcEntity->update("funcionario", $data, $id);

    header("Location: ../../view/funcionario/boardFunc.php");
}
