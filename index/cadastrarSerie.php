<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $nome = $_POST["nome_turma"];
    $cor = $_POST['cor'];

    $sql = "INSERT INTO serie(cor,icone,nome,id_serie_professor) VALUES('$cor','fa fa-graduation-cap','$nome','$id_user')";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php?id=all&c=blue400&s=ess");
        }else{
            header("Location: turmas.php?id=all&c=blue400&s=ese");
        }
    
?>