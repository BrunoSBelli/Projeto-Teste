<?php
  include_once 'headerCliente.php';

?>
<div class="container">
<h2 class="d-flex justify-content-start">Cadastro de Cliente</h2>
<br>
    <form action="../../controller/cliente/insert_cliente.php" method="POST">
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

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Represetante / Sócio</label>
                   <input type="tel" class="form-control"
                    name="socio" placeholder="Digite seu nome"
                    required />
               </div>

               <div class="col-md-6">
                    <label>CPF</label>
                  <input type="text" class="form-control"
                   pattern="^(\d{3}\.\d{3}\.\d{3}-\d{2})$"
                    name="cpf" placeholder="xxx.xxx.xxx-xx"
                    required />
               </div>
                 
            </div>

            <div class="form-group row">

               <div class="col-md-12">
                    <label>Endereço de Obra</label>
                   <input type="text" class="form-control"
                    name="endereco_obra" placeholder="Digite seu endereço de obra completo"
                    required />
               </div>
                 
            </div>
            
            <div class="form-group d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">
                    Inserir
                </button>

                <a href="../menu/menu.php" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>


        </div>
    </form>
</div>

<script>
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
</script>

