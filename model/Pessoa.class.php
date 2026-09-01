<?php

class Pessoa{

    //atributos
    var $nome;
    var $peso;
    var $altura;

    //métodos
    function mostrar()
    {
        echo "<br>Seu nome:".$this->nome;
        echo "<br>Seu peso:".$this->peso;
        echo "<br>Seu altura:".$this->altura;
    }

    function preencher($nome,$peso,$altura)
    {
        $this->nome = $nome;
        $this->peso = $peso;
        $this->altura = $altura;
    }

}

?>