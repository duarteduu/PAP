<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

// check url sent from previous page
if (!isset($_GET['id'])){
    header('Location: orders.php');
    die();
}
// form submit
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT c.contacto_codigo_postal, CONCAT(c.contacto_codigo_postal,'-', c.contacto_codigo_postal_extensao) as cp, c.contacto_morada, cc.nome as c_nome, f.nome as f_nome, c.data_registo, c.nome_cliente, c.motivos, CONCAT(c.contacto_primeiro_nome,' ' ,c.contacto_ultimo_nome) AS contacto_nome, c.contacto_email, c.contacto_numero, c.observacoes, s.descricao  FROM crms as c INNER JOIN seguimentos as s ON s.situacao = c.situacao LEFT JOIN freguesias as f on c.contacto_freguesia_id = f.codigo and c.contacto_concelho_id = f.codigo_concelho and c.contacto_distrito_id = f.codigo_distrito LEFT JOIN concelhos as cc ON cc.codigo = c.contacto_concelho_id WHERE c.id = $id;
";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!doctype html>
<html lang="pt">
<head>
	<?php require_once 'header.php'; ?>

    <title>Visualizar CRM</title>
</head>
<body>
    <div id="interface-form">
        <div style="font-size: 30px;">
			<p><b>Data pedido cliente: </b><span class="data"><?php echo gmdate("d-m-Y \- H:i:s", $row['data_registo']) ?></p></span>
            <p><b>Nome do cliente: </b><span class="data"><?php echo $row['nome_cliente']; ?></p></span>
            <p><b>Motivo: </b><span class="data"><?php echo $row['motivos']; ?></p></span>
            <p><b>Materiais: </b><span class="data"><?php echo $row['contacto_nome']; ?></p></span>
            <p><b>Email do contacto: </b><span class="data"><?php echo $row['contacto_email']; ?></p></span>
            <p><b>Número do contacto: </b><span class="data"><?php echo $row['contacto_numero']; ?></p></span>
            <p><b>Morada do contacto: <br/>
			</b><span class="data">
				<?php 
					if ($row['contacto_morada']){
						echo $row['contacto_morada'].'<br/>';
					}

					if ($row['f_nome']){
						if ($row['contacto_codigo_postal'] != 0){
							echo $row['cp'].', '.$row['f_nome'].'<br/>';
						} else{
							echo $row['f_nome'].'<br/>';
						}
						 
					}
					if ($row['c_nome']){
						echo $row['c_nome'];
					}
				?>
			</p></span>
            <p><b>Observações: </b><span class="data"><?php echo $row['observacoes']; ?></p></span>
            <p><b>Seguimento: </b><span class="data"><?php echo $row['descricao']; ?></p></span>

			

        </div>
		<a href="crms.php"><button type="button" class="red">Voltar</button></a>
    </div>
</body>
</html>