<?php

$valorTotalDosVeiculosCadastrados = 0;
$resultadoNaoVazio = false;
$registros = [];

$sql = "SELECT * FROM carros";
$resultado = $conexao->query($sql);
$possuiRegistros = $resultado->num_rows > 0;

if ($possuiRegistros) {
    $resultadoNaoVazio  = true;

    while ($linha = $resultado->fetch_assoc()) {
        $registros[] = $linha;
    }

    $numeroDeVeiculosCadastrados = count($registros);
    foreach ($registros as $registro)
        $valorTotalDosVeiculosCadastrados += $registro['preco'];
}

function converterParaDinheiro($numero)
{
    return 'R$ ' . number_format($numero, 2, ',', '.');
}

function mensagemDoAlerta($request)
{
    $iconeSucesso = '<i class="fas fa-check-circle"></i>';
    $iconeErro = '<i class="fas fa-exclamation-circle"></i>';

    $mensagensDisponiveis = [
        'erros' => [
            "image" => "$iconeErro Aconteceu um erro ao mover a imagem, tenta denovo ai!",
            "image_format" => "$iconeErro Cuidado com o  formato da imagem, camarada!",
            "insert_data" => "$iconeErro Aconteceu um erro ao inserir os dados, tenta denovo ai, cumpadi!",
            "delete" => "$iconeErro O carro não foi apagado, tenta denovo ai, cumpadi!",
            "edit" => "$iconeErro Deu erro na edição, tenta denovo ai, cumpadi!",
        ],
        "sucessos" => [
            "insert_data" => "$iconeSucesso O carro foi cadastrado. Maneeeiro!",
            "delete" => "$iconeSucesso O carro foi apagado, parceiro!",
            "edit" => "$iconeSucesso O carro foi editado, ficou maneeeiro!",
        ]
    ];

    $temErro = isset($request['error']);
    if ($temErro) {
        return $mensagensDisponiveis['erros'][$request['error']] ?? 'Aconteceu um erro desconhecido, parceiro :o';
    }

    return $mensagensDisponiveis['sucessos'][$request['success']] ?? 'Sucesso desconhecido, parceiro :o';
}

?>

<div id="adm_page">
    <h1>Área de administração da página</h1>

    <!-- navegação -->
    <section class="navigation_container" id="s_navegacao">
        <p>Acessar:</p>
        <div class="links_container">
            <nav>
                <ul>
                    <li><a href="?page=home">Início</a></li>
                    <li><a href="?page=carros">Catálogo</a></li>
                    <li><a href="#s_cadastro">Cadastrar carro</a></li>
                    <li><a href="#s_cadastrados">Carros cadastrados</a></li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- /navegação -->

    <!-- formulário -->
    <section class="register_container" id="s_cadastro">

        <h2 class="title">
            <img src="./imagens/site/mater.png" alt="Short Mater Icon" width="64" height="64">
            Cadastrar veículo

            <?php if (!empty($_GET) and isset($_GET['success']) or isset($_GET['error'])) : ?>

                <div class="alert <?= isset($_GET['success']) ? 'success' : 'danger' ?>" id="alert">
                    <p class="alert_message">
                        <?= mensagemDoAlerta($_GET); ?>
                    </p>
                    <button class="alert_button" id="alert_button" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

            <?php endif; ?>
        </h2>

        <form action="./acoes/inserir_carro.php" enctype="multipart/form-data" method="POST" class="form">

            <div class="form_group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Ferrari Roma" required>
            </div>

            <div class="row">
                <div class="form_group">
                    <label for="brand">Marca</label>
                    <input type="text" name="brand" id="brand" placeholder="Ferrari" required>
                </div>

                <div class="form_group">
                    <label for="model">Modelo</label>
                    <input type="text" name="model" id="model" placeholder="Cupê" list="models" required>
                </div>
            </div>

            <datalist id="models">
                <option value="Conversível">
                <option value="Sedã">
                <option value="Hatch">
                <option value="Cupê">
                <option value="Perua">
                <option value="SUV">
                <option value="Picape">
                <option value="Minivan">
                <option value="Van">
                <option value="Buggy">
            </datalist>

            <div class="row">
                <div class="form_group">
                    <label for="year">Ano</label>
                    <input type="text" name="year" id="year" placeholder="2008" pattern="[0-9]{4}" required>
                </div>

                <div class="form_group">
                    <label for="color">Cor</label>
                    <input type="text" name="color" id="color" placeholder="Branca" required>
                </div>

                <div class="form_group">
                    <label for="price">Preço</label>
                    <input type="text" name="price" id="price" placeholder="3.000.000,00" minlength="4" required>
                    <span class="currency">R$</span>
                </div>
            </div>

            <div class="form_group">
                <label for="imageInput">Imagem do carro</label>
                <input type="file" name="image" id="imageInput" accept="image/*" required>
                <div class="bottom">
                    <span class="message">
                        <i class="fas fa-info-circle"></i>
                        Formatos de imagem aceitos: .jpg, .jpeg, .png, .webp
                    </span>
                    <span class="size">Tamanho da imagem: 0MB / 2MB</span>
                </div>
            </div>

            <div class="form_group">
                <label for="details">Detalhes/descrição</label>
                <textarea name="details" id="details" rows="10" placeholder="Detalhes do carro" maxlength="150"></textarea>
                <span id="textarea_message"></span>
            </div>

            <button class="btn register" type="submit">Cadastrar carro</button>
            <button class="btn reset" type="reset">Resetar formulário</button>
        </form>
    </section>
    <!-- /formulario -->

    <!-- tabela -->
    <section class="table_container" id="s_cadastrados">
        <h2 class="title">
            <img src="./imagens/site/mcqueen.png" alt="Short McQueen Icon" width="64" height="32">
            Carros cadastrados
        </h2>

        <table class="table" id="carsTable">
            <thead>
                <tr>
                    <th colspan="9">
                        <input type="search" id="searchInputTable" placeholder="Pesquisar veículo" list="cars">

                        <datalist id="cars">
                            <?php if ($resultadoNaoVazio) : ?>
                                <?php foreach ($registros as $registro) : ?>
                                    <option value="<?= $registro['nome'] ?>">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </datalist>
                    </th>
                </tr>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Cor</th>
                    <th>Preço</th>
                    <th>Detalhes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultadoNaoVazio) {
                    foreach ($registros as $registro) { ?>
                        <tr>
                            <td>
                                <a href="./imagens/carros/<?= $registro['imagem'] ?>" target="_blank" title="Acessar imagem do veículo">
                                    <img src="./imagens/carros/<?= $registro['imagem'] ?>" alt="Car image ilustration" width="56" height="31.50">
                                </a>
                            </td>
                            <td class="carName"><?= $registro['nome'] ?></td>
                            <td><?= $registro['marca'] ?></td>
                            <td>
                                <a href="https://www.google.com/search?q=o+que+e+<?= strtolower($registro['modelo']) ?>&sourceid=chrome&ie=UTF-8" target="_blank">
                                    <?= $registro['modelo'] ?>
                                </a>
                            </td>
                            <td><?= $registro['ano'] ?></td>
                            <td><?= $registro['cor'] ?></td>
                            <td><?= converterParaDinheiro($registro['preco']) ?></td>
                            <td class="details" title="<?= $registro['detalhes'] ?>">
                                <?= $registro['detalhes'] ?>
                            </td>
                            <td class="actions">
                                <a href="?page=edit&id=<?= $registro['id'] ?>" class="btn btn-secondary">
                                    Editar
                                </a>

                                <a href="./acoes/deletar_carro.php?id=<?= $registro['id'] ?>" class="btn btn-secondary">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php };
                } else { ?>
                    <tr>
                        <td colspan="9" class="empty">
                            <i class="fas fa-exclamation-triangle"></i>
                            Nenhum carro cadastrado
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>

        <?php if ($resultadoNaoVazio) : ?>
            <div class="details">
                <p>Número de veículos cadastrados: <?= $numeroDeVeiculosCadastrados ?></p>
                <p>Valor total dos veículos cadastrados: <?= converterParaDinheiro($valorTotalDosVeiculosCadastrados) ?></p>
            </div>
        <?php endif; ?>

    </section>
    <!-- /tabela -->

</div>