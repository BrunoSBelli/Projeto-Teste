<?php
include_once 'header.php';
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

$vagaEntity = new Entity();
$id = $_POST["id"];
?>
<div class="container">
    <h2 class="d-flex justify-content-start">Alterar Vaga</h2>
    <br>
    <form action="../../controller/vaga/update_vaga.php" method="POST">
       <div class="form">

       <?php foreach($vagaEntity->getInfo("vaga",$id) as $vaga) {  ?>
            <input type="hidden" name="id" value="<?=$vaga['id']?>" />
            <div class="form-group">
                Título:
                <input type="text" class="form-control" 
                value="<?=$vaga['titulo']?>"
                name="titulo" placeholder="título" required autofocus />
            </div>
            <div class="form-group">
                Descrição:
                <input type="text" class="form-control" 
                value="<?=$vaga['descricao']?>"
                name="descricao" placeholder="Descrição" required />
            </div>
            <div class="form-group">
                Data:
                <input type="date" class="form-control"
                value="<?php 
                    $data = date_create($vaga['data']);
                    echo date_format($data,"Y-m-d");
                ?>"                
                name="data" placeholder="Data" style="width:40%" required />
            </div>
            <div class="form-group">
                Ativo:
                <div class="radio-item">
                    <input type="radio" id="ativoA" name="ativo" value="s" 
                    <?php if($vaga['ativo']=='s'){ echo 'checked';} ?>
                    />
                    <label for="ativoA">Sim</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="ativoB" name="ativo" value="n"
                    <?php if($vaga['ativo']=='n'){ echo 'checked';} ?>
                    />
                    <label for="ativoB">Não</label>
                </div>
                <br>
            </div>
            <div class="form-group">
                <button class="btn btn-outline-danger btn-lg">
                    Alterar</button>
                <a href="./boardAdm.php" class="btn btn-outline-danger btn-lg">
                    Voltar</a>
            </div>
         <?php } ?>
        </div>        
    </form>
</div>