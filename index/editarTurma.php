<?php
    session_start();
    include("conexao.php");

    $id_turma = $_GET["idT"];
    $id_user = $_SESSION["id_user"];
    $id_serie = $_POST["serie"];
    $nome = $_POST["nomeTurma"];

    $sql = "UPDATE turma SET nome = '$nome', id_turma_serie = $id_serie WHERE idturma = $id_turma AND id_turma_professor = $id_user";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php?id=$id_turma");
        }else{
            echo "Erro ao cadastrar turma";
        }
    
?>