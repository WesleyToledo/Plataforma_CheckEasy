<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $nome = $_POST["nome_turma"];

    $sql = "INSERT INTO serie(cor,icone,nome,id_serie_professor) VALUES('purple400','fa fa-graduation-cap','$nome','$id_user')";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php");
        }else{
            echo "Erro ao cadastrar serie";
        }
    
?>