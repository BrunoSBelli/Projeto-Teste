<?php
     include_once '../../model/Conexao.class.php';
     include_once '../../model/Entity.class.php';

     $locacaoEntity = new Entity();
     $data = $_POST;
     $id = $_POST["id"];
     $foto = $_FILES['picture__input'];

     if(isset($data) && !empty($data))
     {
        // Processamento do upload da imagem (se uma nova foi enviada)
        if(isset($foto) && $foto['error'] == 0){
            
            if($foto['size'] > 10485760){
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
                // PRIMEIRO: Buscar e deletar a imagem antiga (se existir)
                $result = $locacaoEntity->getInfo("maquina", $id);
                
                if($result && count($result) > 0) {
                    $caminhoImagemAntiga = $result[0]['path_image'];
                    
                    // Verificar se o caminho não está vazio e se o arquivo existe
                    if(!empty($caminhoImagemAntiga) && file_exists($caminhoImagemAntiga)) {
                        unlink($caminhoImagemAntiga); // Deleta o arquivo físico antigo
                    }
                }
                
                // DEPOIS: Atualiza com o novo caminho da imagem
                $caminhoFoto = $pasta . $novoNomeFoto . "." . $extensao;
                $data['path_image'] = $caminhoFoto; // Coloca no caminho do banco
            }
        } else {
            // Se não foi enviada nova imagem, mantém a imagem atual
            $data['path_image'] = $_POST['current_image_path'];
        }

        // Remove o campo current_image_path do array $data para não tentar atualizar no banco
        unset($data['current_image_path']);

        //chama o banco
        $locacaoEntity->update("maquina",$data,$id);
        header("Location: ../../view/maquina/boardMaquina.php");
     }
?>