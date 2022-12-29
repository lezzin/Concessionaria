<?php

require_once '../config/conexao.php';
$conexao = novaConexao();

if ($_POST) {

    // inserção da imagem na pasta 'imagens' com um novo nome único
    $imagem = $_FILES['image'];
    $caminhoTemporarioDaImagem = $imagem['tmp_name'];

    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $extensaoDaImagem = pathinfo($imagem['name'], PATHINFO_EXTENSION);
    $extensaoInvalida = !in_array($extensaoDaImagem, $extensoesPermitidas);
    
    if ($extensaoInvalida) {
        $conexao->close();
        return header('Location: ../index.php?page=admin&error=image_format');
    } 
    
    $nomeUnicoDaImagem = uniqid();
    $arquivoDaImagem = "$nomeUnicoDaImagem.$extensaoDaImagem";
    $caminhoCompletoDaImagem = '../imagens/carros/' . $arquivoDaImagem;

    $movimentoDaImagemParaPasta = move_uploaded_file($caminhoTemporarioDaImagem, $caminhoCompletoDaImagem);

    if(!$movimentoDaImagemParaPasta) {
        $conexao->close();
        return header('Location: ../index.php?page=admin&error=image');
    }


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
        $arquivoDaImagem,
        ucfirst($dados['details'])
    ];    
    
    // inserção dos dados no banco de dados
    $sql = 'INSERT INTO carros(nome, marca, modelo, ano, cor, preco, imagem, detalhes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssisdss", ...$parametros);

    $resultado = $stmt->execute();
    $conexao->close();
    
    if (!$resultado) 
        return header('Location: ../index.php?page=admin&error=insert_data');
    
    header('Location: ../index.php?page=admin&success=insert_data');
}