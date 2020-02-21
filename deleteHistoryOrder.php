<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset($_GET['id']) or !isset($_GET['name'])){
    header('Location: historyOrders.php');
    die();
}

// form submit
if (isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT id FROM encomendas WHERE id=".$id.";";

    if ($result->num_rows  < 1){
        $error = 'A encomenda não existe.';

    }  else{
            $sql = "DELETE FROM encomendas WHERE id=".$id.";";
            $conn->query($sql);

            header('Location: historyOrders.php');
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
     <?php require_once 'header.php'; ?>

    <title>Apagar encomenda</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Apagar encomenda já concluída
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">Encomenda concluida: <strong><?php echo $_GET['name']; ?></strong></p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Apagar">
            <a href="historyOrders.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
