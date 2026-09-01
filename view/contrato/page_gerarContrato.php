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


//Contador dos Anexos
$i = 0;

//chamando dados de contador
$idProposta = $locacaoEntity->getMaxId('proposta');
$idContrato = $locacaoEntity->getMaxId('contrato');


//Chamando dados do proposta
$id_proposta = $_POST['id_proposta'] ?? null;


//Chamando dados do cliente
$id_cliente = $_POST['id_cliente'] ?? null;
$cliente = $locacaoEntity->getInfo("cliente", $id_cliente)[0] ?? null;
$razao_social = $cliente['razaosocial'];

//chamando dados da Maquina
$maquinas = $locacaoEntity->getDadosMaquinas($id_proposta);
$soma = 0.0;
 foreach ($maquinas as $m) {
    $valor = str_replace(',', '.', $m['valor']);
    $soma += (float) $valor;
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../../assets/img/icone.png" type="image/png">
    <title>Preview - Contrato</title>
    <link rel="stylesheet" href="../../assets/css/proposta.css">
    <style>
        body {
            font-size: 11pt;
            }
    </style>


</head>
<body >


<button class="btn-compartilhar" id="emitirButton" onclick="gerarComPuppeteer(<?= $id_proposta; ?>)">📤 Emitir Contrato</button>

  <div class="page">
        <img class="logo" src="../../assets/img/Logo_Frezen.png">
        <div class="titulo">CONTRATO DE LOCAÇÃO MERCANTIL Nº <?php echo str_pad($idContrato+1, 3, "0", STR_PAD_LEFT); ?>/<?php echo date('Y'); ?></div>


        <div class="section">
           <b>LOCADORA: EMPRESA EXEMPLO LOCAÇÕES LTDA</b>, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº 00.000.000/0001-00, 
           estabelecida na Avenida Exemplo, Nº 000, bairro Exemplo, na cidade de Cidade Exemplo (SC), neste ato, representada pelo 
           seu sócio diretor Fulano de Tal, inscrito no CPF sob o número 000.000.000-00, doravante denominada <b>LOCADORA</b>.
        </div>

        <div class="section">
           <b>LOCATÁRIA: <?=$cliente['razaosocial']?></b>, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº <?=$cliente['cnpj']?>,
           estabelecida no(a) <?=$cliente['endereco']?>, na cidade de <?=$cliente['cidade']?> (<?=$cliente['estado']?>), neste ato, representada
           por seu(sua) sócio(a) <?=$cliente['socio']?>, inscrita no CPF sob o número <?=$cliente['cpf']?>, doravante denominada <b>LOCATÁRIA</b>.
        </div>

        <div class="section">
           ENDEREÇO DA OBRA: <?=$cliente['endereco_obra']?>
        </div>

        <div class="section">
            As partes supra qualificadas têm entre si, justos e acertados o presente instrumento e na melhor forma de direito, celebram o contrato de locação de empilhadeiras, que se regerá de acordo com as seguintes cláusulas e condições:
        </div>

        <div class="section">
            <b>CLÁUSULA PRIMEIRA – DO OBJETO</b><br><br>
            1.1 – O objeto do presente contrato consiste na locação pela <b>LOCADOR</b> dos equipamentos conforme descrições abaixo, 
                incluindo a manutenção preventiva e corretiva, mão de obra para manutenção e deslocamento, pela <b>LOCATÁRIA</b>.

                <ol type="A">

                
                    <?php foreach ($maquinas as $m) {?>
                        <li> <?= strtoupper($m['tipo']) ?>, marca <?= $m['marca'] ?>, modelo <?= $m['modelo'] ?>, ano <?= $m['ano'] ?>, com características técnicas e capacidade operacional 
                            conforme proposta comercial nº <?= $id_proposta ?>, incluindo acessórios originais, conforme notas fiscais de remessa e registros fotográficos anexos.
                    <?php }?>

                </ol>
        </div>

        <div class="section">
            <b>CLÁUSULA SEGUNDA – DO PRAZO DE LOCAÇÃO</b><br><br>
            2.1 – O presente contrato tem prazo de duração anual, iniciando-se em 18/06/2026, mediante a entrega dos equipamentos 
            pela <b>LOCADORA</b> à <b>LOCATÁRIA</b>, podendo ser prorrogado, sucessivamente, de comum acordo entre as partes, mediante aditivo contratual.<br><br>

            2.2 – A qualquer das partes fica assegurada a prerrogativa de imediato desfazimento do vínculo contratual, independente de aviso prévio, no caso de 
            uma das partes requerer a recuperação judicial ou extrajudicial ou estiver em trâmite pedido ou processo de falência ou liquidação judicial ou extrajudicial.



                
        </div>

        

   </div>
        

  <div class="page">
           <img class="logo" src="../../assets/img/Logo_Frezen.png">

            
            <div class="section">
            2.3 – A <b>LOCADORA</b> poderá ainda optar pela imediata rescisão deste contrato se a <b>LOCATÁRIA</b> ficar inadimplente durante 02 (dois) meses, 
                sejam eles consecutivos ou não, cabendo da mesma forma multa contratual, bem como eventuais ressarcimentos a título de perdas e danos incorridos 
                pela <b>LOCADORA</b> devido a rescisão antecipada do contrato.
            </div>

            <div class="section">
            <b>CLÁUSULA TERCEIRA – DO VALOR E DAS CONDIÇÕES DE PAGAMENTO</b><br><br>

            3.1 – Fica ajustado que o valor mensal total da locação será de R$ <?php echo number_format($soma, 2, ',', '.');?> composto da seguinte forma:<br>
            <?php foreach ($maquinas as $m) {?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $m['tipo']?> <?php echo $m['serie']?>		R$ <?php echo $m['valor']?><br>
                    <?php }?>
                
            </div>

            <div class="section">
            3.2 – A <b>LOCADORA</b> entregará para a <b>LOCATÁRIA</b> o recibo no primeiro dia do início da locação, com o vencimento para 30 dias do início da locação. 
            Os valores serão cobrados a partir da data de entrega dos equipamentos pela <b>LOCADORA</b> até a data de devolução dos mesmos pela <b>LOCATÁRIA</b>.
            </div>

            <div class="section">
            3.3 – Ocorrendo atraso no pagamento, a <b>LOCATÁRIA</b> ficará sujeita à incidência de correção monetária com juros de 3% (três por cento) ao mês e multa 
            moratória de 3% (três por cento).
            </div>

            <div class="section">
            <b>CLÁUSULA QUARTA – DAS RESPONSABILIDADES DA LOCADORA</b><br><br>

            4.1 – A <b>LOCADORA</b> será responsável pela manutenção preventiva e corretiva das máquinas envolvendo revisões elétricas e mecânicas, troca de óleos,
            filtros, peças, fornecimento de mão de obra especializada para as manutenções em oficina própria.
            </div>

            <div class="section">
            4.2 – Deverá igualmente a <b>LOCADORA</b> adotar a identificação para os seus funcionários que vierem a executar algum serviço, na forma a ser aprovada 
            pela <b>LOCATÁRIA</b>, assim como não permitir o ingresso de pessoas estranhas aos serviços, sem autorização desta.
            </div>

            <div class="section">
            4.3 – A <b>LOCADORA</b> deverá tomar conhecimento e cumprir as normas de segurança de trabalho, previstas pelo Departamento Nacional de Segurança e 
            Higiene do Trabalho, suas portarias bem como os regulamentos internos da <b>LOCATÁRIA</b>, zelando para que as mesmas sejam observadas com rigor pelos seus 
            empregados que vierem a executar os pequenos reparos.
            </div>

            <div class="section">
            <b>CLÁUSULA QUINTA – DAS RESPONSABILIDADES DA LOCATÁRIA</b><br><br>

            5.1 – No ato da entrega da empilhadeira objeto desse contrato a <b>LOCATÁRIA</b> deverá conferir e dar ciência do recebimento das máquinas através 
            do WhatsApp 47 99933-5341.
            </div>

            <div class="section">
                <ul type="none">
                    <li>(i) Manter todas as máquinas e equipamentos com seguro total durante toda a vigência do contrato de locação;
                    <li>(ii) Prover a guarda, conservação e limpeza dos Equipamentos locados, bem como utilizá-los de modo a não lhes causar danos ou sequelas, 
                        ressalvado o desgaste por uso normal, observado o previsto nos Manuais de Operação, e devolvê-los com as mesmas características e funcionalidades quando de seu recebimento;
                </ul>

            </div>
    
  </div>

  <div class="page">
        <img class="logo" src="../../assets/img/Logo_Frezen.png">

        <div class="section">
                <ul type="none">
                    <li>(iii) Manter e utilizar os equipamentos locados única e exclusivamente no local indicado na Proposta, podendo removê-los somente mediante 
                        autorização prévia e por escrito da <b>LOCADORA</b>;
                    <li>(iv) Respeitar o direito de propriedade da <b>LOCADORA</b> em relação ao(s) Equipamento(s) locado(s) e seus acessórios, assim como não os oferecer 
                        em garantia, sublocá-los ou cedê-los a terceiros, seja a título gratuito ou oneroso;
                    <li>(v) Arcar com os custos de itens, peças e mão de obra, para instalação de quaisquer itens e/ou equipamentos que julgue necessário para a 
                        execução das suas tarefas, com prévia autorização da <b>LOCADORA</b>, além daqueles originalmente instalados nas empilhadeiras;
                    <li>(vii) A <b>LOCATÁRIA</b> compromete-se a comunicar a <b>LOCADORA</b> quando a utilização dos Equipamentos se aproximar a 250 horas, para fins de agendamento 
                        da manutenção preventiva, por meio dos seguintes canais: (i) WhatsApp (00) 00000-0000, ou (iii) e-mail: contato@exemplo.com.br, durante o horário comercial;
                    <li>(viii) Atingido este limite, a <b>LOCATÁRIA</b> compromete-se a desligar e não mais utilizar o Equipamento até que seja realizada a manutenção preventiva pela <b>LOCADORA</b>, 
                        sob pena de, não o fazendo, responder por quaisquer falhas ou danos causados no Equipamento ou a terceiros em decorrência da não realização da manutenção preventiva no período adequado;
                    <li>(ix) Efetuar o pagamento pontualmente dos valores devidos na Proposta, no Contrato e seus anexos, incluindo, mas não se limitando aos locatícios pactuados, assistência técnica. Formulário 
                        de Despesas, Relatório de Cobrança de Danos. ART's (Avisos de Responsabilidade Técnica) quando for o caso, Treinamentos quando for o caso.
                    <li>(x) A <b>LOCATÁRIA</b> é a única e exclusiva responsável pelo manejo e operação dos Equipamentos, assim como por garantir que os operadores destes sejam devidamente habilitados e 
                        treinados, respondendo integralmente, perante a <b>LOCADORA</b> e quaisquer terceiros, por quaisquer perdas e danos ocasionados, isentando a <b>LOCADORA</b> e seus colaboradores desde já por 
                        qualquer responsabilidade neste sentido;
                    <li>(xi) Permitir, a qualquer tempo, independentemente de prévio aviso e agendamento, desde que em horário comercial, a livre inspeção dos Equipamentos por parte da <b>LOCADORA</b>, 
                        inclusive se os Equipamentos forem mantidos em locais geridos por terceiros;
                    <li>(xii) Prestar informações do valor do horímetro sempre que solicitado pela <b>LOCADORA</b>;
                    <li>(xiii) Quando aplicável, promover a limpeza dos Equipamentos, radiadores, abastecer os tanques de combustíveis e lubrificar e, se necessário, consertar e calibrar os pneus, 
                        bem como completar o nível de eletrólito das baterias na inspeção diária, do nível de óleo de motor e do líquido de arrefecimento (em máquinas com motor de combustão interna);
                    <li>(xiv) Abastecer os Equipamentos com o tipo de combustível adequado e de boa qualidade, conforme orientação contida no Manual de Operações dos Equipamentos;
                    <li>(xv) Guardar os Manuais de Operação e devolvê-los junto com os Equipamentos, sob pena de, não o fazendo, arcar com os custos equivalentes;
                    <li>(xvi) Respeitar os limites de elevação de carga, nos termos do Manual de Operação dos Equipamentos;

                    </ul>

            </div>

            <div class="section">
            5.2 – Caberá a <b>LOCATÁRIA</b> manter as máquinas limpas e proceder com as seguintes verificações visando manter a qualidade e bom funcionamento dos equipamentos, notificando a <b>LOCADORA</b>
            imediatamente caso identifique algum sinal de irregularidade nestes itens:

                <ul>
                    <li>Análise visual externa do equipamento;
                    <li>Verificar e realizar limpeza ar comprimido ao início de cada turno;
                    <li>Semanalmente realizar a lubrificação completa do equipamento;
                    <li>Verificar as luzes de sinalização.

                </ul>

            </div>

  </div>
  <div class="page">
        <img class="logo" src="../../assets/img/Logo_Frezen.png">
        <div class="section">
            5.3 – Por ocasião da devolução dos equipamentos, a <b>LOCADORA</b> realizará uma inspeção e caso seja verificada qualquer irregularidade, dano, quebra, 
            amassados e danos na pintura que não seja proveniente de desgaste natural decorrente do uso normal e correto estes serão comunicados pela <b>LOCADORA</b> à 
            <b>LOCATÁRIA</b> que no prazo de 48 (quarenta e oito) horas deverá comparecer ao local onde se encontra a empilhadeira para a realização de inspeção conjunta. O não comparecimento da 
            <b>LOCATÁRIA</b> implicará em sua expressa aceitação da inspeção realizada pela <b>LOCADORA</b> e dos valores apurados dos danos, que deverão ser reembolsados à <b>LOCADORA</b> e desde já reconhecidos como certos, 
            líquidos e exigíveis.

        </div>

        <div class="section">
            5.4 – A <b>LOCATÁRIA</b> deve promover a guarda e vigilância dos equipamentos, responsabilizando-se pela integridade e segurança contra roubo, furto, incêndio, vandalismo ou depredações 
            comprometendo-se a indenizar a <b>LOCADORA</b> por eventuais prejuízos destas naturezas.

        </div>

        <div class="section">
            5.5 – A <b>LOCATÁRIA</b> poderá ceder sua posição contratual a terceiro mediante anuência expressa da <b>LOCADORA</b>, conforme previsto nos artigos 286 a 298 do Código Civil brasileiro.

        </div>

        <div class="section">
            <b>CLÁUSULA SEXTA – DO FORO</b><br><br>

            6.1 – As partes elegem o foro da Comarca de Rio Negrinho (SC), para dirimir eventuais dúvidas ou questões decorrentes do presente instrumento, com exclusão de qualquer outro por mais 
            privilegiado que seja.<br><br>

            E por assim estarem justos e contratados as partes firmam o presente instrumento, em 02 (duas) vias de igual teor e forma, na presença das 
            testemunhas abaixo, para que produza seus jurídicos e legais efeitos.

        </div>




            <div class="data">Rio Negrinho, <span id="dataRodape"></span></div>
        
        <div class="assinaturas">
            
            <div class="assinatura">
                <div class="linha"></div>
                <p><?php echo $razao_social?></p>
            </div>

            <div class="assinatura">
                <div class="linha"></div>
                <p>FREZEN MÁQUINAS E EQUIPAMENTOS LTDA</p>
            </div>
        </div>
Testemunhas:
        <div class="assinaturas">

            <div class="assinatura">
                <div class="linha"></div>
                <p><?php echo $razao_social?></p>
            </div>


            <div class="assinatura">
                <div class="linha"></div>
                <p>FREZEN MÁQUINAS E EQUIPAMENTOS LTDA</p>
            </div>

            
        </div>



  </div>
  <div class="page">
                <img class="logo" src="../../assets/img/Logo_Frezen.png">
                
                <?php foreach ($maquinas as $m) {?>
                    Objeto: <?php echo $m['serie']?>
                        <img class="imagem" src="<?php echo $m['path_image']?>" alt="" style="display:block; margin:auto; max-width: 400px; max-height: 400px; object-fit: contain;">
                    <?php }?>
                


  </div>
  
<script>
  const hoje = new Date();
  const opcoes = { day: '2-digit', month: 'long', year: 'numeric' };
  document.getElementById("dataRodape").textContent =
      hoje.toLocaleDateString('pt-BR', opcoes);



/* ===============================
   GERAR CONTRATO (PUPPETEER)
================================ */
function gerarComPuppeteer(idProposta) {

    const data = {
    id_proposta: idProposta
  };

    const params = new URLSearchParams(data)
    
    params.append('id_cliente', "<?php echo addslashes($id_cliente); ?>");

  

  fetch("../../controller/contrato/gerar_pdf_puppeteer.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: params
  })
  .then(r => r.text())
  .then(resp => {
    if (resp.startsWith("http")) {
      alert("Contrato gerado com sucesso!");
      window.location.href = "./boardContrato.php";
    } else {
      alert("Erro ao gerar contrato:\n" + resp);
    }
  })
  .catch(() => alert("Erro ao chamar o servidor."));
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

