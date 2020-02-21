<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/requireAdmin.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset($_GET['id']) or !isset($_GET['name'])){
    header('Location: provider.php');
    die();
}

// form submit
if (isset($_POST['id']) && isset($_POST['nome'])){
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);

    if (strlen($nome) < 4 || strlen($nome) > 60){
        $error = 'O nome do fornecedor tem de ter entre 4 e 60 caracteres.';
    } else{
        $sql = "SELECT id FROM fornecedores WHERE id=$id;";
        $result = $conn->query($sql);

        if ($result->num_rows  < 1){
            $error = 'O fornecedor não existe';
        }  else{
            $sql = 'UPDATE fornecedores SET nome="'.$nome.'" WHERE id='.$id.';';
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

    <title>Editar fornecedor</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Editar fornecedor
        <hr/>
    </div>
    <div id="interface-form">
        <p style="font-size: 30px; margin-top: 50px; text-align: center;">Fornecedor: <strong><?php echo $_GET['name']; ?></strong></p>
        <form method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="text" name="nome" value="<?php echo $_GET['name']; ?>">
            <input type="submit" value="Alterar">
            <a href="providers.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
