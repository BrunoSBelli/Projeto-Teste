<?php
    include_once 'header.php';    
?>
<div class="container">
<h2 class="d-flex justify-content-start">Cadastro de Funcionário</h2>
<br>
    <form action="../../controller/funcionarios/insert_func.php" method="POST">
        <div class="form">

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Nome</label>
                     <input type="text" class="form-control"
                    name="nome" placeholder="Digite seu nome"
                    required autofocus />
               </div>

               <div class="col-md-6">
                    <label>CPF</label>
                    <input type="text" class="form-control"
                    name="CPF" placeholder="xxx.xxx.xxx-xx"
                    pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                    required />
               </div>
                 
            </div>

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Telefone</label>
                     <input type="tel" class="form-control"
                        name="telefone"
                        placeholder="(xx)xxxxx-xxxx"
                        pattern="^\(\d{2}\)\d{4,5}-\d{4}$"
                        required />
               </div>

               <div class="col-md-6">
                    <label>Cargo</label>
                    <input type="text" class="form-control"
                    name="cargo" placeholder="Digite seu cargo"
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
