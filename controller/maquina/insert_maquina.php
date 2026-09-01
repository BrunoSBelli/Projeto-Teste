<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $locacaoEntity = new Entity();

     $data = $_POST;
     $foto = $_FILES['path_image'];

     if(isset($data) && !empty($data))
     {
      $caminhoFoto = "";

      if(isset($foto) && $foto['error'] == 0){

      
      if($foto['size']> 10485760){
         die("Arquivo muito grande!! Max: 10MB");
      }

      $pasta = "../../assets/upload/";
      $nomeFoto = $foto['name'];
      $novoNomeFoto = uniqid();
      $extensao = strtolower(pathinfo($nomeFoto, PATHINFO_EXTENSION));

      if($extensao != 'jpg' && $extensao != 'png' && $extensao != 'jpeg'){
         die("Extensão não aceita!");
      }

      $deu_certo = move_uploaded_file($foto["tmp_name"], $pasta . $novoNomeFoto . "." . $extensao);

      if($deu_certo){
            // ATUALIZA O CAMINHO DA IMAGEM NO ARRAY $data
            $caminhoFoto = $pasta . $novoNomeFoto . "." . $extensao;
            $data['path_image'] = $caminhoFoto; //Coloca no caminho do banco
        }
   }


        //chama o banco
        $locacaoEntity->insert("maquina",$data);
        header("Location: ../../view/maquina/boardMaquina.php");
     }


?>