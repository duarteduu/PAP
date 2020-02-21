<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

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

    $sql = "SELECT id FROM encomendas WHERE id=$id;";
    $result = $conn->query($sql);

    if ($result->num_rows  < 1){
        $error = 'A encomenda não existe';
    }  else{
        $sql = "UPDATE encomendas SET concluida=1 WHERE id=$id;";
        $conn->query($sql);
        header('Location: orders.php');
        die();
    }
}
?>
<!doctype html>
<html lang="pt">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
     <?php require_once 'header.php'; ?>

    <title>Confirmar Encomenda</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Confirmar encomenda
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">Encomenda: <strong><?php echo $_GET['name']; ?></strong></p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Confirmar">
            <a href="orders.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
