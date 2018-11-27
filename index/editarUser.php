<?php
    session_start();
    include("conexao.php");
    
    $id_user = $_SESSION["id_user"];

	$email = $_POST["email"];

    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $nomeUser = $_POST["nome_user"];
    $instituicao = $_POST["instituicao"];
    $cidade = $_POST["cidade"];
    $cep = $_POST["cep"];
    $estado = $_POST["estado"];
    $curriculo = $_POST["curriculo"];

    $sql = "UPDATE professor SET primeiro_nome='$nome',sobrenome='$sobrenome',nome_user='$nomeUser',email='$email',instituicao='$instituicao',cidade='$cidade',cep='$cep',curriculo='$curriculo' WHERE idprofessor = $id_user";

    if ($conn->query($sql) === TRUE) {
            header("Location: user.php");
        }else{
            echo "Erro ao fazer edição.$conn->error";
        }
        
    
?>
