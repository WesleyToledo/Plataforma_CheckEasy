<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_turma = $_GET["idT"];
    $id_avaliacao = $_GET["idA"];

    $sql = "DELETE FROM turma_prova WHERE id_turma_prova_turma = $id_turma AND id_turma_prova_professor=$id_user AND id_turma_prova_avaliacao = $id_avaliacao";

    if ($conn->query($sql) === TRUE) {
        header("Location: prova-edit.php?idA=$id_avaliacao&value={$_GET['value']}&s=ees");
    } else {
        header("Location: prova-edit.php?idA=$id_avaliacao&value={$_GET['value']}&s=eee");
    }
?>