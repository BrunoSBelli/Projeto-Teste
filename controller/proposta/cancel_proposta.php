<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $Entity = new Entity();
     $id = $_POST["id_proposta"];

     if(isset($id) && !empty($id))
     {
        //chama o banco
        $Entity->cancelProposta($id);
        header("Location: ../../view/proposta/boardProposta.php");
     }


?>