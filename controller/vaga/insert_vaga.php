<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $vagaEntity = new Entity();
     $data = $_POST;

     if(isset($data) && !empty($data))
     {
        //chama o banco
        $vagaEntity->insert("vaga",$data);
        header("Location: ../../view/vaga/boardAdm.php");
     }


?>
