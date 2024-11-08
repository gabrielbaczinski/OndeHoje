<!DOCTYPE html>
<html>

<head>
    <title>Exclusão do Estabelecimento</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="js/globalStyle.css">
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

            <!-- Conteúdo Principal -->
            <div id="content" class="col-md-9" style="margin-top: 20px;">
                <div class="card w-100 mx-auto">
                    <div class="card-header bg-dark text-white">
                        <h5>Confirmação de Exclusão do Estabelecimento</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        require 'bd/conectaBD.php';

                        // Validação do ID
                        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
                        if ($id === false) {
                            die("ID inválido.");
                        }

                        // Cria conexão
                        $conn = mysqli_connect($servername, $username, $password, $database);

                        // Verifica conexão
                        if (!$conn) {
                            die("<strong> Falha de conexão: </strong>" . mysqli_connect_error());
                        }

                        // Configura para trabalhar com caracteres acentuados do português
                        mysqli_query($conn, "SET NAMES 'utf8'");
                        mysqli_query($conn, 'SET character_set_connection=utf8');
                        mysqli_query($conn, 'SET character_set_client=utf8');
                        mysqli_query($conn, 'SET character_set_results=utf8');

                        // Faz Select na Base de Dados
                        $sql = "SELECT E.ID_evento, E.Nome, E.Endereco, A.Avaliacao, A.Comentario 
                                FROM evento AS E 
                                INNER JOIN avaliacao AS A ON E.ID_rating = A.ID_rating 
                                WHERE E.ID_evento = $id";

                        // Início da DIV form
                        if ($result = mysqli_query($conn, $sql)) {
                            if (mysqli_num_rows($result) == 1) {
                                $row = mysqli_fetch_assoc($result);
                        ?>
                                <form class="w3-container" action="Excluir_exe.php" method="post">
                                    <input type="hidden" id="Id" name="Id" value="<?php echo $row['ID_evento']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Nome:</b> <?php echo $row['Nome']; ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Endereço:</b> <?php echo $row['Endereco']; ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Avaliação:</b> <?php echo $row['Avaliacao']; ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Comentário:</b> <?php echo $row['Comentario']; ?></label>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-danger">Confirma exclusão?</button>
                                        <button type="button" class="btn btn-secondary" onclick="window.location.href='Listar.php'">Cancelar</button>
                                    </div>
                                </form>
                        <?php 
                            } else { ?>
                                <div class="alert alert-danger" role="alert">
                                    Tentativa de exclusão de Estabelecimento inexistente.
                                </div>
                            <?php }
                        } else {
                            echo "<p style='text-align:center'>Erro executando SELECT: " . mysqli_error($conn) . "</p>";
                        }
                        mysqli_close($conn);  // Encerra conexão com o BD
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="js/globalJavaScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>

</html>
