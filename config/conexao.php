<?php

function novaConexao($banco = 'concessionaria') {
    $host = 'localhost';
    $usuario = 'root';
    $senha = '';

    try {
        return $conexao = new mysqli($host, $usuario, $senha, $banco);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}