<?php
include_once("../../controller/login/autentique.php");
include_once("../menu/headerMenu.php");
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

$entity = new Entity();
$maquinas = $entity->listMaquinas();

?>


<script>
$(document).ready(function () {
  $('#checkBtn').click(function() {
      let checked = $("input[type=checkbox]:checked").length;
      if(!checked) {
          alert("Precisa selecionar pelo menos um item!");
          return false;
      }
  });
});

$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function () {

  function filtrar(status, label) {
    $(".maquina-card").hide();
    $('.maquina-card[data-status="' + status + '"]').fadeIn(200);
    $("#btnFiltro").html('<i class="fas fa-filter"></i> ' + label);
  }

  // 🔹 filtro padrão
  if ($('.maquina-card[data-status="em_uso"]').length > 0) {
    filtrar("em_uso", "Em uso em Contrato");
  } else if($('.maquina-card[data-status="pendente_proposta"]').length > 0){
    filtrar("pendente_proposta", "Pendente em Proposta");
  } else{
    filtrar("disponível", "Disponível");
  }

  // 🔹 clique no dropdown
  $(".filter-status").click(function (e) {
    e.preventDefault();
    filtrar($(this).data("filter"), $(this).text().trim());
  });

});
</script>

<div class="row">
  <div class="col">


    <div class="d-flex justify-content-between align-items-center mb-4">

  <div class="dropdown">
    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" id="btnFiltro">
      <i class="fas fa-filter"></i> 
    </button>

    <div class="dropdown-menu p-2" style="min-width: 260px;">
      <input class="form-control mb-2" id="myInput" type="text" placeholder="🔍 Buscar status">

      <a class="dropdown-item filter-status" href="#" data-filter="disponível">
        <span class="badge badge-success mr-2">●</span> Disponível
      </a>

      <a class="dropdown-item filter-status" href="#" data-filter="pendente_proposta">
        <span class="badge badge-warning mr-2">●</span> Pendente em Proposta
      </a>

      <a class="dropdown-item filter-status" href="#" data-filter="em_uso">
        <span class="badge badge-primary mr-2">●</span> Em uso em Contrato
      </a>  

      <a class="dropdown-item filter-status" href="#" data-filter="em_manutencao">
        <span class="badge badge-secondary mr-2">●</span> Em Manutenção
      </a>

      <a class="dropdown-item filter-status" href="#" data-filter="inativa">
        <span class="badge badge-danger mr-2">●</span> Inativo
      </a>
    </div>
  </div>

</div>

  </div>

</div>



<form action="../../view/proposta/page_registerProposta.php" method="POST">
  <div class="container mt-5">
    <div class="row">

<?php foreach($maquinas as $m): ?>

    <?php
    // Define estilo e label
    if (!empty($m['contrato_id'])) {
      $status = 'em_uso';
    } elseif (!empty($m['proposta_id'])) {
          $status = 'pendente_proposta';
    } else {
          $status = $m['status']; // disponível / manutenção / inativa
    }
    
    $statusInfo = [
          "disponível" => [
              "text"  => "Disponível para locação",
              "class" => "success",
              "icon"  => "fa-check-circle"
          ],
          "pendente_proposta" => [
              "text"  => "Em proposta nº {$m['proposta_id']}",
              "class" => "warning",
              "icon"  => "fa-hourglass-half"
          ],
          "em_uso" => [
              "text"  => "Contrato ativo nº {$m['contrato_id']}",
              "class" => "primary",
              "icon"  => "fa-file-contract"
          ],
          "em_manutencao" => [
              "text"  => "Em manutenção",
              "class" => "secondary",
              "icon"  => "fa-tools"
          ],
          "inativa" => [
              "text"  => "Inativa",
              "class" => "danger",
              "icon"  => "fa-ban"
          ]
];
    $info = $statusInfo[$status] ?? ["text" => "Desconhecido", "class" => "light", "icon" => "fa-question-circle"];

    $contrato = null;
    $diasRestantes = null;

    if (!empty($m['contrato_id']) && !empty($m['data_fim'])) {
        $hoje = new DateTime();
        $dataFim = new DateTime($m['data_fim']);
        $diff = $hoje->diff($dataFim);
        $diasRestantes = ($dataFim < $hoje) ? -$diff->days : $diff->days;
    }
    ?>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 maquina-card" data-status="<?= $status ?>">
      <div class="card border-<?= $info['class'] ?> shadow-sm">

        <div class="card-header bg-<?= $info['class'] ?> text-white d-flex justify-content-between">
          <span><i class="fas <?= $info['icon'] ?>"></i> <?= strtoupper($m['tipo']); ?></span>
          <span class="badge bg-light text-<?= $info['class'] ?>"><?= ucfirst($status) ?></span>
        </div>

        <div class="card-body">
          <h5 class="card-title"><?= $m['serie']; ?></h5>

          <p class="card-text mb-2">
            <strong>Status:</strong> <?= $info['text']; ?><br>

            <?php if (!empty($m['contrato_id'])): ?>
              <small class="text-muted">
                Vigência até <?= date("d/m/Y", strtotime($m['data_fim'])); ?>

                <?php if ($diasRestantes > 0): ?>
                    (restam <b><?= $diasRestantes ?></b> dias)
                <?php elseif ($diasRestantes == 0): ?>
                    (<b>vence hoje!</b>)
                <?php else: ?>
                    (<b class="text-danger">vencido há <?= abs($diasRestantes) ?> dias</b>)
                <?php endif; ?>
              </small>
            <?php endif; ?>
          </p>

          <?php if ($diasRestantes !== null && $diasRestantes <= 10 && $diasRestantes >= 0): ?>
            <div class="alert alert-warning py-2 mb-2">
              ⚠️ Atenção! Este contrato está próximo do vencimento.
            </div>
          <?php endif; ?>
        </div>

        <div class="card-footer text-center">
          <?php if ($status == "disponível"): ?>
            <label>
              <input type="checkbox" name="ids[]" value="<?= $m['id'] ?>"> Selecionar
            </label>
          <?php else: ?>
            <small class="text-muted">Indisponível para seleção</small>
          <?php endif; ?>
        </div>

      </div>
    </div>

<?php endforeach; ?>

    </div>
  </div>

  <div class="text-center mt-4">
    <button type="submit" class="btn btn-success" id="checkBtn">Continuar</button>
  </div>
</form>

