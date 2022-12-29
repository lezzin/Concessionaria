<?php

require_once '../config/conexao.php';
$conexao = novaConexao();

if ($_POST) {

    $dados = $_POST;

    $preco = $dados['price'];
    $preco = str_replace('.', '', $preco);
    $preco = str_replace(',', '.', $preco);

    $parametros = [
        ucfirst($dados['name']),
        ucfirst($dados['brand']),
        ucfirst($dados['model']),
        $dados['year'],
        ucfirst($dados['color']),
        $preco,
        ucfirst($dados['details']),
        $dados['id']
    ];

    $sql = "UPDATE carros SET nome = ?, marca = ?, modelo = ?, ano = ?, cor = ?, preco = ?, detalhes = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sssssssi', ...$parametros);
    $resultado = $stmt->execute();

    if (!$resultado) {
        header('location: ../index.php?page=admin&error=edit');
        return;
    }

    header('location: ../index.php?page=admin&success=edit');
}
