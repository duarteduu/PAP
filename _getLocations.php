<?php
	
	require_once 'backend/conn.php';
	
	if (isset($_GET['codigo_distrito']) && isset($_GET['codigo_concelho'])){
		$codigo_distrito = $_GET['codigo_distrito'];
		$codigo_concelho = $_GET['codigo_concelho'];
		$sql = "SELECT f.codigo, f.nome FROM freguesias as f INNER JOIN distritos as d ON f.codigo_distrito = d.codigo INNER JOIN concelhos as c ON f.codigo_concelho = c.codigo WHERE f.codigo_distrito=$codigo_distrito and f.codigo_concelho=$codigo_concelho;";
		
		$result = $conn->query($sql);
		$rows = [];
		
		while ($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		
		echo json_encode($rows, JSON_UNESCAPED_UNICODE);
		
	} 
	
	