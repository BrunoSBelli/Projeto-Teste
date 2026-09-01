<?php
    include_once 'headerProposta.php';
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Entity.class.php';
    $Entity = new Entity();

      $id = $_POST['ids'] ?? null;
      //echo "ID selecionado: " . print_r($id);
      $clientes = $Entity->list("cliente");
?>

<!--Manter esse já habilitado!-->

<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">

      <div class="card shadow-sm table-responsive transicao-suave mostrar" id="tabelaClientes">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-file-alt"></i> Clientes
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

                        <!-- SELECIONAR -->
                         <form action="./page_gerarProposta.php" method="POST" class="espaco">
                              <input type="hidden" name="id_cliente" value="<?=$cliente['id']?>" />
                                  <?php if ($id): ?>
                                  <?php foreach ($id as $valor): ?>
                                        <input type="hidden" name="ids[]" value="<?= $valor ?>">
                                  <?php endforeach; ?>
                                  <?php endif; ?>
                              <button type="submit"
                                  class="btn btn-outline-dark btn-sm"
                                  title="Selecionar" onclick="voltarPagina()">
                            <i class="fas fa-arrow-alt-circle-right"></i>
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


  <br>
  <p>Não localizou o cliente? <a href="../../view/cliente/page_registerCliente.php">Cadastrar Cliente</a></p>

<!--Habilitar o que está abaixo somente se clicando no check box 
  <div class="form-check form-switch mt-3">
  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">
    Preencher manualmente os dados da Locatária
  </label>
  </div>
  -->

<div class="container transicao-suave" id="formManual">
<h2 class="d-flex justify-content-start">Insira os dados da Locatária</h2>
<br>
    <form action="./page_gerarProposta.php" method="POST" enctype="multipart/form-data">

    <?php if ($id): ?>
    <?php foreach ($id as $valor): ?>
        <input type="hidden" name="ids[]" value="<?= $valor ?>">
    <?php endforeach; ?>
    <?php endif; ?> <!-- Passando o mesmo ID vindo da pagina inicial-->

       <div class="form">
            <div class="form-group row">
               <div class="col-md-6">
                    <label>Razão Social</label>
                    <input type="text" class="form-control"
                    name="razaosocial" placeholder="Digite sua Razão Social"
                    required autofocus />
               </div>

               <div class="col-md-6">
                    <label>CNPJ / CPF</label>
                    <input type="text" class="form-control"
                         name="cnpj"
                         placeholder="xxx.xxx.xxx-xx ou xx.xxx.xxx/xxxx-xx"
                         pattern="^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2})$"
                         required />
               </div>
                 
            </div>

            <div class="form-group row">
               <div class="col-md-4">
                    <label>CEP</label>
                   <input type="text" class="form-control"
                         name="cep" id="cep" placeholder="xxxxx-xxx"
                         pattern="\d{5}-\d{3}"
                         required />
               </div>

               <div class="col-md-8">
                    <label>Endereço</label>
                   <input type="text" class="form-control"
                    name="endereco" id="endereco" placeholder="Digite seu endereço"
                    required />
               </div>
                 
            </div>

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Cidade</label>
                   <input type="text" class="form-control"
                    name="cidade" id="cidade" placeholder="Digite sua cidade"
                    required />
               </div>

               <div class="col-md-6">
                    <label>Estado</label>
                   <input type="text" class="form-control"
                    name="estado" id="estado" placeholder="Digite o estado"
                    required />
               </div>
                 
            </div>


            <div class="form-group row">
               <div class="col-md-6">
                    <label>Contato Comercial</label>
                   <input type="tel" class="form-control"
                    name="contato_comercial" placeholder="(xx)xxxxx-xxxx"
                    pattern="^\(\d{2}\)\d{4,5}-\d{4}$" 
                    required />
               </div>

               <div class="col-md-6">
                    <label>E-mail</label>
                  <input type="text" class="form-control"
                    name="email" placeholder="seuemail@exemplo.com.br"
                    required />
               </div>
                 
            </div>
            
            <div class="form-group d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success" onclick="voltarPagina()">
                    Inserir
                </button>

                <a href="../menu/menu.php" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>


        </div>
    </form>
</div>
<script src="../../assets/js/listagem.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const switchManual = document.getElementById("flexSwitchCheckDefault");
  const formManual = document.getElementById("formManual");
  const tabelaClientes = document.getElementById("tabelaClientes");

  switchManual.addEventListener("change", function() {
    if (this.checked) {
      // Esconde a tabela suavemente
      tabelaClientes.classList.remove("mostrar");
      // Mostra o formulário com transição suave
      setTimeout(() => formManual.classList.add("mostrar"), 200);
    } else {
      // Esconde o formulário
      formManual.classList.remove("mostrar");
      // Mostra a tabela
      setTimeout(() => tabelaClientes.classList.add("mostrar"), 200);
    }
  });
});


document.addEventListener('DOMContentLoaded', function () {

  const cepInput = document.getElementById('cep');

  cepInput.addEventListener('blur', function () {
    let cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) {
      return;
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then(response => response.json())
      .then(data => {
        if (data.erro) {
          alert('CEP não encontrado.');
          return;
        }

        document.getElementById('endereco').value =
          data.logradouro || '';

        document.getElementById('cidade').value =
          data.localidade || '';

        document.getElementById('estado').value =
          data.uf || '';
      })
      .catch(() => {
        alert('Erro ao buscar o CEP.');
      });
  });

});

function voltarPagina(){
setTimeout(function() {
        window.location.href = "../menu/menu.php";
    }, 500)
   
}


</script>
