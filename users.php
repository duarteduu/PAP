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

    <title>Utilizadores - Painel de administração</title>
</head>
<body>
    <?php require_once 'menu.php'; ?>
    <div id="interface-table">
        <a href="createUser.php"><button class="btn"><i class="fas fa-plus"></i> Criar utilizador</button></a>
        <?php
        $sql = "SELECT id, username, password, admin FROM utilizadores WHERE admin=0;";
        $result = $conn->query($sql);
        if (!$result = $conn->query($sql)){
            header('Location: error.php?id=002');
            die();
        }

        if($result->num_rows > 0){
            echo "<table>";
			echo "<thead>";
            echo "<tr>";
                echo "<th>Username</th>";
                echo "<th>Opções</th>";
            echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
            while ($row = $result->fetch_assoc()){
                echo "<tr>";
                    echo "<td>".$row['username']."</td>";
					echo '<td><a href="disconnectUser.php?id='.$row['id'].'&username='.$row['username'].'"><i class="fas fa-sign-out-alt" title="Desconectar"></i></i></a> ';
                    echo '<a href="deleteUser.php?id='.$row['id'].'&username='.$row['username'].'"><i class="fas fa-user-minus icon-hover" title="Apagar"></i></a> ';
                echo "</tr>";
            }
			echo "</tbody>";
            echo "</table>";
        } else{
            echo '<p class="important">Sem utilizadores registados!</p>';
        }
        ?>
    </div>
</body>
</html>