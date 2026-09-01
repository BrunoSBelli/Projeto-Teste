<?php
include_once 'header.php';
include_once '../../model/Conexao.class.php';
include_once '../../model/Entity.class.php';

$funcEntity = new Entity();
$id = $_POST["id"];
?>
<div class="container">
    <h2 class="d-flex justify-content-start">Alterar Funcionário</h2>
    <br>
    <form action="../../controller/funcionarios/update_func.php" method="POST">
       <div class="form">

       <?php foreach($funcEntity->getInfo("funcionario",$id) as $funcionario) {  ?>
            <input type="hidden" name="id" value="<?=$funcionario['id'] ?>" />

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Nome</label>
                     <input type="text" class="form-control"
                    name="nome" placeholder="Digite seu nome" value="<?=$funcionario['nome']?>"
                    required autofocus />
               </div>

               <div class="col-md-6">
                    <label>CPF</label>
                    <input type="text" class="form-control"
                    name="CPF" placeholder="xxx.xxx.xxx-xx" value="<?=$funcionario['CPF']?>"
                    pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                    required />
               </div>
                 
            </div>

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Telefone</label>
                     <input type="tel" class="form-control"
                        name="telefone"
                        placeholder="(xx)xxxxx-xxxx" value="<?=$funcionario['telefone']?>"
                        pattern="^\(\d{2}\)\d{4,5}-\d{4}$"
                        required />
               </div>

               <div class="col-md-6">
                    <label>Cargo</label>
                    <input type="text" class="form-control"
                    name="cargo" placeholder="Digite seu cargo" value="<?=$funcionario['cargo']?>"
                    required />
               </div>
                 
            </div>

            <div class="form-group row">
               <div class="col-md-6">
                    <label>Login</label>
                     <input type="text" class="form-control" 
                        value="<?=$funcionario['login']?>"
                        name="login" placeholder="Login" 
                         required />
               </div>

               <div class="col-md-6">
                    <label>Senha</label>
                    <input type="password"
                    class="form-control"
                    name="senha"
                    placeholder="Deixe em branco para manter a senha atual">
               </div>
                 
            </div>

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
</body>
</html>