<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>
	<script src="scripts/common/jquery.min.js"></script>
    <script src="scripts/common/searchTable.js"></script>

    <title>Histórico de CRMs - Painel de administração</title>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div id="interface-table">
    <a href="crms.php"><button class="btn"><i class="fas fa-backward"></i> CRMS atuais</button></a>
    <a href="deleteAllHistoryCRMS.php"><button class="btn" style="background-color: grey"><i class="fas fa-trash-alt"></i> Apagar histórico</button></a>
    <input id="input" type="text" placeholder="Procurar... " style="width: 30%; float: right;">

	<?php
        $sql = "SELECT c.id, c.data_registo, c.nome_cliente, c.motivos, CONCAT(c.contacto_primeiro_nome, ' ', c.contacto_ultimo_nome) as contacto_nome, c.contacto_primeiro_nome, c.contacto_ultimo_nome, c.contacto_email, c.contacto_numero, c.observacoes, c.situacao, c.data_registo, s.situacao, s.descricao FROM crms as c INNER JOIN seguimentos as s ON c.situacao = s.situacao WHERE concluida=1;";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            echo '<table style="width: 100%;">';
			echo "<thead>";
			echo "<tr>";
                echo "<th>Data pedido cliente</th>
                        <th>Nome do cliente</th>
                        <th>Motivos</th>
                        <th>Nome do contacto</th>
                        <th>E-mail do contacto</th>
                        <th>Número do contacto</th>
                        <th>Observações</th>
                        <th>Seguimento</th>
                        <th>Ações</th>
                    </tr>
                    ";
			echo "</thead>";
			echo "<tbody id='tableToOrd'>";
            while ($row = $result->fetch_assoc()){
				echo "<tr>";
                    echo "<td>".date("d-m-Y \- H:i:s", $row['data_registo'])."</td>";
                    echo "<td>".$row['nome_cliente']."</td>";
                    echo "<td>".$row['motivos']."</td>";
                    echo "<td>".$row['contacto_nome']."</td>";
                    if ($row['contacto_email']){
                        echo "<td>".$row['contacto_email']."</td>";
                    } else{
                        echo "<td> -------- </td>";
                    }

                    if ($row['contacto_numero']){
                        echo "<td>".$row['contacto_numero']."</td>";
                    } else{
                        echo "<td>--------</td>";
                    }
					
					if ($row['observacoes']){
                         echo "<td>".$row['observacoes']."</td>";
                    } else{
                        echo "<td>--------</td>";
                    }
                   
                    echo "<td>".$row['descricao']."</td>";
                    echo '<td>';
					echo '<a href="deleteHistoryCRMS.php?id='.$row['id'].'&name='.$row['nome_cliente'].'"><i class="fas fa-times icon-hover" title="Apagar"></i></a>&nbsp&nbsp';
					echo '<a href="recoverHistoryCRMS.php?id='.$row['id'].'&name='.$row['nome_cliente'].'"><i class="fas fa-undo icon-hover" title="Recuperar"></i></a>';
					echo '</td>';
					echo "</tr>";
            }
			echo "</tbody>";
            echo "</table>";
        } else {
            echo '<p class="important">Sem CRMs registados!</p>';
        }
        ?>
</div>
</body>
</html>