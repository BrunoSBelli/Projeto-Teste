<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $Entity = new Entity();
     $id = $_POST['id'];

     if(isset($id) && !empty($id))
     {
        //chama o banco
        $Entity->delete("cliente",$id);
        header("Location: ../../view/cliente/boardCliente.php");
     }


?>
