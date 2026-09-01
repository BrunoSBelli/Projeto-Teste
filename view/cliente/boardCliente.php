<?php
  include_once '../../model/Conexao.class.php';
  include_once '../../model/Entity.class.php';
  include_once 'headerCliente.php';

  $Entity = new Entity();
  $clientes = $Entity->list("cliente");
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
            Total: <strong><?= count($clientes); ?></strong>
          </span>
        </div>  

          <div class="card-body">

          <div class="table-responsive">
            <table id="example" class="table table-hover table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Razão Social</th>
                  <th>CNPJ / CPF</th>
                  <th>Contato Comercial</th>
                  <th>E-mail</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($clientes as $cliente): ?>
                <tr>
                  <td><?= $cliente['razaosocial']; ?></td>
                  <td><?= $cliente['cnpj']; ?></td>
                  <td><?= $cliente['contato_comercial']; ?></td>
                  <td><?= $cliente['email']; ?></td>

                  <td class="text-center">
                      <div class="d-flex flex-column flex-md-row justify-content-center">

                        <!-- ALTERAR -->
                        <form action="./page_updateCliente.php" method="POST"
                              class="mb-1 mb-md-0 mr-md-1">
                          <input type="hidden" name="id" value="<?= $cliente['id'] ?>" />
                          <button type="submit"
                                  class="btn btn-outline-primary btn-sm"
                                  title="Alterar">
                            <i class="fas fa-edit"></i>
                          </button>
                        </form>

                        <!-- REMOVER -->
                        <form action="../../controller/cliente/delete_cliente.php"
                              method="POST"
                              onsubmit="return confirm('Tem certeza que deseja remover este cliente?')">
                          <input type="hidden" name="id" value="<?= $cliente['id'] ?>" />
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