<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $Entity = new Entity();
     $data = $_POST;

     if(isset($data) && !empty($data))
     {
        //chama o banco
        $Entity->insert("cliente",$data);
        header("Location: ../../view/cliente/boardCliente.php");
     }


?>
