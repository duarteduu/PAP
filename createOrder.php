<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';


// error variables initialization
$error = '';


// form submit
if (isset($_POST['loja']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['materiais']) && isset($_POST['quantidade']) && isset($_POST['descricao']) && isset($_POST['observacao'])) {
    $loja = $_POST['loja'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $materiais = trim($_POST['materiais']);
    $quantidade = $_POST['quantidade'];
    $descricao = trim($_POST['descricao']);
    $observacao = trim($_POST['observacao']);

    if (!$_SESSION['isAdmin']) {
        if (isset($_POST['fornecedor']) || isset($_POST['dataPedidoFornecedor'])) {
            header('Location: orders.php');
            die();
        }
    }


    if ((strlen($firstName) >= 3 && strlen($firstName) <= 40) && (strlen($lastName) >= 3 && strlen($lastName) <= 40)) {
        if (strlen($materiais) >= 1 && strlen($materiais) <= 60) {
            if ($quantidade >= 1) {
                if ($_SESSION['isAdmin']) {
                    if ($_POST['fornecedor'] != -1 && $_POST['dataPedidoFornecedor']) {
                        $fornecedor = $_POST['fornecedor'];
                        $dataPedidoFornecedor = $_POST['dataPedidoFornecedor'];

                        $sql = "INSERT INTO encomendas(loja_id, primeiro_nome_cliente, ultimo_nome_cliente, titulo, quantidade, fornecedor_id, data_pedido_fornecedor, registador_id, descricao, observacao) VALUES (" . $loja . ",'" . $firstName . "', '" . $lastName . "', '" . $materiais . "', " . $quantidade . ", " . $fornecedor . ", '" . $dataPedidoFornecedor . "'," . $_SESSION['userId'] . ", '" . $descricao . "', '" . $observacao . "');";

                        $conn->query($sql);
                        header('Location: orders.php');
                        die();

                    } elseif ($_POST['fornecedor'] == -1 && !$_POST['dataPedidoFornecedor']) {
                        $sql = "INSERT INTO encomendas(loja_id, primeiro_nome_cliente, ultimo_nome_cliente, titulo, quantidade, fornecedor_id, registador_id, descricao, observacao) VALUES (" . $loja . ",'" . $firstName . "', '" . $lastName . "', '" . $materiais . "', " . $quantidade . ", NULL, " . $_SESSION['userId'] . ", '" . $descricao . "', '" . $observacao . "');";

                        $conn->query($sql);
                        header('Location: orders.php');
                        die();

                    } else {
                        $error = 'Obrigatório definir o fornecedor em conjunto data do pedido.';
                    }

                } elseif (!$_SESSION['isAdmin']) {
                    $sql = "INSERT INTO encomendas(loja_id, primeiro_nome_cliente, ultimo_nome_cliente, titulo, quantidade, fornecedor_id, registador_id, descricao, observacao) VALUES (" . $loja . ",'" . $firstName . "', '" . $lastName . "', '" . $materiais . "', " . $quantidade . ", NULL, " . $_SESSION['userId'] . ", '" . $descricao . "', '" . $observacao . "');";

                    $conn->query($sql);
                    header('Location: orders.php');
                    die();
                }
            } else{
                $error = "A quantidade deve ser no mínimo 1.";
            }
        } else{
            $error = 'Os materiais devem ter entre 1 a 40 caracters.';
        }
    } else {
        $error = 'O nome e apelido devem ter entre 3 a 40 caracters.';
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
     <?php require_once 'header.php'; ?>

    <title>Criar Encomenda</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Registar encomenda
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="loja">Loja:</label>
                </div>
                <select id="loja" name="loja">
                    <?php
                        $sql = "SELECT id, localidade FROM lojas;";
                        $result = $conn->query($sql);
                        if (!$result = $conn->query($sql)){
                            header('Location: error.php?id=002');
                            die();
                        }
                        while($row = $result->fetch_assoc()){
                            echo '<option value="'.$row['id'].'">'.$row['localidade'].'</value>';
                        }
                    ?>
                </select>
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="firstName">Primeiro nome do cliente:</label>
                </div>
                <input type="text" name="firstName" id="firstName" placeholder="e.g. João">
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="lastName">Último nome do cliente:</label>
                </div>
                <input type="text" name="lastName" id="lastName" placeholder="e.g. Silva">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="materiais">Materiais:</label>
                </div>
                <textarea name="materiais" id="materiais"></textarea>
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="quantidade">Quantidade:</label>
                </div>
                <input type="number" name="quantidade" id="quantidade">
            </div>
			
			<?php if ($_SESSION['isAdmin']): ?>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="fornecedor">Fornecedor:</label>
                </div>
				
				
                <select id="fornecedor" name="fornecedor">
                    <option value="-1">--------</option>
                    <?php
                    $sql = "SELECT id, nome FROM fornecedores;";
                    $result = $conn->query($sql);
                    if (!$result = $conn->query($sql)){
                        header('Location: error.php?id=002');
                        die();
                    }
                    while($row = $result->fetch_assoc()){
                        echo '<option value="'.$row['id'].'">'.$row['nome'].'</value>';
                    }
                    ?>
                </select>
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="dataPedidoFornecedor">Data do pedido ao fornecedor:</label>
                </div>
                <input type="date" name="dataPedidoFornecedor" id="dataPedidoFornecedor">
            </div>
			<?php endif; ?>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="descricao">Descrição:</label>
                </div>
                <input type="text" name="descricao" id="descricao" placeholder="e.g. 8GB RAM">
            </div>
			
            <div id="input-container">
                <div id="input-name">
                    <label for="observacao">Observação:</label>
                </div>
                <input type="text" name="observacao" id="observacao" placeholder="">
            </div>

            <input type="submit" value="Criar">
            <a href="orders.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
