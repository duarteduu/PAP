<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';


// error variables initialization
$error = '';

// form submit
if (isset($_POST['nome'])){
    $name = trim($_POST['nome']);

    if (strlen($name) < 4 || strlen($name) > 20) {
        $error = "O nome de utilizador deve ter entre 4    e 20 caracters. <br/>";
    } else{
        $sql = "SELECT id, nome FROM fornecedores WHERE nome='".$name."';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $error = "O nome de utilizador já está a ser utilizado. <br/>";
        }  else{
            $sql = "INSERT INTO fornecedores(nome) VALUES ('".$name."');";
            $conn->query($sql);
            header('Location: providers.php');
        }
    }
}

?>
<!doctype html>
<html lang="pt">
<head>
     <?php require_once 'header.php'; ?>

    <title>Adicionar Fornecedor</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Adicionar fornecedor
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container">
                <div id="input-name">
                    <label for="nome">Nome</label>
                </div>
                <input type="text" name="nome" id="nome" placeholder="e.g. PC DIGA">
            </div>
            <input type="submit" value="Criar">
            <a href="providers.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
