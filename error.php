<?php
session_start();
?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>

    <title>Erro</title>
</head>
<body>
<div style="width: 60%; margin: 60px auto;">
    <p style="font-size: 40px; margin: 0;">Erro</p>
    <p>Id: <?php echo isset($_GET['id'])?$_GET['id']:'desconhecido'; ?></p>
    <p><a href="login.php">Voltar</a></p>
</div>
</body>
</html>
