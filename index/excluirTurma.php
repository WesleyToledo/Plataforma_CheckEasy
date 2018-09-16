<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_turma = $_GET["idT"];

    $sql = "DELETE FROM turma WHERE idturma = $id_turma AND id_turma_professor=$id_user";

    if ($conn->query($sql) === TRUE) {
        header("Location: turmas.php?id=all");
    } else {
        echo "Erro ao deletar aluno: " . $conn->error;
    }
?>