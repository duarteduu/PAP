<?php
    if (!isset($_SESSION['userId'])){
        header('Location: login.php');
        die();
    }

    $sql = "SELECT id, username, password, admin, data_criacao, desconectar FROM utilizadores WHERE id=".$_SESSION['userId'].";";
	$result = $conn->query($sql);
	
    if ($result->num_rows < 1){
        
    }
	
	$user_row = $result->fetch_assoc();
	if (boolval($user_row['desconectar'])){
		$sql = 'UPDATE utilizadores SET desconectar = 0 WHERE id='.$_SESSION['userId'].';';
		$conn->query($sql);
		
		header('Location: logout.php');
		die();
		
	} elseif (($user_row['password'] != $_SESSION['password']) or ($user_row['admin'] != $_SESSION['isAdmin'])){
		header('Location: logout.php');
        die();
	} 
