<?php
  include_once '../../model/Conexao.class.php';
  include_once '../../model/Entity.class.php';
  include_once 'header.php';

  $funcEntity = new Entity();
  $funcionarios = $funcEntity->list("funcionario");
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
            Total: <strong><?= count($funcionarios); ?></strong>
          </span>
        </div>  

          <div class="card-body">

          <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Nome</th>
                  <th>CPF / CPF</th>
                  <th>Telefone</th>
                  <th>Cargo</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($funcionarios as $funcionario): ?>
                <tr>
                  <td><?= $funcionario['nome']; ?></td>
                  <td><?= $funcionario['CPF']; ?></td>
                  <td><?= $funcionario['telefone']; ?></td>
                  <td><?= $funcionario['cargo']; ?></td>

                  <td class="text-center">
                      <div class="d-flex flex-column flex-md-row justify-content-center">

                        <!-- ALTERAR -->
                        <form action="./page_updatefunc.php" method="POST"
                              class="mb-1 mb-md-0 mr-md-1">
                          <input type="hidden" name="id" value="<?= $funcionario['id'] ?>" />
                          <button type="submit"
                                  class="btn btn-outline-primary btn-sm"
                                  title="Alterar">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <!-- REMOVER -->
                        <form action="../../controller/funcionarios/delete_func.php"
                              method="POST"
                              onsubmit="return confirm('Tem certeza que deseja remover este funcionário?')">
                          <input type="hidden" name="id" value="<?= $funcionario['id'] ?>" />
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

<!-- SCRIPTS NO FINAL -->
<script src="../../assets/js/listagem.js"></script>
