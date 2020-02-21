<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset($_GET['id']) || !isset($_GET['loja']) || !isset($_GET['firstName']) || !isset($_GET['lastName']) || !isset($_GET['materiais']) || !isset($_GET['quantidade']) || !isset($_GET['fornecedor']) || !isset($_GET['descricao']) || !isset($_GET['observacao'])){
    header('Location: orders.php');
    die();
}

// form submit
if (isset($_POST['id']) && isset($_POST['loja']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['materiais']) && isset($_POST['quantidade']) && isset($_POST['descricao']) && isset($_POST['observacao'])) {
    $id = $_POST['id'];
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

                        $sql = "UPDATE encomendas SET loja_id = $loja, primeiro_nome_cliente ='$firstName', ultimo_nome_cliente = '$lastName', titulo = '$materiais', quantidade = $quantidade, fornecedor_id = $fornecedor, data_pedido_fornecedor = '$dataPedidoFornecedor', registador_id =" . $_SESSION['userId'] . ", descricao = '$descricao', observacao = '$observacao' WHERE id=$id";
                        $conn->query($sql);
                        header('Location: orders.php');

                    } elseif ($_POST['fornecedor'] == -1 && !$_POST['dataPedidoFornecedor']) {
                        $sql = "UPDATE encomendas SET loja_id = $loja, primeiro_nome_cliente ='$firstName', ultimo_nome_cliente = '$lastName', titulo = '$materiais', quantidade = $quantidade, fornecedor_id = NULL, data_pedido_fornecedor = NULL, registador_id =" . $_SESSION['userId'] . ", descricao = '$descricao', observacao = '$observacao' WHERE id=$id";
                        $conn->query($sql);
                        header('Location: orders.php');
                    } else {
                        $error = 'Obrigatório definir o fornecedor em conjunto data do pedido.';
                    }
                } else {
                    $sql = "UPDATE encomendas SET loja_id = $loja, primeiro_nome_cliente ='$firstName', ultimo_nome_cliente = '$lastName', titulo = '$materiais', quantidade = $quantidade, fornecedor_id = NULL, data_pedido_fornecedor = NULL, registador_id =" . $_SESSION['userId'] . ", descricao = '$descricao', observacao = '$observacao' WHERE id=$id";
                    $conn->query($sql);
                    header('Location: orders.php');
                }
            } else {
                $error = "A quantidade deve ser no mínimo 1.";
            }
        } else {
            $error = 'Os materiais devem ter entre 1 e 60 caracteres.';
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

    <title>Editar encomenda</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Editar encomenda
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
                        if ($row['id'] == $_GET['loja']){
                            echo '<option value="'.$row['id'].'" selected>'.$row['localidade'].'</value>';
                        } else{
                            echo '<option value="'.$row['id'].'">'.$row['localidade'].'</value>';
                        }

                    }
                    ?>
                </select>
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="firstName">Primeiro nome do cliente:</label>
                </div>
                <input type="text" name="firstName" id="firstName" value="<?php echo $_GET['firstName']; ?>">
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="lastName">Último nome do cliente:</label>
                </div>
                <input type="text" name="lastName" id="lastName" value="<?php echo $_GET['lastName']; ?>">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="materiais">Materiais:</label>
                </div>
                <input type="text" name="materiais" id="materiais" value="<?php echo $_GET['materiais']; ?>">
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="quantidade">Quantidade:</label>
                </div>
                <input type="number" name="quantidade" id="quantidade" value="<?php echo $_GET['quantidade']; ?>">
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="fornecedor">Fornecedor:</label>
                </div>
                <select id="fornecedor" name="fornecedor" <?php echo $_SESSION['isAdmin']?'':'disabled'; ?>>
                    <option value="-1">--------</option>
                    <?php
                    $sql = "SELECT id, nome FROM fornecedores;";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        if ($row['id'] == $_GET['fornecedor']){
                            echo '<option value="'.$row['id'].'" selected>'.$row['nome'].'</value>';
                        } else{
                            echo '<option value="'.$row['id'].'">'.$row['nome'].'</value>';
                        }

                    }
                    ?>
                </select>
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="dataPedidoFornecedor">Data do pedido ao fornecedor:</label>
                </div>
                <input type="date" name="dataPedidoFornecedor" id="dataPedidoFornecedor" value="<?php echo date('Y-m-d'); ?>" <?php echo $_SESSION['isAdmin']?'':'disabled'; ?>>
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="descricao">Descrição:</label>
                </div>
                <input type="text" name="descricao" id="descricao" value="<?php echo $_GET['descricao']; ?>">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="observacao">Observações:</label>
                </div>
                <input type="text" name="observacao" id="observacao" value="<?php echo $_GET['observacao']; ?>">
            </div>

            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Alterar">
            <a href="orders.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
