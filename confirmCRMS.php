<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/utils.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset_array($_GET, ['id', 'nomeCliente'])){
    header('Location: crms.php');
    die();
}

// form submit
if (isset_array($_POST, ['id'])){
    $id = $_POST['id'];

    $sql = "SELECT id FROM crms WHERE id=$id;";
    $result = $conn->query($sql);

    if ($result->num_rows  < 1){
        $error = 'O registo CRM não existe.';
    }  else{
        $sql = "UPDATE crms SET concluida=1 WHERE id=$id;";
        $conn->query($sql);
        header('Location: crms.php');
        die();
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>

    <title>Confirmar CRM</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Confirmar CRM
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">CRM do cliente: <strong><?php echo $_GET['nomeCliente']; ?></strong></p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Confirmar">
            <a href="crms.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
