<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

// form submit
if (isset($_POST['apagar'])){

    $sql = "DELETE FROM crms WHERE concluida=1;";
    $result = $conn->query($sql);

    header('Location: historyCRMS.php');
}
?>
<!doctype html>
<html lang="pt">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030"> 

    <?php require_once 'header.php'; ?>

    <title>Apagar histórico</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Apagar o histórico de CRMS.
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">Apagar o histórico completo!</strong></p>
        <form method="post">
            <input type="submit" value="Apagar" name="apagar">
            <a href="historyCRMS.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
</div>
</body>
</html>
