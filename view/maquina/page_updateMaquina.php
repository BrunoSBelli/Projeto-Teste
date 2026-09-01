<?php
    include_once 'header.php';
    include_once '../../model/Conexao.class.php';
    include_once '../../model/Entity.class.php';    

    $locacaoEntity = new Entity();
    $id = $_POST["id"];

?>
<div class="container">
<h2 class="d-flex justify-content-start">Alterar Máquina</h2>
<br>
    <form action="../../controller/maquina/update_maquina.php" method="POST" enctype="multipart/form-data">
        <div class="form">
            
        <?php foreach($locacaoEntity->getInfo("maquina",$id) as $locacao) {  ?>
            <input type="hidden" name="id" value="<?=$locacao['id'] ?>" />
            <input type="hidden" name="current_image_path" value="<?=$locacao['path_image'] ?>" />

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Tipo</label>
                        <input type="text" class="form-control"
                        name="tipo" placeholder="Digite o tipo" value="<?=$locacao['tipo'] ?>"
                        required autofocus />


                </div>

                <div class="col-md-6">
                    <label>Modelo</label>
                        <input type="text" class="form-control"
                        name="modelo" placeholder="Digite o modelo" value="<?=$locacao['modelo'] ?>"
                        required />


                </div>
                
            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Serie</label>
                        <input type="text" class="form-control"
                        name="serie" placeholder="Digite a série do equipamento" value="<?=$locacao['serie'] ?>"
                        required />

                </div>

                <div class="col-md-4">
                    <label>Ano</label>
                        <input type="text" class="form-control"
                        name="ano" placeholder="Digite o ano do equipamento" value="<?=$locacao['ano'] ?>"
                        required />
                </div>
                <div class="col-md-4">
                    <label>Horímetro</label>
                        <input type="text" class="form-control"
                        name="horimetro" placeholder="Digite o horímetro do equipamento" value="<?=$locacao['horimetro'] ?>"
                        required />
                </div>
                 
                 
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Marca</label>
                        <input type="text" class="form-control"
                        name="marca" placeholder="Digite a marca do equipamento" value="<?=$locacao['marca'] ?>"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Capacidade nominal</label>
                        <input type="text" class="form-control"
                        name="capacidade_nominal" placeholder="Ex: 0000,00KG" value="<?=$locacao['capacidade_nominal'] ?>"
                        pattern="^\d+([.,]\d{2})?(KG|T)$"
                        required />

                </div>
                
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Torre</label>
                        <input type="text" class="form-control"
                        name="torre" placeholder="Digite o tipo da torre do equipamento" value="<?=$locacao['torre'] ?>"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Altura de elevação</label>
                        <input type="text" class="form-control"
                        name="altura_elevacao" placeholder="Ex: 0000,00mm" value="<?=$locacao['altura_elevacao'] ?>"
                        pattern="^\d+([.,]\d{2})?(mm|m)$"
                        required />
                </div>

            </div>

            <div class="form-group">
                <label class="d-block">Direção</label>
                
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Mecânica" <?php if($locacao['direcao']=="Mecânica"){echo "checked";} ?>>
                        <label class="form-check-label">Mecânica</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Hidráulica" <?php if($locacao['direcao']=="Hidráulica"){echo "checked";} ?>>
                        <label class="form-check-label">Hidráulica</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Elétrica" <?php if($locacao['direcao']=="Elétrica"){echo "checked";} ?>>
                        <label class="form-check-label">Elétrica</label>
                    </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Motor</label>
                        <input type="text" class="form-control"
                        name="motor" placeholder="Digite a marca do motor do equipamento" value="<?=$locacao['motor'] ?>"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Tipo de Combustível</label>
                        <input type="text" class="form-control"
                        name="tipo_combustivel" placeholder="Digite o tipo de combustível do equipamento" value="<?=$locacao['tipo_combustivel'] ?>"
                        required />
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Comprimento do garfo</label>
                        <input type="text" class="form-control"
                        name="comprimento_garfo" placeholder="Ex: 0000,00mm" value="<?=$locacao['comprimento_garfo'] ?>"
                        pattern="^\d+([.,]\d{2})?(mm|m)$"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Pneus</label>
                        <input type="text" class="form-control"
                        name="pneus" placeholder="Digite o tipo dos pneus do equipamento" value="<?=$locacao['pneus'] ?>"
                        required />
                </div>


            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-md-1">

                    <label class="d-block">Deslocador Lateral</label>
                        <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="deslocador_lateral" value="SIM" <?php if($locacao['deslocador_lateral']=="SIM"){echo "checked";} ?>>
                        <label class="form-check-label">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="deslocador_lateral" value="NAO" <?php if($locacao['deslocador_lateral']=="NAO"){echo "checked";} ?>>
                        <label class="form-check-label">Não</label>
                        </div>


                </div>
                 <div class="col-md-4">
                    <label class="d-block">Kit de Iluminação</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kit_iluminacao" value="SIM" <?php if($locacao['kit_iluminacao']=="SIM"){echo "checked";} ?>>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kit_iluminacao" value="NAO" <?php if($locacao['kit_iluminacao']=="NAO"){echo "checked";} ?>>
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="d-block">Protetor de Carga</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_carga" value="SIM" <?php if($locacao['protetor_carga']=="SIM"){echo "checked";} ?>>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_carga" value="NAO" <?php if($locacao['protetor_carga']=="NAO"){echo "checked";} ?>>
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-md-1">
                    <label class="d-block">Protetor de Corrente</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_corrente" value="SIM" <?php if($locacao['protetor_corrente']=="SIM"){echo "checked";} ?>>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_corrente" value="NAO" <?php if($locacao['protetor_corrente']=="NAO"){echo "checked";} ?>>
                    <label class="form-check-label">Não</label>
                    </div>
                </div>
                 <div class="col-md-4">
                    <label class="d-block">Alarme de ré</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="alarme_re" value="SIM" <?php if($locacao['alarme_re']=="SIM"){echo "checked";} ?>>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="alarme_re" value="NAO" <?php if($locacao['alarme_re']=="NAO"){echo "checked";} ?>>
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="d-block">Cabine</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cabine" value="SIM" <?php if($locacao['cabine']=="SIM"){echo "checked";} ?>>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cabine" value="NAO" <?php if($locacao['cabine']=="NAO"){echo "checked";} ?>>
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

            </div>


            <div class="form-group row">
                <div class="col-md-5">
                    <label>Posição do operador</label>
                        <input type="text" class="form-control"
                        name="posicao_operador" placeholder="Digite a posição do operador" value="<?=$locacao['posicao_operador'] ?>"
                        required />
                </div>

                 <div class="col-md-2">
                    <label>Valor do item</label>
                        <input type="text" class="form-control"
                        name="valor" placeholder="Ex: 0000,00"
                        pattern="^\d+([.,]\d{2})?$" value = "<?=$locacao['valor']?>"
                        required />


                </div>

                <div class="col-md-5">
                    <label>Status da máquina</label>
                    <select name="status" class="form-control">
                            <option value="disponível" <?php if($locacao['status']=="disponível") echo "selected" ?>>Disponível</option>
                            <option value="pendente_proposta" <?php if($locacao['status']=="pendente_proposta") echo "selected" ?>>Pendente Proposta</option>
                            <option value="em_uso" <?php if($locacao['status']=="em_uso") echo "selected" ?>>Em uso</option>
                            <option value="em_manutencao" <?php if($locacao['status']=="em_manutencao") echo "selected" ?>>Manutenção</option>
                            <option value="inativa" <?php if($locacao['status']=="inativa") echo "selected" ?>>Inativa</option>
                    </select> 


                </div>
                
            </div>

                        <!-- Seção de Imagem -->
            <div class="form-group ">
                <label>Alterar Imagem</label>
                <div class="col-md-6 mx-auto">
                    
                    <div class="picture-container">
                    <label class="picture" for="picture__input" tabIndex="0">
                        <span class="picture__image">
                            <?php if(!empty($locacao['path_image'])): ?>
                                <img src="<?=$locacao['path_image'] ?>" class="picture__img" alt="Imagem atual">
                            <?php else: ?>
                                Escolha uma imagem
                            <?php endif; ?>
                        </span>
                    </label>
                    <input type="file" name="picture__input" id="picture__input" accept="image/*">
                </div>

                
                </div>
                
                
                
            </div>
            <!-- Fim da Seção de Imagem -->

            <div class="form-group d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">
                    Alterar
                </button>

                <a href="../menu/menu.php" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

            

            <?php } ?>
        </div>
    </form>
</div>


<script>
const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Escolha uma imagem";

// Se não houver imagem, mostra o texto
if (!document.querySelector('.picture__img')) {
  pictureImage.innerHTML = pictureImageTxt;
}

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture__img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    // Se não selecionou arquivo, mantém a imagem atual ou o texto
    const currentImg = document.querySelector('.picture__img');
    if (!currentImg) {
      pictureImage.innerHTML = pictureImageTxt;
    }
  }
});
</script>