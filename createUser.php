<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';

// error variables initialization
$error = '';

// form submit
if (isset($_POST['username']) && isset($_POST['password'])){
    $username = str_replace(' ', '', $_POST['username']);
    $password = trim($_POST['password']);

    if (!(strlen($username) >= 4 && strlen($username) <= 20)){
        $error = "O nome de utilizador deve ter entre 4 e 20 caracters. <br/>";

    } elseif (!(strlen($password) >= 8 && strlen($password) < 16)){
        $error = "A password deve ter entre 8 e 16 caracters. <br/>";

    } else{
        $sql = "SELECT id, username, password, admin FROM utilizadores WHERE username='$username';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            $error = "O nome de utilizador já está a ser utilizado. <br/>";
        }  else{
            $sql = "INSERT INTO utilizadores(username, password) VALUES ('".$username."', '".password_hash($password, PASSWORD_DEFAULT)."');";
            $conn->query($sql);
            header('Location: users.php');
        }
    }
}

?>
<!doctype html>
<html lang="pt">
<head>
     <?php require_once 'header.php'; ?>

    <title>Criar Utilizador</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Criar utilizador
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container">
                <div id="input-name">
                    <label for="username">Username</label>
                </div>
                <input type="text" name="username" id="username" placeholder="e.g. admin">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="email">Password</label>
                </div>
                <input type="password" name="password" id="email">
            </div>
            <input type="submit" value="Criar">
            <a href="users.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
