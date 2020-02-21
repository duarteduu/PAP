<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset($_GET['id']) or !isset($_GET['name'])){
    header('Location: provider.php');
    die();
}

// form submit
if (isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT id FROM fornecedores WHERE id=$id;";
    $result = $conn->query($sql);

    if ($result->num_rows  < 1){
        $error = 'O fornecedor não existe';
    }  else{
        $sql = "SELECT fornecedor_id FROM encomendas WHERE fornecedor_id=".$id." and concluida=0;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            $error = 'Não é possivel apagar o fornecedor porque existem encomendas ativas associadas a este.';
        } else{
            $sql = "UPDATE encomendas SET fornecedor_id = NULL WHERE fornecedor_id=$id;";
            $conn->query($sql);

            $sql = "DELETE FROM fornecedores WHERE id=$id;";
            $conn->query($sql);
            header('Location: providers.php');
        }
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
     <?php require_once 'header.php'; ?>

    <title>Apagar fornecedor</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Apagar fornecedor
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">Fornecedor: <strong><?php echo $_GET['name']; ?></strong></p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Apagar">
            <a href="providers.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
