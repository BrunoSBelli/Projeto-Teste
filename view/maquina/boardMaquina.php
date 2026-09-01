<?php
  include_once '../../model/Conexao.class.php';
  include_once '../../model/Entity.class.php';
  include_once 'header.php';

  $locacaoEntity = new Entity();
  $maquinas = $locacaoEntity->list("maquina");
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
            Total: <strong><?= count($maquinas); ?></strong>
          </span>
        </div>  

          <div class="card-body">

          <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Tipo</th>
                  <th>Modelo</th>
                  <th>Série</th>
                  <th>Status</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($maquinas as $maquina): ?>
                <tr>
                  <td><?= $maquina['tipo']; ?></td>
                  <td><?= $maquina['modelo']; ?></td>
                  <td><?= $maquina['serie']; ?></td>

                  <td>
                    <?php
                      $statusMap = [
                        'disponível' => 'success',
                        'pendente_proposta' => 'warning',
                        'em_uso' => 'primary',
                        'manutencao' => 'danger',
                        'inativa' => 'secondary'
                      ];
                      $badge = $statusMap[$maquina['status']] ?? 'dark';
                    ?>
                    <span class="badge badge-<?= $badge ?>">
                      <?= ucfirst(str_replace('_', ' ', $maquina['status'])) ?>
                    </span>
                  </td>

                  <td class="text-center">
                      <div class="d-flex flex-column flex-md-row justify-content-center">

                        <!-- ALTERAR -->
                        <form action="./page_updateMaquina.php"
                              method="POST"
                              class="mb-1 mb-md-0 mr-md-1">
                          <input type="hidden" name="id" value="<?= $maquina['id'] ?>" />
                          <button type="submit"
                                  class="btn btn-outline-primary btn-sm"
                                  title="Alterar">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <!-- REMOVER -->
                        <form action="../../controller/maquina/delete_maquina.php"
                              method="POST"
                              onsubmit="return confirm('Tem certeza que deseja remover esta máquina?')">
                          <input type="hidden" name="id" value="<?= $maquina['id'] ?>" />
                          <button type="submit"
                                  class="btn btn-outline-danger btn-sm"
                                  title="Remover">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>

                      </div>
                    </td>

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

<!-- Script da tabela no fim -->
<script src="../../assets/js/listagem.js"></script>
</body>
</html>
