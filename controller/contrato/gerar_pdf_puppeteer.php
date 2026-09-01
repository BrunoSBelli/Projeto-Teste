<?php
include_once("../../controller/login/autentique.php");
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';
$entity = new Entity();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo "Usuário não autenticado.";
    exit;
}

// Recebe os dados do contrato
$dadosContrato = $_POST ?? [];
if (empty($dadosContrato)) {
    http_response_code(400);
    echo "Nenhum dado recebido.";
    exit;
}


// Caminhos base
$baseDir = realpath(__DIR__ . '/../../');
$jsonDir = "$baseDir/assets/Temp";
$pdfDir  = "$baseDir/assets/ContratoPDF_save";

// Cria pastas se não existirem
if (!is_dir($jsonDir)) mkdir($jsonDir, 0777, true);
if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

// Gera um token único e cria o JSON temporário
$token = bin2hex(random_bytes(8));
$jsonPath = "$jsonDir/token_{$token}.json";
file_put_contents($jsonPath, json_encode($dadosContrato, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Define o nome do PDF
$nomeArquivo = 'Contrato_Diamond_' . time() . '.pdf';

// Monta o comando do Puppeteer
$comando = "node " . escapeshellarg(__DIR__ . "/gerar_pdf_puppeteer.js") . " " .
           escapeshellarg($token) . " " . escapeshellarg($nomeArquivo);

// Executa o Puppeteer
exec($comando . " 2>&1", $output, $retorno);

if ($retorno === 0) {
    // Caminho relativo do PDF
    $pathPdf = "../../assets/ContratoPDF_save/$nomeArquivo";
    $data_atual = new DateTime();
    $data_fim = $data_atual->modify('+1 year');

    //IDS maquina
    $idsMaquinas = $_POST['ids'] ?? [];
        if (!is_array($idsMaquinas)) $idsMaquinas = [$idsMaquinas];
    
    $idProposta = $_POST['id_proposta'] ?? null;
        if(!$idProposta){
            http_response_code(400);
            echo "ID de Proposta não encontrado";
            exit;
        }



    //inserir no contrato
    $dadosInsert = [
        'id_proposta' => $idProposta,
        //'id_usuario'   => $_SESSION['id'], colocar depois!
        'path_pdf'=> $pathPdf,
        'data_fim'=> $data_fim->format('Y-m-d')
    ];
    $entity->insert('contrato', $dadosInsert);
    $idContrato = $entity->getMaxId('contrato');


    //inserir no contrato maquina, praticamente copiar
    
    $entity->copyMaquina($idProposta, $idContrato);

    //atualiza status proposta
    $entity->update('proposta', ['status' => 'convertida_em_contrato'], $idProposta);

    //atualiza maquina!!!Finalmente funcionando!
    $entity->updateStatusMaquina('em_uso', $idProposta );

    
//
   // $dadosUpdate = [ 
        //'id_usuario'   => $_SESSION['id'], colocar depois na proposta!
    //    'status'     => "convertida_em_contrato"
   // ];

   // $entity->update('proposta', $dadosUpdate, $idProposta);



   // foreach ($idsMaquinas as $idMaq) {

    
  //  }

    // Retorna o link público
    echo "http://localhost/Contrato/$pathPdf";
} else {
    echo "❌ Erro ao gerar PDF:\n" . implode("\n", $output);
}
?>

