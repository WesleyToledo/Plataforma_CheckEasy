<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_serie = $_POST["serie"];
    $nome = $_POST["nomeTurma"];

    $sql = "INSERT INTO turma(id_turma_professor,id_turma_serie,nome) VALUES('$id_user','$id_serie','$nome')";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php");
        }else{
            echo "Erro ao cadastrar turma";
        }
    
?>