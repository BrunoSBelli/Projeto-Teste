<?php 
include_once("../../controller/login/autentique.php");
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="shortcut icon" href="../../assets/img/icone.png" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />

    <!-- Fontawesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- GoogleFonts - OpenSans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

      <!-- DataTables + Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../../assets/css/master.css" />

    <!-- JQuery e Bootstrap 4 JS -->
    <script src="../../assets/js/jquery-3.5.1.js"></script>   
    <script src="../../assets/js/bootstrap.min.js"></script> 

    <!-- DataTables + Bootstrap 4 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
  

    <title>FREZEN</title>
  </head>
  <body class="bg-Vaga">

    <div class="container"> <!-- Esse container fecha na página footer.php>
 Navbar -->

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-vaga-nav">
      
      <img class = "logo" src = "../../assets/img/icone.png" >
      <a class="navbar-brand" href="#" style="margin-left: 20px">FREZEN</a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse"
       data-target="#menu" aria-controls="menu" aria-expanded="false"
        aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">

      <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle"
              href="#" id="dropdown"
              data-toggle="dropdown">Funcionários</a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" 
                  href="../../view/funcionario/page_registerfunc.php">Cadastro de Funcionários</a>
                  <a class="dropdown-item" 
                  href="../funcionario/boardFunc.php">Exibir Funcionários</a>
              </div>
          </li>

          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle"
              href="#" id="dropdown"
              data-toggle="dropdown">Clientes</a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" 
                  href="../../view/cliente/page_registerCliente.php">Cadastro de Clientes</a>
                  <a class="dropdown-item" 
                  href="../cliente/boardCliente.php">Exibir Clientes</a>
              </div>
          </li>

          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle"
              href="#" id="dropdown"
              data-toggle="dropdown">Máquinas</a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" 
                  href="../../view/maquina/page_registermaquina.php">Cadastro de Máquinas</a>
                  <a class="dropdown-item" 
                  href="../maquina/boardMaquina.php">Exibir Máquinas</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle"
              href="#" id="dropdown"
              data-toggle="dropdown">Negócios</a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" 
                  href="../proposta/boardProposta.php">Exibir Propostas</a>
                  <a class="dropdown-item" 
                  href="../contrato/boardContrato.php">Exibir Contratos</a>
              </div>
          </li>
                    
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
          <a class="nav-link" href="../../controller/login/logout.php" >Logout</a>
          </li> 
        </ul>     
      </div>
    </nav>
    <div class="jumbotron">
        <h1 class="d-flex justify-content-center">Contratos</h1>
      </div>


