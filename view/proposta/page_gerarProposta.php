<?php
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Entity.class.php';
    $baseDir = realpath(__DIR__ . '/../../');
    $tmpDir = $baseDir . '/assets/Temp';
    $locacaoEntity = new Entity();


// se há token, carrega JSON temporário
if (!empty($_GET['token'])) {
    $token = preg_replace('/[^a-z0-9]/i','', $_GET['token']);
    $jsonPath = $tmpDir . "/token_{$token}.json";
    if (file_exists($jsonPath)) {
        $dados = json_decode(file_get_contents($jsonPath), true);
        if (is_array($dados)) {
            // popula as variáveis como se viessem do POST
            $_POST = array_merge($_POST, $dados);
        }
        // opcional: você pode deletar o json logo após carregar, se não quiser manter arquivos
         unlink($jsonPath);
    }
}

/// IDs das máquinas
$id = $_POST['ids'] ?? $_GET['ids'] ?? [];
if (!is_array($id)) {
    if (strpos($id, ',') !== false) $id = explode(',', $id);
    else if ($id === '' || $id === null) $id = [];
    else $id = [$id];
}

// Se o cliente foi selecionado da tabela
$id_cliente = $_POST['id_cliente'] ?? null;
if ($id_cliente) {
    $cliente = $locacaoEntity->getInfo("cliente", $id_cliente)[0] ?? null;

    $razao_social = $cliente['razaosocial'] ?? '';
    $cnpj = $cliente['cnpj'] ?? '';
    $endereco = $cliente['endereco'] ?? '';
    $cidade = $cliente['cidade'] ?? '';
    $estado = $cliente['estado'] ?? '';
    $cep = $cliente['cep'] ?? '';
    $contato_comercial = $cliente['contato_comercial'] ?? '';
    $email = $cliente['email'] ?? '';
} else {
    // Preenchido manualmente
    $razao_social = $_POST['razaosocial'] ?? '';
    $cnpj = $_POST['cnpj'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $contato_comercial = $_POST['contato_comercial'] ?? '';
    $email = $_POST['email'] ?? '';
}


$i = 0; //Contador dos Anexos
$idProposta = $locacaoEntity->getMaxId('proposta');


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../../assets/img/icone.png" type="image/png">
    <title>Preview - Proposta</title>
    <link rel="stylesheet" href="../../assets/css/proposta.css">


</head>
<body >

    <button class="btn-compartilhar" id="emitirButton" onclick="gerarComPuppeteer()">📤 Emitir Proposta</button>

  <div class="page">
        <img class="logo" src="../../assets/img/Logo_Frezen.png">
        <div class="titulo">PROPOSTA COMERCIAL DE LOCAÇÃO Nº <?php echo str_pad($idProposta+1, 3, "0", STR_PAD_LEFT); ?>/<?php echo date('Y'); ?></div>
        <div class="emissao">Emissão: <span id="dataEmissao"></span></div>


        <div class="locador">
            <b>1. LOCADOR</b><br>
            <b>RAZÃO SOCIAL:</b> EMPRESA EXEMPLO LOCAÇÕES LTDA<br>
            <b>CNPJ:</b> 00.000.000/0001-00<br>
            <b>ENDEREÇO:</b> AVENIDA EXEMPLO, Nº 000 – BAIRRO EXEMPLO<br>
            <b>CIDADE:</b> CIDADE EXEMPLO &nbsp;&nbsp; <b>ESTADO:</b> SANTA CATARINA &nbsp;&nbsp; <b>CEP:</b> 00000-000<br>
            <b>CONTATO COMERCIAL:</b> EXEMPLO &nbsp;&nbsp; <b>E-MAIL:</b> contato@exemplo.com.br
        </div><br>

        <div class="locatario">
            <b>2. LOCATÁRIA</b><br>
            <b>RAZÃO SOCIAL:</b> <?php echo $razao_social?><br>
            <b>CNPJ:</b> <?php echo $cnpj?><br>
            <b>ENDEREÇO:</b> <?php echo $endereco?><br>
            <b>CIDADE:</b> <?php echo $cidade?> &nbsp;&nbsp; <b>ESTADO:</b> <?php echo $estado?> &nbsp;&nbsp; <b>CEP:</b> <?php echo $cep?><br>
            <b>CONTATO COMERCIAL:</b> <?php echo $contato_comercial?> &nbsp;&nbsp; <b>E-MAIL:</b> <?php echo $email?>
        </div>

        <div class="section">
            As partes supra qualificadas têm entre si, justos e acertados o presente instrumento e na melhor forma de direito, celebram o contrato de locação de empilhadeiras, que se regerá de acordo com as seguintes cláusulas e condições:
        </div>
        

    </div>
        
        <?php foreach ($id as $umId){ ?>
        <?php foreach($locacaoEntity->getInfo("maquina",$umId) as $maquina) {  ?>
            <div class="page">
                <img class="logo" src="../../assets/img/Logo_Frezen.png">
            <div class="section">
            <b>3.<?php echo$i?> – DESCRITIVO TÉCNICO DO ITEM</b>
                <table>
                    <tr><td>Tipo</td><td><?php echo $maquina['tipo']?></td><td rowspan="20">

                    <img class="imagem" src="<?php echo $maquina['path_image']?>" alt="" style="display:block; margin:auto; max-width: 400px; max-height: 400px; object-fit: contain;">
                    
                    
                    </td></tr>
                    <tr><td>Modelo</td><td><?php echo $maquina['modelo']?></td></tr>
                    <tr><td>Série</td><td><?php echo $maquina['serie']?></td></tr>
                    <tr><td>Ano / horímetro</td><td><?php echo $maquina['ano']?> / <?php echo $maquina['horimetro']?></td></tr>
                    <tr><td>Marca</td><td><?php echo $maquina['marca']?></td></tr>
                    <tr><td>Capacidade nominal(Kg)</td><td><?php echo $maquina['capacidade_nominal']?></td></tr>
                    <tr><td>Torre</td><td><?php echo $maquina['torre']?></td></tr>
                    <tr><td>Direção</td><td><?php echo $maquina['direcao']?></td></tr>
                    <tr><td>Deslocador lateral</td><td><?php echo $maquina['deslocador_lateral']?></td></tr>
                    <tr><td>Motor</td><td><?php echo $maquina['motor']?></td></tr>
                    <tr><td>Kit de iluminação</td><td><?php echo $maquina['kit_iluminacao']?></td></tr>
                    <tr><td>Protetor de carga</td><td><?php echo $maquina['protetor_carga']?></td></tr>
                    <tr><td>Protetor de corrente</td><td><?php echo $maquina['protetor_corrente']?></td></tr>
                    <tr><td>Altura de elevação</td><td><?php echo $maquina['altura_elevacao']?></td></tr>
                    <tr><td>Alarme de ré</td><td><?php echo $maquina['alarme_re']?></td></tr>
                    <tr><td>Comprimento do garfo</td><td><?php echo $maquina['comprimento_garfo']?></td></tr>
                    <tr><td>Tipo de Combustível</td><td><?php echo $maquina['tipo_combustivel']?></td></tr>
                    <tr><td>Pneus</td><td><?php echo $maquina['pneus']?></td></tr>
                    <tr><td>Cabine</td><td><?php echo $maquina['cabine']?></td></tr>
                    <tr><td>Posição do operador</td><td><?php echo $maquina['posicao_operador']?></td></tr>
                
                </table>
            </div>
            </div>

        <?php $i++; } ?>
        <?php } ?>
        



  <div class="page">
           <img class="logo" src="../../assets/img/Logo_Frezen.png">

            
            <div class="section">
            <b>4 – DESCRITIVO DOS VALORES</b><br>
            O valor proposto para as locações apresentadas é: 
            </div>
            <table>
                <tr>
                    <th>DESCRIÇÃO</th>
                    <th style="text-align: center;">LIMITE DE HORAS</th>
                    <th style="text-align: right;">VALOR TOTAL</th>
                </tr>
                <tr>
                    <td>Diária</td>
                    <td style="text-align: center;">8:48 horas diárias</td>
                    <td style="text-align: right;">R$ 350,00</td>
                </tr>
                <tr>
                    <td>Semanal</td>
                    <td style="text-align: center;">44:00 horas semanais</td>
                    <td style="text-align: right;">R$ 1.500,00</td>
                </tr>
                <tr>
                    <td>Mensal</td>
                    <td style="text-align: center;">200:00 horas mensais</td>
                    <td style="text-align: right;">R$ 4.000,00</td>
                </tr>
            </table>
            <div class="observacao">
                Observação: Será cobrado o valor de R$ 30,00 (trinta reais) por hora trabalhada, nos casos que excederem o total de horas contratado.
            </div>
            <br>
            <div class="section2">
                    <b>5 - PRAZO DE LOCAÇÃO</b><br>
                    O presente contrato tem prazo de duração de 1 ano mediante a entrega dos equipamentos pela LOCADORA à LOCATÁRIA, podendo ser prorrogado, 
                    sucessivamente, de comum acordo entre as partes.
            </div>
            
            <div class="section2">
                    <b>6 - DO TRANSPORTE</b><br>
                    O transporte de mobilização e de desmobilização dos equipamentos é de responsabilidade exclusiva da LOCADORA.
            </div>
            
            
            <div class="section2">
                <b>7 - DAS MANUTENÇÕES</b><br>
                A competência de fornecimento dos insumos e mão-de-obra necessários para o funcionamento dos equipamentos, 
                será definido pelos critérios abaixo relacionados, e em caso de serem de competência da FREZEN já estão inclusos nos preços cotados.
            </div>
            

            <div class="section">
                <table style="font-weight: bold;">
                    <tr><td rowspan="2" id="centro">ITEM</td><td rowspan="2" id="centro">DESCRIÇÃO</td><td colspan="2" id="centro">COMPETÊNCIA DIRETA DA OPERAÇÃO</td></tr>
                    <tr><td id="centro">FREZEN</td><td id="centro">LOCATÁRIA</td> </tr>
                    <tr><td id="centro">1</td><td>Pneus e Rodagem</td> <td id="centro">X</td><td></td></tr>
                    <tr><td id="centro">2</td><td>Filtros</td> <td id="centro">X</td><td></td></tr>
                    <tr><td id="centro">3</td><td>Óleos lubrificantes</td> <td id="centro">X</td><td></td></tr>
                    <tr><td id="centro">4</td><td>Peças de reposição</td> <td id="centro">X</td><td></td></tr>
                    <tr><td id="centro">5</td><td>Mão de obra de manutenção</td> <td id="centro">X</td><td></td></tr>
                    <tr><td id="centro">6</td><td>Combustível</td> <td></td><td id="centro">X</td></tr>
                    <tr><td id="centro">7</td><td>Manutenção corretiva por mau uso</td> <td></td><td id="centro">X</td></tr>
                    <tr><td id="centro">8</td><td>Operador de empilhadeira</td> <td></td><td id="centro">X</td></tr>
                    <tr><td id="centro">9</td><td>Seguro total</td> <td></td><td id="centro">X</td></tr>

                </table>
            </div>
            <div class="section">
            A LOCATÁRIA deverá passar semanalmente para a FREZEN o horímetro, para controle das manutenções.
            </div>

            <div class="section">
            A FREZEN será responsável pela manutenção preditiva, preventiva e corretiva dos equipamentos locados, 
            envolvendo revisões elétricas e mecânicas, troca de óleos, filtros, peças, da empilhadeira MEDIANTE DEFEITOS DE FABRICAÇÃO, 
            fornecimento de mão de obra especializada em oficina própria ou da LOCATÁRIA (contemplando espaço físico apropriado, energia, água potável, ar comprimido).
            </div>

            <div class="section">
            Caberá a <b>LOCATÁRIA</b> manter as máquinas limpas e proceder com as seguintes verificações visando manter a qualidade e bom funcionamento dos equipamentos, 
            notificando a <b>LOCADORA</b> imediatamente caso identifique algum sinal de irregularidade nestes itens:

                <ul>
                    <li>Análise visual externa do equipamento, inclusive da torre de elevação;</li>
                    <li>Verificar e realizar limpeza do radiador com ar comprimido ao início de cada turno;</li>
                    <li>Verificar o nível de óleo do motor;</li>
                    <li>Verificar o nível de água do reservatório do radiador;</li>
                    <li>No caso de rodagens pneumáticas, efetuar calibragem conforme especificação do fabricante;</li>
                    <li>Verificar a iluminação externa dos equipamentos e extintor de incêndio.</li>

                </ul>
            </div>

            <div class="section">
                <b>7 - LOCAL DA OPERAÇÃO</b><br>
                Nas instalações da locatária informado no ato da assinatura do contrato. O equipamento não poderá mudar de local de operação ou ser sublocado, 
                sem prévio comunicado ao locador e posterior negociação.
            </div>
            
  </div>

  <div class="page">
        <img class="logo" src="../../assets/img/Logo_Frezen.png">

        <div class="section">
                <b>8 - PRAZO DE ENTREGA DOS EQUIPAMENTOS</b><br>
                O prazo para entrega dos equipamentos é imediato após a assinatura do contrato.
        </div>
        <div class="section">
                <b>9 - FORMA DE PAGAMENTO</b><br>
                A locação deverá ser paga em até <u>30 dias da entrega do equipamento nas dependências da LOCATÁRIA</u>, mediante a apresentação do recibo de locação.
        </div>
        <div class="section">
            <b>10 – CONDIÇÕES DE USO</b><br>
            Todas as manutenções necessárias e peças de reposição são de responsabilidade da FREZEN. 
            Nos eventuais casos de danos ou necessidade de manutenções provocados por mau uso, os custos dos reparos serão de responsabilidade da LOCATÁRIA.
        </div>
        <div class="section">
            <b>11 – CASOS DE SINISTRO</b><br>
            Em caso de sinistro com reparos e furtos, a LOCATÁRIA deverá comunicar a <b>FREZEN</b> em um prazo máximo de 2 (duas horas).
        </div>
        <div class="section">
            <b>12 – FIEL DEPOSITÁRIA</b><br>
            A LOCATÁRIA também reconhece expressamente mediante a assinatura do presente instrumento sua condição de FIEL DEPOSITÁRIA dos 
            bens locados assumindo as responsabilidades legais previstas em relação a esta condição.
        
        </div>
        <div class="section">
            <b>13 – FORO</b><br>
            As partes elegem o foro da Comarca de Rio Negrinho (SC), para dirimir eventuais dúvidas ou questões decorrentes do presente instrumento, 
            com exclusão de qualquer outro por mais privilegiado que seja.

        </div>
        <div class="section">
            E por assim estarem justos e contratados as partes firmam o presente instrumento, em 02 (duas) vias de igual teor e forma, 
            na presença das testemunhas abaixo, para que produza seus jurídicos e legais efeitos.
        </div>

        <div class="data">Rio Negrinho, <span id="dataRodape"></span></div>
        
        <div class="assinaturas">
            <div class="assinatura">
                <div class="linha"></div>
                <p>FREZEN MÁQUINAS E EQUIPAMENTOS LTDA</p>
            </div>

            <div class="assinatura">
                <div class="linha"></div>
                <p><?php echo $razao_social?></p>
            </div>
        </div>

  </div>  
  
<script>
  const hoje = new Date();
  const opcoes = { day: '2-digit', month: 'long', year: 'numeric' };
  document.getElementById("dataEmissao").textContent =
      hoje.toLocaleDateString('pt-BR', opcoes);
  document.getElementById("dataRodape").textContent =
      hoje.toLocaleDateString('pt-BR', opcoes);

      
function gerarComPuppeteer() {
  const params = new URLSearchParams();

  const ids = <?php echo json_encode($id); ?>;

  ids.forEach(id => {
    params.append('ids[]', id);
  });
  
  params.append('id_cliente', "<?php echo addslashes($id_cliente); ?>");
  
  params.append('razaosocial', "<?php echo addslashes($razao_social); ?>");
  params.append('cnpj', "<?php echo addslashes($cnpj); ?>");
  params.append('endereco', "<?php echo addslashes($endereco); ?>");
  params.append('cidade', "<?php echo addslashes($cidade); ?>");
  params.append('estado', "<?php echo addslashes($estado); ?>");
  params.append('cep', "<?php echo addslashes($cep); ?>");
  params.append('contato_comercial', "<?php echo addslashes($contato_comercial); ?>");
  params.append('email', "<?php echo addslashes($email); ?>");

  fetch("../../controller/proposta/gerar_pdf_puppeteer.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: params
  })
  .then(r => r.text())
  .then(url => {
    if (url.startsWith("http")) {
      alert("Proposta gerada com sucesso!");
      window.location.href = "./boardProposta.php";
    } else {
      alert("Erro ao gerar PDF:\n" + url);
    }
  });
}

const botao = document.getElementById('emitirButton');
  
  botao.addEventListener('click', function(event) {
    // Desabilita o botão
    event.target.disabled = true;
    event.target.innerText = 'Processando...';
    
    // Insira aqui a lógica de envio (ex: fetch, ajax, etc)
    
  });

</script>


</body>
</html>

