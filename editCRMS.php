<?php
session_start();
require_once 'backend/conn.php';
require_once 'backend/requireLogin.php';
require_once 'backend/utils.php';

// error variables initialization
$error = '';

// check url sent from previous page
if (!isset_array($_GET, ['id', 'nomeCliente', 'contactoUltimoNome', 'contactoEmail', 'contactoNumero', 'observacoes', 'situacao', 'codigoPostal', 'codigoPostalEx', 'contactoMorada', 'freguesiaId', 'concelhoId'])){
    header('Location: crms.php');
    die();
}

// form submit
if (isset_array($_POST, ['id', 'nomeCliente', 'contactoPrimeiroNome', 'contactoUltimoNome', 'contactoEmail', 'contactoNumero', 'situacao', 'observacoes', 'contactoMoradaConcelho'])){
    $id = $_POST['id'];
    $nomeCliente = trim($_POST['nomeCliente']);
    $contactoPrimeiroNome = trim($_POST['contactoPrimeiroNome']);
    $contactoUltimoNome = trim($_POST['contactoUltimoNome']);
    $contactoEmail = str_replace(' ', '', $_POST['contactoEmail']);
    $contactoNumero = $_POST['contactoNumero'];
    $situacao = $_POST['situacao'];
    $observacoes = $_POST['observacoes'];
	
	$contactoMoradaConcelho = $_POST['contactoMoradaConcelho'];
	

    if (string_size($nomeCliente, 3, 40)) {
        if (string_size($contactoPrimeiroNome, 3, 40) && string_size($contactoUltimoNome, 3, 40)){
			if (string_size((string) $contactoNumero, 0, 16)){
				
				if ($contactoMoradaConcelho == -1){
					$sql = "UPDATE crms SET nome_cliente='$nomeCliente', contacto_primeiro_nome='$contactoPrimeiroNome', contacto_ultimo_nome='$contactoUltimoNome', contacto_email='$contactoEmail', contacto_numero='$contactoNumero', observacoes='$observacoes', situacao=$situacao, contacto_concelho_id=NULL, contacto_distrito_id=NULL, contacto_freguesia_id=NULL, contacto_morada=NULL, contacto_codigo_postal=NULL, contacto_codigo_postal_extensao=NULL WHERE id=$id;";
					$conn->query($sql);
					
				} elseif (isset_array($_POST, ['contactoMoradaConcelho', 'contactoMoradaFreguesia', 'contactoMoradaCodigoPostal', 'contactoMoradaCodigoPostalExtendido', 'contactoMoradaRua'])){
					$contactoConcelho = $_POST['contactoMoradaConcelho'];
					$contactoFreguesia = $_POST['contactoMoradaFreguesia'];
					$contactoMoradaCodigoPostal = $_POST['contactoMoradaCodigoPostal'];
					$contactoMoradaCodigoPostalExtendido = $_POST['contactoMoradaCodigoPostalExtendido'];
					$contactoMoradaRua = $_POST['contactoMoradaRua'];
					
					$sql = "UPDATE crms SET nome_cliente='$nomeCliente', contacto_primeiro_nome='$contactoPrimeiroNome', contacto_ultimo_nome='$contactoUltimoNome', contacto_email='$contactoEmail', contacto_numero='$contactoNumero', observacoes='$observacoes', situacao=$situacao, contacto_concelho_id=$contactoConcelho, contacto_distrito_id=16, contacto_freguesia_id=$contactoFreguesia, contacto_morada='$contactoMoradaRua', contacto_codigo_postal='$contactoMoradaCodigoPostal', contacto_codigo_postal_extensao='$contactoMoradaCodigoPostalExtendido' WHERE id=$id;";
					$conn->query($sql);
					
				} else{
					header('Location: error.php?id=07');
					die();
				}

				header('Location: crms.php');
				die();
			} else{
				$error = "O contacto deve possuir no máximo 16 digitos.";
			}
        } else{
            $error = "O primeiro e último nome dos clientes devem conter entre 3 e 40 caracteres.";
        }
    } else{
        $error = "O nome do cliente devem conter entre 3 e 40 caracteres.";
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
<script>
		
		function getLocations(id){
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
							
							
							if (data[i].codigo == id){
								option.setAttribute('selected', true);
							}
							
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
			getLocations(<?php echo $_GET['freguesiaId']; ?>);
			
			let concelho = document.getElementById('contactoMoradaConcelho');
			concelho.onchange = ()=>{
				getLocations(-1);
			}
		}
	</script>
    <?php require_once 'header.php'; ?>

    <title>Editar CRM</title>
</head>
<body>
<div id="interface-form">
    <div id="header-text">
        Editar CRM
        <hr/>
    </div>
    <div id="interface-form">
        <form method="post">
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="nomeCliente">Nome do cliente:</label>
                </div>
                <input type="text" name="nomeCliente" id="nomeCliente" value="<?php echo $_GET['nomeCliente']; ?>">
            </div>

            <div id="input-container">
                <div id="input-name">
                    <label for="contactoPrimeiroNome">Primeiro nome do contacto:</label>
                </div>
                <input type="text" name="contactoPrimeiroNome" id="contactoPrimeiroNome" value="<?php echo $_GET['contactoPrimeiroNome']; ?>">
            </div>

            <div id="input-container">
                <div id="input-name">
                    <label for="contactoUltimoNome">Último nome do contacto:</label>
                </div>
                <input type="text" name="contactoUltimoNome" id="contactoUltimoNome" value="<?php echo $_GET['contactoUltimoNome']; ?>">
            </div>

            <div id="input-container">
                <div id="input-name">
                    <label for="contactoEmail">E-mail do contacto:</label>
                </div>
                <input type="text" name="contactoEmail" id="contactoEmail" value="<?php echo $_GET['contactoEmail']; ?>">
            </div>
            <div id="input-container" class="mb-30">
                <div id="input-name">
                    <label for="contactoNumero">Número do contacto:</label>
                </div>
                <input type="number" name="contactoNumero" id="contactoNumero" value="<?php echo $_GET['contactoNumero']; ?>">
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
							if ($row['codigo'] == $_GET['concelhoId']){
								echo '<option value="'.$row['codigo'].'" selected>'.$row['nome'].'</value>';
							} else{
								echo '<option value="'.$row['codigo'].'">'.$row['nome'].'</value>';
							}
                        }
                    ?>
                </select>
				 <select id="contactoMoradaFreguesia" name="contactoMoradaFreguesia">
                    <option value="-1">--------</option>
                </select>
				<input type="number" maxlength="4" placeholder="e.g. 4900" id="contactoMoradaCodigoPostal" name="contactoMoradaCodigoPostal" value="<?php echo $_GET['codigoPostal']; ?>">
				<input type="number" maxlength="3" placeholder="e.g. 545" id="contactoMoradaCodigoPostalExtendido" name="contactoMoradaCodigoPostalExtendido" value="<?php echo $_GET['codigoPostalEx']; ?>">
				<input type="text"  placeholder="e.g. Rua das Oliveiras, Nº10" id="contactoMoradaRua" name="contactoMoradaRua" value="<?php echo $_GET['contactoMorada']; ?>">
				
				
            </div>
		
            <div id="input-container">
                <div id="input-name">
                    <label for="situacao">Seguimento:</label>
                </div>
                <?php
                    $sql = "SELECT situacao, descricao FROM seguimentos;";
                    $result = $conn->query($sql);

                ?>
                <select name="situacao" id="situacao">
                    <?php
                        while ($row = $result->fetch_assoc()){
                            if ($row['situacao'] == $_GET['situacao']){
                                echo '<option value="'.$row['situacao'].'" selected>'.$row['descricao'].'</option>';
                            } else{
                                echo '<option value="'.$row['situacao'].'">'.$row['descricao'].'</option>';
                            }

                        }


                    ?>
                </select>
            </div>

            <div id="input-container">
                <div id="input-name">
                    <label for="observacoes">Observações:</label>
                </div>
                <input type="text" name="observacoes" id="observacoes" value="<?php echo $_GET['observacoes']; ?>">
            </div>

            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

            <input type="submit" value="Alterar">
            <a href="crms.php"><button type="button" class="red">Voltar</button></a>
        </form>
    </div>
    <p class="red-color"><?php echo $error; ?></p>
</div>
</body>
</html>
