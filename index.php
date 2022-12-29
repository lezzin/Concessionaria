<?php

require_once './config/conexao.php';

$paginasExistentes = ['home', 'admin', 'carro', 'carros', 'edit'];
$paginaAtual = $_GET['page'] ?? 'home';

$paginaNaoExiste = !in_array($paginaAtual, $paginasExistentes);
if ($paginaNaoExiste) $paginaAtual = '404';

$titulo = ucfirst($paginaAtual) . " - Concessionária";
$conexao = $paginaAtual == 'home' ? novaConexao(null) : novaConexao();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Leandro Adrian e João Moreira - INFO D">
    <meta name="description" content="Projeto Final - Tecnologias Web - Leandro Adrian e João Moreira - INFO D">
    <meta name="theme-color" content="#d14b4b">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <!-- icone da janela -->
    <link rel="icon" href="./imagens/site/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="./scss/style.css">

    <title><?= $titulo ?></title>
</head>

<body class="no-scroll">

    <!-- header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="?page=home">
                    <img src="./imagens/site/logo.png" alt="logo" width="38" height="38">
                    Concessionária
                </a>
            </div>

            <?php if ($paginaAtual != 'home') : ?>
                <nav class="menu">
                    <ul>
                        <li><a href="?page=home">Início</a></li>
                        <li><a href="?page=carros">Veículos</a></li>
                        <li><a href="?page=admin">Admin</a></li>
                    </ul>
                </nav>
            <?php endif; ?>

        </div>
    </header>
    <!-- /header -->

    <!-- loader -->
    <div class="loader hide">
        <img src="./imagens/site/logo.png" alt="logo" width="128" height="110">
    </div>
    <!-- /loader -->

    <!-- main -->
    <main class="main">
        <div class="main_container">

            <!-- conteúdo dinâmico utilizando includes -->
            <?php include_once("./paginas/$paginaAtual/$paginaAtual.php"); ?>

        </div>
    </main>
    <!-- /main -->

    <!-- footer -->
    <footer>
        <div class="container">
            <p>Concessionária - <?= date('d/m/Y') ?></p>
            <p>&copy Leandro Adrian e João Moreira</p>
        </div>
    </footer>
    <!-- /footer -->

    <!-- toTop -->
    <a href="#" class="toTop">
        <i class="fas fa-arrow-circle-up"></i>
    </a>
    <!-- /toTop -->

    <script src="./js/script.js"></script>
</body>

</html>