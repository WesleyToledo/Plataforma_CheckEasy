<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_avaliacao = $_GET["idA"];

    $sql = "DELETE FROM turma_prova WHERE id_turma_prova_avaliacao = $id_avaliacao AND id_turma_prova_professor = $id_user";

    if ($conn->query($sql) === TRUE) {
        
        $sql = "DELETE FROM avaliacao WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor = $id_user";

        if ($conn->query($sql) === TRUE) {
            header("Location: provas.php");
        } else {
            echo "Erro ao deletar prova: " . $conn->error;
        }
    } else {
        echo "Erro ao deletar prova: " . $conn->error;
    }
?>