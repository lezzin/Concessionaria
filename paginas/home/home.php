<?php

$mensagem = false;
$sql = "SHOW DATABASES LIKE 'concessionaria'";
$resultado = $conexao->query($sql)->num_rows;

if ($_GET and isset($_GET['create_db'])) {
    $mensagem = true;
    require_once 'acoes/criar_bd_tabela.php';
}

?>

<div id="home_page">

    <section id="s_home">

        <?php if ($mensagem) : ?>

            <div class="alert" id="alert">
                <div class="alert_container">
                    <p>Banco de dados criado com sucesso!</p>
                    <button class="close_alert" id="alert_button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

        <?php endif; ?>

        <div class="container">
            <h1>Olá, seja bem vindo a nossa concessionária!</h1>

            <button>
                <?php if ($resultado == 0): ?>
                    
                    <a href="?create_db=true">
                        <i class="fas fa-database"></i>
                        Criar banco de dados
                    </a>

                <?php else: ?>
                    
                    <a href="?page=carros">
                        <i class="fas fa-car"></i>
                        Acessar produtos
                    </a>

                <?php endif; ?>
            </button>
                            
        </div>
    </section>

</div>