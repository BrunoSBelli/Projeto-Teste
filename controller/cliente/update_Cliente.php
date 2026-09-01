<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $Entity = new Entity();
     $data = $_POST;
     $id = $_POST["id"];

     if(isset($data) && !empty($data))
     {
        //chama o banco
        $Entity->update("cliente",$data,$id);
        header("Location: ../../view/cliente/boardCliente.php");
     }


?>
