<?php
  include_once '../../model/Conexao.class.php';
  include_once '../../model/Entity.class.php';
  include_once 'header.php';

  $vagaEntity = new Entity();
?>
<div class="container mt-5">
 <div class="row">
    <?php foreach($vagaEntity->list("vaga") as $vaga) { ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-header 
                <?php if($vaga['ativo']=='s')
                        { echo 'cardBack1';}
                    else{ echo 'cardBack2';} ?>">
                   <h5 class="card-title">
                      <?php echo $vaga['titulo']; ?>
                   </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                      <?php echo $vaga['descricao']; ?>
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-end">
                
                <form action="../../controller/vaga/delete_vaga.php" method="POST" class="espaco">
                  <input type="hidden" name="id" value="<?=$vaga['id']?>" />
                  <button class="btn btn-outline-danger ">
                    Remover</button>
                </form>
                <form action="./page_update.php" method="POST" class="espaco">
                  <input type="hidden" name="id" value="<?=$vaga['id']?>" />
                  <button class="btn btn-outline-danger ">
                    Alterar</button>
                </form>

                </div>
            </div>
        </div>
    <?php } ?>
 </div>

 <br> 
  <!-- container -->
</div>