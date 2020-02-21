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

    <title>Histórico de ncomendas - Painel de administração</title>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div id="interface-table">
    <a href="orders.php"><button class="btn"><i class="fas fa-backward"></i> Encomendas atuais</button></a>
    <a href="deleteAllHistoryOrder.php"><button class="btn" style="background-color: grey"><i class="fas fa-trash-alt"></i> Apagar histórico</button></a>
    <input id="input" type="text" placeholder="Procurar... " style="width: 30%; float: right;">

	<?php
    $sql = "SELECT DATE_FORMAT(e.data_pedido_fornecedor, '%d-%m-%Y') as data_pedido_fornecedor, e.concluida, e.id as id_encomenda, u.username, e.data_pedido_cliente, e.primeiro_nome_cliente, e.ultimo_nome_cliente, e.observacao, CONCAT(e.primeiro_nome_cliente, ' ', e.ultimo_nome_cliente) as nome, e.titulo, e.quantidade, e.loja_id, l.id, l.localidade, e.fornecedor_id, f.nome as nome_fornecedor, e.descricao FROM encomendas as e INNER JOIN lojas as l ON e.loja_id = l.id LEFT JOIN fornecedores as f on e.fornecedor_id = f.id LEFT JOIN utilizadores as u on e.registador_id = u.id WHERE e.concluida=1 ORDER BY e.data_pedido_cliente desc;";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo '<table style="width: 100%;">';
                echo "<thead>";
				echo "<tr>";
                echo "  <th>Loja</th>
						<th>Material</th>
						<th>Quantidade</th>
						<th>Nome comprador</th>
						<th>Fornecedor</th>
						<th>Data pedido fornecedor</th>
						<th>Data pedido cliente</th>
						<th>Utilizador registador</th>
						<th>Opções</th>
					</tr>
					";
                echo "</thead>";
                echo "<tbody id='tableToOrd'>";
                    while ($row = $result->fetch_assoc()){
                        echo "<tr>";
                            echo "<td>".$row['localidade']."</td>";
                            echo "<td>".$row['titulo']."</td>";
                            echo "<td>".$row['quantidade']."</td>";
                            echo "<td>".$row['nome']."</td>";

                            if ($row['nome_fornecedor']){
                                echo "<td>".$row['nome_fornecedor']."</td>";
                            } else{
                                echo "<td> -------- </td>";
                            }
                            if ($row['data_pedido_fornecedor']){
                                echo "<td>".$row['data_pedido_fornecedor']."</td>";
                            } else{
                                echo "<td> -------- </td>";
                            }
                            echo "<td>".date("d-m-Y \- H:i:s", $row['data_pedido_cliente'])."</td>";
                            if ($row['username']){
                                echo "<td>".$row['username']."</td>";
                            } else {
                                echo "<td> -------- </td>";
                            }
                            echo '<td>';
							echo '<a href="deleteHistoryOrder.php?id='.$row['id_encomenda'].'&name='.$row['titulo'].'"><i class="fas fa-times icon-hover" title="Apagar"></i></a>&nbsp&nbsp';
							echo '<a href="recoverHistoryOrder.php?id='.$row['id_encomenda'].'&name='.$row['titulo'].'"><i class="fas fa-undo icon-hover" title="Recuperar"></i></a>';
                            echo '</td>';
                        echo "</tr>";
                    }
				echo "</tbody>";
                echo "</table>";
    } else {
        echo '<p class="important">Sem encomendas!</p>';
    }
    ?>
</div>
</body>
</html>