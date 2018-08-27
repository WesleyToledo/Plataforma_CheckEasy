<?php
	$servername = "localhost";
	$username = "root";
	$password = "vertrigo";
	$dbname = "db_checkeasy";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(mysqli_connect_error()){
		die("Erro na conexão com o banco de dados.");
	}
?>
	