<?php
    session_start();
    include("conexao.php");
	include("conexao.php");

	$login = $_POST["login"];
	$senha = $_POST["pass"];
	
	$sql="SELECT * FROM users WHERE login='$login' AND senha='$senha'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$_SESSION["id_user"] = $row["id"];
		$_SESSION["login"] = $login;
        $_SESSION["nome"] = "ADMIN";
		header("Location: admin_cursos.php");
	}
	
	$sql="SELECT * FROM professores WHERE (cpf='$login' OR ra='$login') AND senha='$senha'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$_SESSION["id_user"] = $row["id"];
		$_SESSION["login"] = $login;
        $_SESSION["nome"] = $row["nome"];
		header("Location: cursos.php");
	}else{
		echo "Erro ao fazer login.";
	}

?>
