<?php
    session_start();
    require_once 'backend/conn.php';
    require_once 'backend/redirectIfLogged.php';

    // error variables initialization
    $error = '';

    // form submit
    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = $conn->real_escape_string(str_replace(' ', '', $_POST['username']));
        $password = $conn->real_escape_string(trim($_POST['password']));
		
			
		$sql = "SELECT id, username, password, admin, desconectar FROM utilizadores WHERE username='$username';";
		$result = $conn->query($sql);
		if (!$result = $conn->query($sql)){
			header('Location: error.php?id=002');
			die();
		}


		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			if (password_verify($password, $row['password'])){
				$_SESSION['userId'] = $row['id'];
				$_SESSION['isAdmin'] = boolval($row['admin']);
				$_SESSION['admin'] = boolval($row['admin']);
				$_SESSION['password'] = $row['password'];
				$_SESSION['username'] = $row['username'];
				
				if (boolval($row['desconectar'])){
					$sql = 'UPDATE utilizadores SET desconectar = 0 WHERE id='.$_SESSION['userId'].';';
					$conn->query($sql);
				}

				header('Location: orders.php');
				die();
			}
			// wrong pass
			$error = 'Utilizador ou password incorretos.';
		}  else{
			// wrong username
			$error = 'Utilizador ou password incorretos.';
		}

    }
    ?>
<!doctype html>
<html lang="pt">
<head>
    <?php require_once 'header.php'; ?>
    <title>Empresas - Login</title>
</head>
<body>
    <div id="interface-form">
        <a class="back" href="/"><i class="fas fa-arrow-circle-left fa-3x"></i></a>
		<p class="login-title">CLIENTE</p>
        <div id="body">
            <form method="post">
                <div id="input-container">
                    <div id="input-name">
                        <label for="username">Utilizador</label>
                    </div>
                    <input type="text" name="username" id="username" placeholder="e.g. utilizador">
                </div>
                <div id="input-container">
                    <div id="input-name">
                        <label for="email">Password</label>
                    </div>
                    <input type="password" name="password" id="email" placeholder="********">
                </div>
				<div id="input-container">
                    <div id="input-name">
                        <label for="email">Repetir Password</label>
                    </div>
                    <input type="password" name="password" id="email" placeholder="********">
                </div>
                <input type="submit" value="Registar">
				<a href="customerLogin.php"><button type="button" class="black">J&aacute; estou registado</button></a>
            </form>
        </div>
        <p class="red-color"><?php echo $error; ?></p>
    </div>
</body>
</html>