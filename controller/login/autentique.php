<?php
session_start(); // sempre precisa iniciar

if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
    echo"<script language='javascript' type='text/javascript'>
                         alert('Acesso não autorizado!');window.location
                         .href='../../index.php';</script>";
                         die();
    header("Location: ../../index.php");
    exit;
}
?>