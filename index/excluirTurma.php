<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_turma = $_GET["idT"];

    $sql = "DELETE FROM aluno WHERE id_aluno_turma = $id_turma AND id_aluno_professor=$id_user";

    if ($conn->query($sql) === TRUE) {
       
        $sql = "DELETE FROM turma_prova WHERE id_turma_prova_turma = $id_turma AND id_turma_prova_professor=$id_user";

        if ($conn->query($sql) === TRUE) {
            
            $sql = "DELETE FROM turma WHERE idturma = $id_turma AND id_turma_professor=$id_user";

            if ($conn->query($sql) === TRUE) {
                header("Location: turmas.php?id=all&s=s");
            } else {
                header("Location: turmas.php?id=all&s=e");
            }
        } else {
            header("Location: turmas.php?id=all&s=e");
        }
        
    } else {
        header("Location: turmas.php?id=all&s=e");
    }
?>
