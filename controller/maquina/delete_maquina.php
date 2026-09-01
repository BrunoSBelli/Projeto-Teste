<?php
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

$locacaoEntity = new Entity();
$id = $_POST['id'];

if(isset($id) && !empty($id))
{
    // PRIMEIRO: Buscar o caminho da imagem usando o método getInfo()
    $result = $locacaoEntity->getInfo("maquina", $id);
    
    if($result && count($result) > 0) {
        $caminhoImagem = $result[0]['path_image'];
        
        // Verificar se o caminho não está vazio e se o arquivo existe
        if(!empty($caminhoImagem) && file_exists($caminhoImagem)) {
            unlink($caminhoImagem); // Deleta o arquivo físico
        }
        
    }
    
    // SEGUNDO: Deletar o registro do banco
    $locacaoEntity->delete("maquina", $id);
    header("Location: ../../view/maquina/boardMaquina.php");
}
?>