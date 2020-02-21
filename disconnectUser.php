<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset($_GET['id']) or !isset($_GET['username'])){
    header('Location: users.php');
    die();
}

// form submit
if (isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT id FROM utilizadores WHERE id=$id;";
    $result = $conn->query($sql);

    if ($result->num_rows  < 1){
        $error = 'O utilizador não existe';
    }  else{
        $sql = "UPDATE utilizadores SET desconectar=1 WHERE id=$id;";
        $conn->query($sql);

        header('Location: users.php');
		die();
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>

    <title>Desconectar utilizador</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Desconectar utilizador
        <hr/>
    </div>
        <div id="interface-form">
            <p style="font-size: 30px; margin-top: 50px; text-align: center;">Username: <strong><?php echo $_GET['username']; ?></strong></p>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" value="Desconectar">
                <a href="users.php"><button type="button" class="red">Voltar</button></a>
            </form>
        </div>
        <p class="red-color"><?php echo $error; ?></p>
    </div>
</body>
</html>
