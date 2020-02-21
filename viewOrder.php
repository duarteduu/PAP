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

    $sql = "SELECT e.concluida, e.id as id_encomenda, u.username, e.data_pedido_cliente, e.primeiro_nome_cliente, e.ultimo_nome_cliente, e.observacao, CONCAT(e.primeiro_nome_cliente, ' ', e.ultimo_nome_cliente) as nome, e.titulo, e.quantidade, e.loja_id, l.id, l.localidade, e.fornecedor_id, f.nome as nome_fornecedor, e.descricao FROM encomendas as e JOIN lojas as l ON e.loja_id = l.id LEFT JOIN fornecedores as f on e.fornecedor_id = f.id LEFT JOIN utilizadores as u on e.registador_id = u.id WHERE e.id = $id;";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>

    <title>Vizualizar encomenda</title>
</head>
<body>
    <div id="interface-form">
        <div style="font-size: 30px;">
            <p><b>Loja: </b><span class="data"><?php echo $row['localidade']; ?></p></span>
            <p><b>Nome do cliente: </b><span class="data"><?php echo $row['nome']; ?></p></span>
            <p><b>Materiais: </b><span class="data"><?php echo $row['titulo']; ?></p></span>
            <p><b>Quantidade: </b><span class="data"><?php echo $row['quantidade']; ?></p></span>
            <p><b>Fornecedor: </b><span class="data"><?php echo $row['nome_fornecedor']; ?></p></span>
            <p><b>Descrição: </b><span class="data"><?php echo $row['descricao']; ?></p></span>
            <p><b>Observações: </b><span class="data"><?php echo $row['observacao']; ?></p></span>

        </div>
		<a href="orders.php"><button type="button" class="red">Voltar</button></a>
    </div>
</body>
</html>