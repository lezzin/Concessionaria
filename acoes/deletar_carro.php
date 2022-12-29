<?php

require_once '../config/conexao.php';
$conexao = novaConexao();

if ($_GET) {

    // deletando a imagem do carro da pasta 'images'
    $sql = "SELECT * FROM carros";
    $resultado = $conexao->query($sql);    
    $imagem = $resultado->fetch_assoc()['imagem'];
    unlink('../imagens/carros/' . $imagem);

    // deletando o registro do carro
    $sql = "DELETE FROM carros WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $resultado = $stmt->execute();

    $conexao -> close();
    
    if(!$resultado) {
        $conexao->close();
        return header('location: ../index.php?page=admin&error=delete');
    }

    header('Location: ../index.php?page=admin&success=delete');
}
