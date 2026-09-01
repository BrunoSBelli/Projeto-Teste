<?php
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';
include_once("../../controller/login/autentique.php");
$entity = new Entity();


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
$pdfDir  = "$baseDir/assets/PropostaPDF_save";

// Cria pastas se não existirem
if (!is_dir($jsonDir)) mkdir($jsonDir, 0777, true);
if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

// Gera um token único e cria o JSON temporário
$token = bin2hex(random_bytes(8));
$jsonPath = "$jsonDir/token_{$token}.json";
file_put_contents($jsonPath, json_encode($dadosContrato, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Define o nome do PDF
$nomeArquivo = 'Proposta_Diamond_' . time() . '.pdf';

// Monta o comando do Puppeteer
$comando = "node " . escapeshellarg(__DIR__ . "/gerar_pdf_puppeteer.js") . " " .
           escapeshellarg($token) . " " . escapeshellarg($nomeArquivo);

// Executa o Puppeteer
exec($comando . " 2>&1", $output, $retorno);

if ($retorno === 0) {
    // Caminho relativo do PDF
    $pathPdf = "../../assets/PropostaPDF_save/$nomeArquivo";
    // IDs das Maquinas
    $idsMaquinas = $_POST['ids'] ?? [];
    

    // Insere no banco de dados
    $dadosInsert = [
        'id_usuario'   => $_SESSION['id'],
        'id_cliente' => $_POST['id_cliente'],
        'path_pdf'     => $pathPdf
    ];
    $entity->insert('proposta', $dadosInsert);

    $idProposta = $entity->getMaxId('proposta');


    foreach ($idsMaquinas as $idMaq) {

    $dadosUpdate = [
        'id_proposta'   => $idProposta,
        'id_maquina'     => $idMaq,
    ];

    $entity->insert('proposta_maquina', $dadosUpdate);

    $entity->update('maquina', ['status' => 'pendente_proposta'], $idMaq);

    }

    // Retorna o link público
    echo "http://localhost/Contrato/$pathPdf";
} else {
    echo "❌ Erro ao gerar PDF:\n" . implode("\n", $output);
}
?>

