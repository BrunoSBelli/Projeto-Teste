<?php
    include_once 'header.php';    
?>
<div class="container">
<h2 class="d-flex justify-content-start">Cadastro de Vagas</h2>
<br>
    <form action="../../controller/vaga/insert_vaga.php" method="POST">
        <div class="form">
            <div class="form-group">
                 Título:
                 <input type="text" class="form-control"
                 name="titulo" placeholder="título"
                 required autofocus />
            </div>
            <div class="form-group">
                 Descrição:
                 <input type="text" class="form-control"
                 name="descricao" placeholder="Descrição"
                 required />
            </div>
            <div class="form-group">
                 Data:
                 <input type="date" class="form-control"
                 name="data" placeholder="Data"
                 style="width:40%"
                 required />
            </div>
            <div class="form-group">
                Ativo:
                <div class="radio-item">
                    <input type="radio" id="ativoA"
                    name="ativo" value="s" checked />
                    <label for="ativoA">Sim</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="ativoB"
                    name="ativo" value="n" />
                    <label for="ativoB">Não</label>
                </div>
                <br>
            </div>
            <div class="form-group">
                <button class="btn btn-outline-danger btn-lg">
                    Inserir</button>
                <a href="../menu/menu.php" 
                    class="btn btn-outline-danger btn-lg">
                    Voltar</a>
            </div>
        </div>
    </form>
</div>