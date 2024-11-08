<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Atualização de Estabelecimento</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="js/globalStyle.css">
    <style>
        .message-container {
            height: 90vh; /* Para centralizar verticalmente */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

<header class="p-3 mb-3 bg-dark" style="margin-bottom: 0 !important;">
    <div class="container" style="margin: 0; padding: 0;">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="width: 100%;">
            <button class="botao" id="menu-button">&#9776;</button>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 mx-auto" style="width: 60%;">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search" />
            </form>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <div id="menu" class="col-md-3 menu-show" style="padding: 0%;">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="height: 90vh; width: 22vw;">
                <a href="/"
                   class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <img src="../OndeHoje/Imagens/Logo.jpg" alt="" width="32" height="32" class="rounded-circle me-2" />
                    <span class="fs-4 mr-3">ONDE HOJE</span>
                </a>
                <hr />
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item ">
                        <a href="#" class="nav-link selected active fw-bold" aria-current="page">
                            Estabelecimentos
                        </a>
                    </li>
                    <li><a href="/OndeHoje/Listar.php" class="nav-link select text-white">Lista de associados</a></li>
                    <li><a href="/OndeHoje/Incluir.php" class="nav-link select text-white fw-bold">Novo cadastro</a></li>
                </ul>
            </div>
        </div>

        <div id="content" class="col-md-9 d-flex flex-column">
            <div class="container flex-grow-1 message-container">
                <?php
                require 'bd/conectaBD.php';

                // Recebe os dados do formulário
                $id         = $_POST['Id'];
                $nome       = $_POST['Nome'];
                $endereco   = $_POST['Endereco'];
                $avaliacao  = $_POST['Avaliacao'];
                $comentario = $_POST['Comentario']; // Campo de comentário, se aplicável

                // Cria conexão
                $conn = mysqli_connect($servername, $username, $password, $database);

                // Verifica conexão
                if (!$conn) {
                    die("<strong> Falha de conexão: </strong>" . mysqli_connect_error());
                }

                // Configura para trabalhar com caracteres acentuados do português
                mysqli_query($conn,"SET NAMES 'utf8'");
                mysqli_query($conn,'SET character_set_connection=utf8');
                mysqli_query($conn,'SET character_set_client=utf8');
                mysqli_query($conn,'SET character_set_results=utf8');

                // Insere na tabela de avaliação
                $sqlAvaliacao = "INSERT INTO avaliacao (Avaliacao, Comentario) VALUES ('$avaliacao', '$comentario')";
                echo "<div class='w3-responsive w3-card-4'>";
                if (mysqli_query($conn, $sqlAvaliacao)) {
                    $id_rating = mysqli_insert_id($conn); // Obtém o ID da avaliação inserida

                    // Atualiza a tabela de evento com o ID da nova avaliação
                    $sqlEvento = "UPDATE evento SET Nome = '$nome', Endereco = '$endereco', ID_rating = '$id_rating' WHERE ID_evento = $id";

                    if (mysqli_query($conn, $sqlEvento)) {
                        echo "<div class='alert alert-success text-center' role='alert'>Registro de estabelecimento atualizado com sucesso!</div>";
                    } else {
                        echo "<div class='alert alert-danger text-center' role='alert'>Erro ao atualizar evento: " . mysqli_error($conn) . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger text-center' role='alert'>Erro ao inserir avaliação: " . mysqli_error($conn) . "</div>";
                }
                echo "</div>";
                mysqli_close($conn); // Encerra conexão com o BD
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
