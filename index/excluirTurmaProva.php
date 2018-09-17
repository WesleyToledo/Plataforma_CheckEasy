<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_turma = $_GET["idT"];
    $id_avaliacao = $_GET["idA"];

    $sql = "DELETE FROM turma_prova WHERE id_turma_prova_turma = $id_turma AND id_turma_prova_professor=$id_user";

    if ($conn->query($sql) === TRUE) {
        header("Location: prova-edit.php?idA=$id_avaliacao");
    } else {
        echo "Erro ao deletar turma: ".$conn->error;
    }
?>