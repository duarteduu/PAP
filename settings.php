<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>

    <title>Definições - Painel de administração</title>
</head>
<body>
    <?php require_once 'menu.php'; ?>
    <div id="interface-form">
        <div style="font-size: 30px;">
            <p><b>Username: </b><span class="data"><?php echo $user_row['username']; ?></p>
            <p><b>Data de criação: </b><span class="data"><?php echo date("d-m-Y \- H:i:s", $user_row['data_criacao']); ?></p>
        </div>
		<a href="editPassword.php"><button type="button"><i class="fas fa-key"></i></i> Alterar password</button></a>
    </div>
</body>
</html>