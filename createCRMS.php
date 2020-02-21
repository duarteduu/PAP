<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';

require_once 'backend/utils.php';


// error variables initialization
$error = '';

// form submit
if (isset_array($_POST, ['nomeCliente', 'motivos', 'contactoPrimeiroNome', 'contactoSegundoNome', 'contactoEmail', 'contactoTelemovel', 'observacoes', 'seguimento', 'contactoMoradaConcelho'])){
    $nomeCliente = trim($_POST['nomeCliente']);
    $motivos = trim($_POST['motivos']);
    $contactoPrimeiroNome = trim($_POST['contactoPrimeiroNome']);
    $contactoSegundoNome = trim($_POST['contactoSegundoNome']);
    $contactoEmail = trim($_POST['contactoEmail']);
    $contactoTelemovel = trim($_POST['contactoTelemovel']);
    $observacoes = trim($_POST['observacoes']);
    $seguimento = trim($_POST['seguimento']);
	$contactoMoradaConcelho = trim($_POST['contactoMoradaConcelho']);

    if (string_size($nomeCliente, 4, 40)){
       if (string_size($contactoPrimeiroNome, 3, 40) && string_size($contactoSegundoNome, 3, 40)){
		   
		   if ($contactoMoradaConcelho == -1){
				$sql = "INSERT INTO crms (nome_cliente, motivos, contacto_primeiro_nome, contacto_ultimo_nome, contacto_email, contacto_numero, observacoes, situacao, registador_id) VALUES ('$nomeCliente', '$motivos', '$contactoPrimeiroNome', '$contactoSegundoNome', '$contactoEmail', '$contactoTelemovel', '$observacoes', $seguimento, ".$_SESSION['userId'].")";

				$conn->query($sql);
				header('Location: crms.php');
				
		   } elseif (isset_array($_POST, ['contactoMoradaFreguesia', 'contactoMoradaCodigoPostal', 'contactoMoradaCodigoPostalExtendido', 'contactoMoradaRua'])){
			   $contactoMoradaFreguesia = $_POST['contactoMoradaFreguesia'];
			   $contactoMoradaCodigoPostal = $_POST['contactoMoradaCodigoPostal'];
			   $contactoMoradaCodigoPostalExtendido = $_POST['contactoMoradaCodigoPostalExtendido'];
			   $contactoMoradaRua = $_POST['contactoMoradaRua'];
			   
			   $sql = "INSERT INTO crms (nome_cliente, motivos, contacto_primeiro_nome, contacto_ultimo_nome, contacto_email, contacto_numero, observacoes, situacao, contacto_distrito_id, contacto_concelho_id, contacto_freguesia_id, contacto_codigo_postal, contacto_codigo_postal_extensao, contacto_morada, registador_id) VALUES ('$nomeCliente', '$motivos', '$contactoPrimeiroNome', '$contactoSegundoNome', '$contactoEmail', '$contactoTelemovel', '$observacoes', '$seguimento', 16, $contactoMoradaConcelho, $contactoMoradaFreguesia, '$contactoMoradaCodigoPostal', '$contactoMoradaCodigoPostalExtendido', '$contactoMoradaRua',". $_SESSION['userId'].")";
		
				$conn->query($sql);
				header('Location: crms.php');
				
		   } else{
			   header('Location: error.php?id=07');
		   }
       } else{
           $error = 'O primeiro nome e último nome do contacto do cliente deve possuir entre 3 a 40 caracteres.';
       }
    } else{
        $error = 'O nome do cliente deve possuir entre 4 a 40 caracteres.';
    }
}
?>

<!doctype html>
<html lang="pt">
<head>
	<script>
		
		function getLocations(){
			let concelho = document.getElementById('contactoMoradaConcelho');
			let freguesia = document.getElementById('contactoMoradaFreguesia');
			let codigoPostal = document.getElementById('contactoMoradaCodigoPostal');
			let codigoPostalEx = document.getElementById('contactoMoradaCodigoPostalExtendido');
			let casa = document.getElementById('contactoMoradaRua');

			if (concelho.value == -1){
				freguesia.setAttribute('disabled', true);
				codigoPostal.setAttribute('disabled', true);
				codigoPostalEx.setAttribute('disabled', true);
				casa.setAttribute('disabled', true);
				
			} else{
				freguesia.removeAttribute('disabled');
				codigoPostal.removeAttribute('disabled');
				codigoPostalEx.removeAttribute('disabled');
				casa.removeAttribute('disabled');
				
				let xhttp = new XMLHttpRequest();
				
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						let data = JSON.parse(this.responseText);
						freguesia.innerHTML = '';
						for (let i = 0 ; i < data.length ; i += 1){
							
							option = document.createElement('OPTION');
							option.setAttribute('value', data[i].codigo);
							
							text = document.createTextNode(data[i].nome);
							
							option.appendChild(text);
							freguesia.appendChild(option);
						}
					}
				}
				
				xhttp.open("GET", "_getLocations.php?codigo_distrito=16&codigo_concelho=" + concelho.value);
				xhttp.send();
			}		
		}
	
		window.onload = ()=>{
			getLocations();
			
			let concelho = document.getElementById('contactoMoradaConcelho');
			concelho.onchange = ()=>{
				getLocations();
			}
		}
	</script>
     <?php require_once 'header.php'; ?>

    <title>Criar CRMS</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Registar CRMS
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container">
                    <div id="input-name">
                        <label for="nomeCliente">Nome do cliente:</label>
                    </div>
                    <input type="text" name="nomeCliente" id="nomeCliente" placeholder="e.g. Câmara Municipal">
            <div id="input-container" class="mb-30">
                    <div id="input-name">
                        <label for="motivos">Motivos:</label>
                    </div>
                    <input type="text" name="motivos" id="motivos" placeholder="e.g. arranjar computador">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="contactoPrimeiroNome">Primeiro nome do contacto:</label>
                </div>
            <input type="text" name="contactoPrimeiroNome" id="contactoPrimeiroNome" placeholder="e.g. André">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="contactoSegundoNome">Segundo nome do contacto:</label>
                </div>
                <input type="text" name="contactoSegundoNome" id="contactoSegundoNome" placeholder="e.g. Sousa">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="contactoEmail">E-mail do contacto:</label>
                </div>
                <input type="text" name="contactoEmail" id="contactoEmail" placeholder="e.g. email@dominio.pt">
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="contactoTelemovel">Telemóvel do contacto:</label>
                </div>
                <input type="number" name="contactoTelemovel" id="contactoTelemovel" placeholder="e.g. 932131123">
            </div>
			<div id="input-container" class="mb-30">
                <div id="input-name">
                    <label>Localidade do contacto:</label>
                </div>
                <select id="contactoMoradaConcelho" name="contactoMoradaConcelho">
					<option value="-1">--------</option>
                    <?php
                        $sql = "SELECT codigo, nome FROM concelhos WHERE codigo_distrito=16;";
                        $result = $conn->query($sql);

                        while($row = $result->fetch_assoc()){
                            echo '<option value="'.$row['codigo'].'">'.$row['nome'].'</value>';
                        }
                    ?>
                </select>
				 <select id="contactoMoradaFreguesia" name="contactoMoradaFreguesia">
                    <option value="-1">--------</option>
                </select>
				<input type="number" maxlength="4" placeholder="e.g. 4900" id="contactoMoradaCodigoPostal" name="contactoMoradaCodigoPostal">
				<input type="number" maxlength="3" placeholder="e.g. 545" id="contactoMoradaCodigoPostalExtendido" name="contactoMoradaCodigoPostalExtendido">
				<input type="text"  placeholder="e.g. Rua das Oliveiras, Nº10" id="contactoMoradaRua" name="contactoMoradaRua">
				
				
            </div>

            <div id="input-container">
                <div id="input-name">
                    <label for="seguimento">Seguimento:</label>
                </div>
                <select id="seguimento" name="seguimento">
                    <?php
                        $sql = "SELECT situacao, descricao FROM seguimentos;";
                        $result = $conn->query($sql);

                        while($row = $result->fetch_assoc()){
                            echo '<option value="'.$row['situacao'].'">'.$row['descricao'].'</value>';
                        }
                    ?>
                </select>
            </div>
            <div id="input-container">
                <div id="input-name">
                    <label for="observacoes">Observações:</label>
                </div>
                <input type="text" name="observacoes" id="observacoes" placeholder="e.g. pagamento em falta">
            </div>

            <input type="submit" value="Criar">
            <a href="crms.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
