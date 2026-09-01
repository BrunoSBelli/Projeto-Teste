<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $funcEntity = new Entity();
     $id = $_POST['id'];

     if(isset($id) && !empty($id))
     {
        //chama o banco
        $funcEntity->delete("funcionario",$id);
        header("Location: ../../view/funcionario/boardFunc.php");
     }


?>
