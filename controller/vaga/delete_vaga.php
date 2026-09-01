<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $vagaEntity = new Entity();
     $id = $_POST['id'];

     if(isset($id) && !empty($id))
     {
        //chama o banco
        $vagaEntity->delete("vaga",$id);
        header("Location: ../../view/vaga/boardAdm.php");
     }


?>
