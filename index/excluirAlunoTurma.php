<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_aluno = $_GET["id"];
    $id_turma = $_GET["idT"];

    $sql = "DELETE FROM aluno WHERE idaluno = $id_aluno AND id_aluno_professor=$id_user AND id_aluno_turma = $id_turma";

    if ($conn->query($sql) === TRUE) {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=eas");
    } else {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=eae");
    }
?>