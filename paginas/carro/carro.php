<?php

function converterParaDinheiro($numero) {
    return 'R$ ' . number_format($numero, 2, ',', '.');
}

if (isset($_GET['id'])){

    $sql = "SELECT * FROM carros WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $resultadoNaoVazio = false;
    $registros = [];

    if ($resultado->num_rows > 0) {
        $resultadoNaoVazio = true;

        while ($linha = $resultado->fetch_assoc()) {
            $registros[] = $linha;
        }
    }

}
?>

<section id="individual_product">
    <h2 class="title">
        <img src="imagens/site/sally.png" alt="Short Sally Icon" width="64" height="32">
        Visualização individual do veículo
    </h2>

    <?php 
        if ($resultadoNaoVazio) :
            foreach($registros as $registro): ?>

    <div class="imageViewer" id="imageViewer">
        <img src="./imagens/carros/<?= $registro['imagem'] ?>" alt="car" width="580" height="326.25">
    </div>

    <div class="card">
        <div class="main_container">

            <div class="left">
                <div class="image">
                    <img src="./imagens/carros/<?= $registro['imagem'] ?>" alt="car" id="imageToView">
                </div>
            </div>

            <div class="right">

                <h3 class="title">
                    <?= $registro['nome'] ?>
                </h3>

                <div class="description">
                    <p><span class="bold">Marca: </span><?= $registro['marca'] ?></p>
                    <p><span class="bold">Ano: </span><?= $registro['ano'] ?></p>
                    <p><span class="bold">Detalhes: </span><?= $registro['detalhes'] ?></p>
                    <p><span class="bold">Cor: </span><?= $registro['cor'] ?><br></p>
                    <p><span class="bold">Modelo: </span><?= $registro['modelo'] ?> <br></p>
                    <p><span class="bold">Preço: </span><?= converterParaDinheiro($registro['preco']) ?></p>
                </div>

            </div>

        </div>

        <footer class="card_footer">
            <button class="btn btn-secondary">
                <a href="?page=carros">Voltar</a>
            </button>
        </footer>

    </div>

    <?php endforeach; 

        else: ?>

    <div class="card empty">
        <div class="card_body">
            <div class="image">
                <img src="./imagens/site/sad_mcqueen.gif" alt="Sad McQueen" width="256">
            </div>

            <div class="title">
                <h2>
                    <i class="fas fa-exclamation-triangle"></i>
                    Produto não encontrado
                </h2>
            </div>
        </div>
    </div>

    <?php endif; 
    ?>

</section>