<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- medListar.php -->

<html>
<head>
    <title>Estabelecimentos</title>
    <link rel="icon" type="image/png" href="imagens/Logo.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/customize.css">
</head>
<body  onload="w3_show_nav('menuMedico')">
<!-- Inclui MENU.PHP  -->
<?php require 'geral/menu.php'; ?>
<?php require 'bd/conectaBD.php'; ?>

<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
<div class="w3-main w3-container" style="margin-left:270px;margin-top:117px;">

    <div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
        <p class="w3-large">
        <p>
        <div class="w3-code cssHigh notranslate">
            <!-- Acesso em:-->
            <?php

                date_default_timezone_set("America/Sao_Paulo");
                $data = date("d/m/Y H:i:s", time());
                echo "<p class='w3-small' > ";
                echo "Acesso em: ";
                echo $data;
                echo "</p> "
            ?>
            <div class="w3-container w3-theme">
			<h2>Estabelecimentos cadastrados</h2>
			</div>

            <!-- Acesso ao BD-->
            <?php

                // Cria conexão
                $conn = mysqli_connect($servername, $username, $password, $database);
                
                // Verifica conexão 
                if (!$conn) {
                    echo "</table>";
                    echo "</div>";
                    die("Falha na conexão com o Banco de Dados: " . mysqli_connect_error());
                }
                
                // Configura para trabalhar com caracteres acentuados do português
                mysqli_query($conn,"SET NAMES 'utf8'");
                mysqli_query($conn,'SET character_set_connection=utf8');
                mysqli_query($conn,'SET character_set_client=utf8');
                mysqli_query($conn,'SET character_set_results=utf8');

                // Faz Select na Base de Dados
                $sql = "SELECT E.ID_evento, E.Nome, E.Endereco, A.Avaliacao, A.Comentario FROM evento AS E
                 INNER JOIN avaliacao AS A ON (A.ID_rating = E.ID_rating)  ORDER BY E.Nome";
                echo "<div class='w3-responsive w3-card-4'>";
                if ($result = mysqli_query($conn, $sql)) {
                    echo "<table class='w3-table-all'>";
                    echo "	<tr>";
                    echo "	  <th width='7%'>Status</th>";
                    echo "	  <th width='18%'>Nome do Evento</th>";
                    echo "	  <th width='18%'>Endereço</th>";
                    echo "	  <th width='10%'>Avaliação</th>";
                    echo "	  <th width='15%'>Comentário</th>";
                    echo "	  <th width='7%'> </th>";
                    echo "	  <th width='7%'> </th>";
                    echo "	</tr>";
                    if (mysqli_num_rows($result) > 0) {
                        // Apresenta cada linha da tabela
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cod = $row["ID_evento"];
                            echo "<tr>";
                            echo "<td>";
                            echo $cod;
                            echo "</td><td>";
                            echo $row["Nome"];
                            echo "</td><td>";
                            echo $row["Endereco"];
                            echo "</td><td>";
                            echo $row["Avaliacao"];
                            echo "</td><td>";
                            echo $row["Comentario"];
                            echo "</td>";
                            //Atualizar e Excluir registro de médicos
            ?>              <td>       
                            <a href='medAtualizar.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png' title='Editar Médico' width='32'></a>
                            </td><td>
                            <a href='medExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png' title='Excluir Médico' width='32'></a>
                            </td>
                            </tr>
            <?php
                        }
                    }
                        echo "</table>";
                        echo "</div>";
                } else {
                    echo "Erro executando SELECT: " . mysqli_error($conn);
                }

                mysqli_close($conn);

            ?>
        </div>
    </div>
    
	<?php require 'geral/sobre.php';?>
	<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php';?>

</body>
</html>
