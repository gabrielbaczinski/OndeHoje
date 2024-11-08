<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/TelaInicial/telainicial.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tela Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="js/globalStyle.css">
    <style>
        .table-container {
            max-height: 400px;
            /* Ajuste a altura conforme necessário */
            overflow-y: auto;
            /* Permite rolagem vertical */
            border: 1px solid #dee2e6;
            /* Borda para melhor visualização */
            border-radius: 0.25rem;
            /* Arredondamento das bordas */
        }
    </style>
</head>

<header class="p-3 mb-3 bg-dark" style="margin-bottom: 0 !important;">
    <div class="container" style="margin: 0; padding: 0;">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="width: 100%;">
            <button class="botao" id="menu-button">&#9776;</button>
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
            </a>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 mx-auto" style="width: 60%;">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search" />
            </form>
        </div>
    </div>
</header>

<body>
    <div class="container-fluid">
        <div class="row">
            <div id="menu" class="col-md-3 menu-show" style="padding: 0%;">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="height: 90vh; width: 22vw;">
                    <a href="/"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <img src="../OndeHoje/Imagens/Logo.jpg" alt="" width="32" height="32"
                            class="rounded-circle me-2" />
                        <span class="fs-4 mr-3">ONDE HOJE</span>
                    </a>
                    <hr />
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item ">
                            <a href="#" class="nav-link selected active fw-bold" aria-current="page">
                                Estabelecimentos
                            </a>
                        </li>
                        <li><a href="/OndeHoje/Listar.php" class="nav-link select text-white fw-bold">Lista de associados</a></li>
                        <li><a href="/OndeHoje/Incluir.php" class="nav-link select text-white">Novo cadastro</a></li>
                    </ul>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <!-- Conteúdo Principal -->
            <div id="content" class="col-md-9" style="margin-top: 20px;">
                <div class="card w-100 mx-auto">
                    <div class="card-header bg-dark text-white" style="height: 40px; padding: 10px;">
                        <h5>Estabelecimentos Cadastrados</h5>
                    </div>
                    <div class="card-body" style="height: 78vh;">
                        <div class="table-container">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Endereço</th>
                                        <th>Avaliação</th>
                                        <th>Comentário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'bd/conectaBD.php'; // Inclui a conexão com o banco de dados

                                    // Cria conexão
                                    $conn = mysqli_connect($servername, $username, $password, $database);

                                    // Verifica conexão 
                                    if (!$conn) {
                                        die("Falha na conexão com o Banco de Dados: " . mysqli_connect_error());
                                    }

                                    // Faz Select na Base de Dados
                                    $sql = "SELECT E.ID_evento, E.Nome, E.Endereco, A.Avaliacao, A.Comentario FROM evento AS E
                                    INNER JOIN avaliacao AS A ON (A.ID_rating = E.ID_rating) ORDER BY E.Nome";

                                    if ($result = mysqli_query($conn, $sql)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td class='text-center' style='width: 5%;'>" . $row["ID_evento"] . "</td>";
                                            echo "<td class='text-center' style='width: 10%;'>" . $row["Nome"] . "</td>";
                                            echo "<td class='text-center' style='width: 20%;'>" . $row["Endereco"] . "</td>";
                                            echo "<td class='text-center' style='width: 5%;'>" . $row["Avaliacao"] . "</td>";
                                            echo "<td class='text-center' style='width: 25%;'>" . $row["Comentario"] . "</td>";
                                            echo "<td class='text-center' style='width: 20%;'>
                                            <a href='Atualizar.php?id=" . $row["ID_evento"] . "' class='btn btn-warning btn-sm'>Editar</a>
                                            <a href='Excluir.php?id=" . $row["ID_evento"] . "' class='btn btn-danger btn-sm'>Excluir</a>
                                          </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>Erro executando SELECT: " . mysqli_error($conn) . "</td></tr>";
                                    }


                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script src="js/globalJavaScript.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>

</html>