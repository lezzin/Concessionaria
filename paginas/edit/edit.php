<?php

if (!isset($_GET)) {
    die('Sem dados para processar');
}

$sql = "SELECT * from carros WHERE id = $_GET[id]";
$resultado = $conexao->query($sql)->fetch_assoc();

?>
<!-- formulário -->
<section class="register_container" id="s_edit">

    <h2 class="title">
        <img src="./imagens/site/mater.png" alt="Short Mater Icon" width="64" height="64">
        Editar veículo
    </h2>

    <form action="./acoes/editar_carro.php" method="POST" class="form">

        <div class="form_group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" value="<?= $resultado['nome'] ?>">
        </div>

        <div class="row">
            <div class="form_group">
                <label for="brand">Marca</label>
                <input type="text" name="brand" id="brand" value="<?= $resultado['marca'] ?>">
            </div>

            <div class="form_group">
                <label for="model">Modelo</label>
                <input type="text" name="model" id="model" list="models" value="<?= $resultado['modelo'] ?>">
            </div>
        </div>

        <input type="hidden" name="id" value="<?= $resultado['id'] ?>">

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
                <input type="text" name="year" id="year" pattern="[0-9]{4}" value="<?= $resultado['ano'] ?>">
            </div>

            <div class="form_group">
                <label for="color">Cor</label>
                <input type="text" name="color" id="color" value="<?= $resultado['cor'] ?>">
            </div>

            <div class="form_group">
                <label for="price">Preço</label>
                <input type="text" name="price" id="price" minlength="4" value="<?= $resultado['preco'] ?>">
                <span class="currency">R$</span>
            </div>
        </div>

        <div class="form_group">
            <label for="details">Detalhes/descrição</label>
            <input type="text" name="details" id="details" value="<?= $resultado['detalhes'] ?>"></textarea>
            <span id=" textarea_message"></span>
        </div>

        <button class="btn register" type="submit">Editar carro</button>
        <button class="btn reset" type="reset">Valores padrões</button>
    </form>
</section>
<!-- /formulario -->