<?php
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';
include_once 'headerProposta.php';

$Entity = new Entity();
$propostas = $Entity->listPropostas();
?>

<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">

      <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-file-alt"></i> Propostas
          </h5>
          <span class="text-muted">
            Total: <strong><?= count($propostas); ?></strong>
          </span>
        </div>

        <div class="card-body">

          <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Nº</th>
                  <th>Funcionário</th>
                  <th class="d-none d-md-table-cell">Data</th>
                  <th>Status</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($propostas as $proposta): ?>
                <tr>
                  <td><?= $proposta['id']; ?></td>
                  <td><?= $proposta['usuario']; ?></td>

                  <td class="d-none d-md-table-cell">
                    <?= date('d/m/Y H:i', strtotime($proposta['data_criacao'])) ?>
                  </td>

                  <td>
                    <?php
                      $statusMap = [
                        'aberta' => 'secondary',
                        'enviada' => 'info',
                        'aceita' => 'success',
                        'rejeitada' => 'danger',
                        'convertida_em_contrato' => 'primary'
                      ];
                      $badge = $statusMap[$proposta['status']] ?? 'dark';
                    ?>
                    <span class="badge badge-<?= $badge ?>">
                      <?= ucfirst(str_replace('_', ' ', $proposta['status'])) ?>
                    </span>
                  </td>

                  <td class="text-center">
                    <div class="d-flex flex-column flex-md-row justify-content-center">

                      <a class="btn btn-outline-primary btn-sm mb-1 mb-md-0 mr-md-1"
                         href="<?= $proposta['path_pdf']; ?>"
                         target="_blank"
                         title="Abrir PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>

                      <button class="btn btn-outline-success btn-sm mb-1 mb-md-0 mr-md-1"
                              title="Compartilhar"
                              onclick="compartilharProposta('<?= 'http://localhost/Contrato/assets' . $proposta['path_pdf']; ?>')">
                        <i class="fas fa-share-alt"></i>
                      </button>

                      <?php if ($proposta['status'] === 'aberta'): ?>

                        <form action="../../view/contrato/page_gerarContrato.php" method="POST" class="espaco">
                              <input type="hidden" name="id_proposta" value="<?=$proposta['id']?>" />
                              <input type="hidden" name="id_cliente" value="<?=$proposta['id_cliente'] ?>" />

                              <button type="submit"
                                  class="btn btn-outline-dark btn-sm"
                                  title="Selecionar" onclick="voltarPagina()">
                            <i class="fas fa-arrow-alt-circle-right"></i>
                          </button>
                          </form>
            
                      <?php endif; ?>

                      <?php if ($proposta['status'] === 'aberta'): ?>

                        <form action="../../controller/proposta/cancel_proposta.php" method="POST" 
                        onsubmit="return confirm('Tem certeza que deseja cancelar esta proposta?')" class="espaco"> 
                              <input type="hidden" name="id_proposta" value="<?=$proposta['id']?>" />

                              <button type="submit"
                                  class="btn btn-outline-danger btn-sm"
                                  title="Selecionar" onclick="voltarPagina()">
                            <i class="fas fa-times"></i>
                          </button>
                          </form>
            
                      <?php endif; ?>

                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="mt-4">
        <a href="../menu/menu.php" class="btn btn-outline-danger">
          <i class="fas fa-arrow-left"></i> Voltar
        </a>
      </div>

    </div>
  </div>
</div>

<script src="../../assets/js/listagem.js"></script>
<script>
/* ===============================
   COMPARTILHAMENTO
================================ */
function compartilharProposta(link) {
  const titulo = "📄 Proposta de Locação";
  const texto = "Confira a proposta gerada pela Frezen:";

  if (navigator.share) {
    navigator.share({
      title: titulo,
      text: texto,
      url: link
    }).catch(() => {});
  } else {
    const mensagem = encodeURIComponent(`${texto}\n${link}`);
    window.open(`https://wa.me/?text=${mensagem}`, '_blank');
  }
}

</script>