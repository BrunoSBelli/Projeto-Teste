<?php
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';
include_once 'headerContrato.php';

$Entity = new Entity();
$contratos = $Entity->list("contrato");
?>

<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">

      <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-file-alt"></i> Contratos
          </h5>
          <span class="text-muted">
            Total: <strong><?= count($contratos); ?></strong>
          </span>
        </div>  

          <div class="card-body">

          <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Nº Constrato</th>
                  <th>Nº Proposta</th>
                  <th class="d-none d-md-table-cell">Criação</th>
                  <th>Vencimento</th>
                  <th>Status</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($contratos as $contrato): ?>
                <tr>
                  <td><?= $contrato['id']; ?></td>
                  <td><?= $contrato['id_proposta']; ?></td>

                  <td class="d-none d-md-table-cell">
                    <?= date('d/m/Y H:i', strtotime($contrato['data_criacao'])) ?>
                  </td>
                  <td><?= date('d/m/Y', strtotime($contrato['data_fim'])); ?></td>

                  <td>
                    <?php
                      $statusMap = [
                        'ativo' => 'success',
                        'expirado' => 'primary',
                        'encerrado' => 'dark',
                        'cancelado' => 'danger'
                      ];
                      $badge = $statusMap[$contrato['status']] ?? 'dark';
                    ?>
                    <span class="badge badge-<?= $badge ?>">
                      <?= ucfirst(str_replace('_', ' ', $contrato['status'])) ?>
                    </span>
                  </td>

                  <td class="text-center">
                    <div class="d-flex flex-column flex-md-row justify-content-center">

                      <a class="btn btn-outline-primary btn-sm mb-1 mb-md-0 mr-md-1"
                         href="<?= $contrato['path_pdf'] ?>"
                         target="_blank"
                         title="Abrir PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>

                      <button class="btn btn-outline-success btn-sm mb-1 mb-md-0 mr-md-1"
                              title="Compartilhar"
                              onclick="compartilharContrato('<?= 'http://localhost/Contrato/assets' . $contrato['path_pdf']; ?>')">
                        <i class="fas fa-share-alt"></i>
                      </button>

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

<!-- SCRIPTS NO FINAL -->
<script src="../../assets/js/listagem.js"></script>
<script>
/* ===============================
   COMPARTILHAMENTO
================================ */

function compartilharContrato(link) {
  const titulo = "📄 Contrato de Locação";
  const texto = "Confira o contrato gerado pela Frezen:";

  if (navigator.share) {
    // ✅ Usa o compartilhamento nativo do dispositivo (Android, iOS, Edge, etc.)
    navigator.share({
      title: titulo,
      text: texto,
      url: link
    })
    .then(() => console.log('Compartilhamento enviado com sucesso!'))
    .catch((err) => console.warn('Erro ao compartilhar:', err));
  } else {
    // 💬 Caso o navegador não suporte Web Share API
    const mensagem = encodeURIComponent(`${texto}\n${link}`);
    const urlWhatsApp = `https://wa.me/?text=${mensagem}`;
    
    // Abre o WhatsApp Web como fallback
    window.open(urlWhatsApp, '_blank');
  }
}

</script>