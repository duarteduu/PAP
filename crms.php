<?php
    session_start();
    require_once 'backend/conn.php';
    require_once 'backend/requireLogin.php';
    require_once 'backend/utils.php';
?>

<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>
	<script src="scripts/common/jquery.min.js"></script>
    <script src="scripts/common/searchTable.js"></script>

    <title>CRMS - Painel de administração</title>
</head>
<body>
    <?php require_once 'menu.php'; ?>

    <div id="interface-table">
        <a href="createCRMS.php"><button class="btn"><i class="fas fa-plus"></i> Registar CRM</button></a>
		<a href="historyCRMS.php"><button class="btn" style="background-color: grey"><i class="fas fa-history"></i> Histórico de CRMS</button></a>
		<input id="input" type="text" placeholder="Procurar... " class="right search">

        <?php
        $sql = "SELECT c.contacto_morada, c.contacto_codigo_postal, c.contacto_codigo_postal_extensao, c.contacto_freguesia_id, c.contacto_concelho_id, contacto_distrito_id, c.id, c.data_registo, c.nome_cliente, c.motivos, CONCAT(c.contacto_primeiro_nome, ' ', c.contacto_ultimo_nome) as contacto_nome, c.contacto_primeiro_nome, c.contacto_ultimo_nome, c.contacto_email, c.contacto_numero, c.observacoes, c.situacao, c.data_registo, s.situacao, s.descricao, u.username FROM crms as c LEFT JOIN seguimentos as s ON c.situacao = s.situacao LEFT JOIN utilizadores as u on u.id = c.registador_id WHERE concluida=0 ORDER BY c.data_registo desc;";
		
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            echo '<table style="width: 100%;">';
			echo '<thead>';
            echo "<tr>";
                echo "<th>Data pedido cliente</th>
                        <th>Nome do cliente</th>
                        <th>Motivos</th>
                        <th>Nome do contacto</th>
                        <th>E-mail do contacto</th>
                        <th>Número do contacto</th>
                        <th>Observações</th>
                        <th>Seguimento</th>
                        <th>Uilizador registador</th>
                        <th>Ações</th>
                    </tr>
                    ";
			echo '</thead>';
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
					echo "<td>".$row['username']."</td>";
                    echo '<td>';
                        echo '<a href="viewCRMS.php'.build_get_query([
                                'id' => $row['id'],
                            ]).'"><i class="fas fa-eye icon-hover" title="Ver"></i></a>&nbsp&nbsp';

                        echo '<a href="confirmCRMS.php'.build_get_query([
                                'id' => $row['id'],
                                'nomeCliente' => $row['nome_cliente']
                            ]).'"><i class="fas fa-clipboard-check icon-hover" title="Confirmar"></i></a>&nbsp&nbsp';

                        echo  '<a href="editCRMS.php'.build_get_query([
                                'id' => $row['id'],
                                'nomeCliente' => $row['nome_cliente'],
                                'contactoPrimeiroNome' => $row['contacto_primeiro_nome'],
                                'contactoUltimoNome' => $row['contacto_ultimo_nome'],
                                'contactoEmail' => $row['contacto_email'],
                                'contactoNumero' => $row['contacto_numero'],
                                'observacoes' => $row['observacoes'],
                                'situacao' => $row['situacao'],
								'codigoPostal' => $row['contacto_codigo_postal'],
								'codigoPostalEx' => $row['contacto_codigo_postal_extensao'],
								'contactoMorada' => $row['contacto_morada'],
								'concelhoId' => $row['contacto_concelho_id'],
								'freguesiaId' => $row['contacto_freguesia_id']
                            ]).'"><i class="fas fa-edit icon-hover" title="Editar"></i></a>';
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