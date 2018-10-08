<?php
    session_start();
    include("conexao.php");

	$email = $_POST["email"];
	$senha = $_POST["senha"];

    $nomeUser = $_POST["nome_user"];
    $instituicao = $_POST["instituicao"];
    $cidade = $_POST["cidade"];
    $cep = $_POST["cep"];


    $curriculo = $_POST["curriculo"];


    $primeiro_nome = $_POST["primeiroNome"];
    $sobrenome = $_POST["sobrenome"];
    $id = $_SESSION["id_user"];


  
    $sql = "UPDATE professor SET primeiro_nome = '$primeiro_nome',sobrenome = '$sobrenome',nome_user = '$nomeUser',email = '$email',instituicao = '$instituicao',cidade = '$cidade',cep = '$cep',curriculo = '$curriculo',senha = '$senha' WHERE idprofessor = '$id'";

    if ($conn->query($sql) === TRUE) {
        

        header("Location: home.php");
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    
?>
