<?php
    session_start();
    include("conexao.php");

	$login = $_POST["login"];
	$senha = $_POST["pass"];
	
	$sql="SELECT * FROM users WHERE login='$login' AND senha='$senha'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$_SESSION["id_user"] = $row["idusers"];
		$_SESSION["login"] = $login;
        $_SESSION["nome"] = $row["nome_user"];
		header("Location: admin.php");
	}
	
	$sql="SELECT * FROM professor WHERE email='$login' AND senha='$senha'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$_SESSION["id_user"] = $row["idprofessor"];
		$_SESSION["email"] = $login;
        $_SESSION["nome"] = $row["primeiro_nome"];
		header("Location: home.php");
	}else{
		echo "Erro ao fazer login.";
	}
?>
