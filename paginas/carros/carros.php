<?php

$sql = "SELECT * FROM carros";
$resultado = $conexao->query($sql);

$resultadoNaoVazio = false;
$registros = [];

if ($resultado->num_rows > 0) {
    $resultadoNaoVazio = true;

    while ($linha = $resultado->fetch_assoc()) {
        $registros[] = $linha;
    }
}

function converterParaDinheiro($numero) {
    return '<span class="currency">R$</span> ' . number_format($numero, 2, ',', '.');
}

?>

<section id="s_catalog">
    <header class="section_header">
        <h2 class="title">
            <img src="./imagens/site/doc_hudson.webp" alt="Short Doc Hudson Icon" width="64" height="32">
            Carros disponíveis
        </h2>

        <button>
            <a href="?page=admin#s_cadastro" role="button" title="Adicionar um novo carro">
                <i class="fas fa-plus"></i>
            </a>
        </button>
    </header>

    <?php 
    
    if ($resultadoNaoVazio) { ?>

    <div class="search_container">
        <div class="search">
            <input type="search" id="searchCar" placeholder="Pesquisar..." list="carsList">

            <datalist id="carsList">
                <?php foreach ($registros as $registro) { ?>
                <option value="<?= $registro['nome']; ?>">
                    <?php } ?>
            </datalist>
        </div>
    </div>

    <div class="card_group cars">

        <div class="noResults hide">
            <div class="container">
                <h3>Nenhum resultado encontrado</h3>
            </div>
        </div>

        <?php foreach($registros as $registro): ?>
        <div class="card">
            <header class="image">
                <img src="./imagens/carros/<?= $registro['imagem'] ?>" alt="car">
            </header>

            <div class="card_body">
                <div class="title">
                    <h2>
                        <?= $registro['nome'] ?>
                    </h2>
                </div>

                <div class="card_main">
                    <p class="details" title="<?= $registro['detalhes'] ?>">
                        <?= $registro['detalhes'] ?>
                    </p>
                </div>
            </div>

            <footer class="card_footer">
                <p class="price">
                    <?= converterParaDinheiro($registro['preco']) ?>
                </p>

                <button class="buy_button">
                    <a href="?page=carro&id=<?= $registro['id'] ?>">
                        <i class="fas fa-info-circle"></i>
                        Ver detalhes
                    </a>
                </button>
            </footer>
        </div>

        <?php endforeach; ?>
    </div>

    <?php } else { ?>

    <div class="empty_section">
        <div class="image">
            <img src="./imagens/site/sad_mcqueen.gif" alt="Sad Mcqueen" width="256" height="256">
        </div>
        <div>
            <i class="fas fa-exclamation-triangle"></i>
            <p>Nenhum carro cadastrado até o momento...</p>
            <a href="?page=admin">Cadastrar carro</a>
        </div>
    </div>

    <?php }; ?>
</section>