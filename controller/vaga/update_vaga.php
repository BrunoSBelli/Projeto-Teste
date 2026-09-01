<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $vagaEntity = new Entity();
     $data = $_POST;
     $id = $_POST["id"];

     if(isset($data) && !empty($data))
     {
        //chama o banco
        $vagaEntity->update("vaga",$data,$id);
        header("Location: ../../view/vaga/boardAdm.php");
     }


?>
