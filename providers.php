<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';

?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>
    <script src="scripts/common/jquery.min.js"></script>
    <script src="scripts/common/searchTable.js"></script>

    <title>Fornecedores - Painel de administração</title>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div id="interface-table">
    <?php
        echo '<a href="createProvider.php"><button class="btn"><i class="fas fa-plus"></i> Adicionar um fornecedor</button></a>';
		echo '<input id="input" type="text" placeholder="Procurar... " class="right search">';

    $sql = "SELECT  id, nome FROM fornecedores order by id desc;";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        echo "<table>";	
        echo "<thead>";
		echo "<tr>";
        echo "<th style='cursor: pointer;' onclick='sortTable(0)'>Nome Fornecedor</th>";
        if ($_SESSION['isAdmin']) {
            echo "<th>Opções</th>";
        }

        echo "</tr>";
		echo "</thead>";
		echo "<tbody id='tableToOrd'>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nome'] . "</td>";

            if ($_SESSION['isAdmin']) {
                echo '<td><a href="editProvider.php?id=' . $row['id'] . '&name=' . $row['nome'] . '"><i class="fas fa-edit icon-hover" title="Editar"></i></a>&nbsp&nbsp';
                echo '<a href="deleteProvider.php?id=' . $row['id'] . '&name=' . $row['nome'] . '"><i class="fas fa-user-minus icon-hover" title="Apagar"></i></a></td>';
            }

            echo "</tr>";
        }
		echo "</tbody>";
        echo "</table>";
    } else{
            echo '<p class="important">Sem fornecedores registados!</p>';
    }

    ?>
</div>
</body>
</html>