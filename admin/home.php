<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador do Site</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assetsAdmin/config.js"></script>
    <?php
    include "./verifica.php";
    ?>


</head>

<body>

    <head>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Admin-Site</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?pg=homePg">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=sobre">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=experiencia">Experiência</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Portifólio
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="?pg=portfolio_categorias">Categorias</a></li>
                                <li><a class="dropdown-item" href="?pg=portfolio_produtos">Produtos</a></li>
                            </ul>
                        </li>    
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=servicos">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=contato">Contato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=rodape">Rodapé</a>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
    </head>

    <div class="container">
        <section>
            <?php
            $pg = $_GET['pg'] ?? "";

            if (!$pg) {
                include_once "./pg/inicio.php";
            } else {
                include_once "./pg/{$pg}.php";
            }
            ?>
        </section>
    </div>

</body>

</html>