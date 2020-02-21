<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

// error variables initialization
$error = '';

$userId = $_SESSION["userId"];

// form submit
if (isset($_POST['password']) && isset($_POST['confirmPassword'])){
	
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	$sql = "SELECT password FROM utilizadores WHERE id=$userId;";
    $result = $conn->query($sql);

	if ($password == $confirmPassword){
		if (strlen($password) < 8 || strlen($password) > 16){
			$error = 'A password deve ter entre 8 e 16 caracters.';
		} else{
			if ($result->num_rows  < 1){
				$deleteError = 'O utilizador não existe.';
			}  else{
				$sql = 'UPDATE utilizadores SET password="'.password_hash($password,PASSWORD_DEFAULT).'" WHERE id='.$userId.';';
				$conn->query($sql);
				header('Location: settings.php');
			}
		}
	} else{
        $error = 'As passwords não coincidem.';
    }
}


?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/common/style.css"/>

    <title>Login</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Alterar password
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container">
                <div id="input-name">
                    <label for="username">Nova password</label>
                </div>
                <input type="password" name="password" id="password" placeholder="********">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="email">Confirmar password</label>
                </div>
                <input type="password" name="confirmPassword" id="email"  placeholder="********">
            </div>
            <input type="submit" value="Alterar">
            <a href="settings.php"><button type="button" class="red">Cancelar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
