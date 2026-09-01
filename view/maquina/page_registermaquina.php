<?php
    include_once 'header.php';    
?>
<div class="container">
<h2 class="d-flex justify-content-start">Cadastro de Máquina</h2>
<br>
    <form action="../../controller/maquina/insert_maquina.php" method="POST" enctype="multipart/form-data">
        <div class="form">
            
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Tipo</label>
                        <input type="text" class="form-control"
                        name="tipo" placeholder="Digite o tipo"
                        required autofocus />


                </div>

                <div class="col-md-6">
                    <label>Modelo</label>
                        <input type="text" class="form-control"
                        name="modelo" placeholder="Digite o modelo"
                        required />


                </div>
                
            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Serie</label>
                        <input type="text" class="form-control"
                        name="serie" placeholder="Digite a série do equipamento"
                        required />

                </div>

                <div class="col-md-4">
                    <label>Ano</label>
                        <input type="text" class="form-control"
                        name="ano" placeholder="Digite o ano do equipamento"
                        required />
                </div>
                <div class="col-md-4">
                    <label>Horímetro</label>
                        <input type="text" class="form-control"
                        name="horimetro" placeholder="Digite o horímetro do equipamento"
                        required />
                </div>
                 
                 
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label>Marca</label>
                        <input type="text" class="form-control"
                        name="marca" placeholder="Digite a marca do equipamento"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Capacidade nominal</label>
                        <input type="text" class="form-control"
                        name="capacidade_nominal" placeholder="Ex: 0000,00KG"
                        pattern="^\d+([.,]\d{2})?(KG|T)$"
                        required />

                </div>
                
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Torre</label>
                        <input type="text" class="form-control"
                        name="torre" placeholder="Digite o tipo da torre do equipamento"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Altura de elevação</label>
                        <input type="text" class="form-control"
                        name="altura_elevacao" placeholder="Ex: 0000,00mm"
                        pattern="^\d+([.,]\d{2})?(mm|m)$"
                        required />
                </div>

            </div>

            <div class="form-group">
                <label class="d-block">Direção</label>
                
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Mecânica" checked>
                        <label class="form-check-label">Mecânica</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Hidráulica">
                        <label class="form-check-label">Hidráulica</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direcao" value="Elétrica">
                        <label class="form-check-label">Elétrica</label>
                    </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Motor</label>
                        <input type="text" class="form-control"
                        name="motor" placeholder="Digite a marca do motor do equipamento"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Tipo de Combustível</label>
                        <input type="text" class="form-control"
                        name="tipo_combustivel" placeholder="Digite o tipo de combustível do equipamento"
                        required />
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Comprimento do garfo</label>
                        <input type="text" class="form-control"
                        name="comprimento_garfo" placeholder="Ex: 0000,00mm"
                        pattern="^\d+([.,]\d{2})?(mm|m)$"
                        required />
                </div>

                <div class="col-md-6">
                    <label>Pneus</label>
                        <input type="text" class="form-control"
                        name="pneus" placeholder="Digite o tipo dos pneus do equipamento"
                        required />
                </div>


            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-md-1">

                    <label class="d-block">Deslocador Lateral</label>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="deslocador_lateral" value="SIM" checked>
                        <label class="form-check-label">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="deslocador_lateral" value="NAO">
                        <label class="form-check-label">Não</label>
                        </div>


                </div>
                 <div class="col-md-4">
                    <label class="d-block">Kit de Iluminação</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kit_iluminacao" value="SIM" checked>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kit_iluminacao" value="NAO">
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="d-block">Protetor de Carga</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_carga" value="SIM" checked>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_carga" value="NAO">
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-md-1">
                    <label class="d-block">Protetor de Corrente</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_corrente" value="SIM" checked>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="protetor_corrente" value="NAO">
                    <label class="form-check-label">Não</label>
                    </div>
                </div>
                 <div class="col-md-4">
                    <label class="d-block">Alarme de ré</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="alarme_re" value="SIM" checked>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="alarme_re" value="NAO">
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="d-block">Cabine</label>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cabine" value="SIM" checked>
                    <label class="form-check-label">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cabine" value="NAO">
                    <label class="form-check-label">Não</label>
                    </div>
                </div>

            </div>


            <div class="form-group row">
                <div class="col-md-5">
                    <label>Posição do operador</label>
                        <input type="text" class="form-control"
                        name="posicao_operador" placeholder="Digite a posição do operador"
                        required />


                </div>

                <div class="col-md-2">
                    <label>Valor do item</label>
                        <input type="text" class="form-control"
                        name="valor" placeholder="Ex: 0000,00"
                        pattern="^\d+([.,]\d{2})?$"
                        required />


                </div>

                <div class="col-md-5">
                    <label>Foto</label>
                        <input type="file" class="form-control"
                        name="path_image" accept="" required />


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