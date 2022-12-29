<?php

$conexao = novaConexao(null);

// criação do banco de dados
$sql = 'CREATE DATABASE IF NOT EXISTS Concessionaria';
$conexao->query($sql);

$conexao->close();
unset($conexao);

// criação da tabela de carros
$conexao = novaConexao();

$sql = 'CREATE TABLE IF NOT EXISTS carros (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    marca VARCHAR(255) NOT NULL,
    modelo VARCHAR(255) NOT NULL,
    ano INT(4) NOT NULL,
    cor VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    detalhes VARCHAR(255) NOT NULL,
    primary key (id)
);';

$resultado = $conexao->query($sql);

$conexao->close();
unset($conexao);
