<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];;
    $id_turma = $_GET["idT"];

    $sql = "DELETE FROM correcoes WHERE id_correcoes_turma = $id_turma AND id_correcoes_professor=$id_user";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM aluno WHERE id_aluno_turma = $id_turma AND id_aluno_professor=$id_user";
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM turma_prova WHERE id_turma_prova_turma = $id_turma AND id_turma_prova_professor=$id_user";
            if ($conn->query($sql) === TRUE) {
                $sql = "DELETE FROM turma WHERE idturma = $id_turma AND id_turma_professor=$id_user";
                if ($conn->query($sql) === TRUE) {
                    echo "funcionou";
                    header("Location: turmas.php?id=all&c=blue400&s=es");
                } else {
                   header("Location: turmas.php?id=all&c=blue400&s=ee");
                }
            } else {
                header("Location: turmas.php?id=all&c=blue400&s=ee");
            }
        } else {
            header("Location: turmas.php?id=all&c=blue400&s=ee");
        }
    }else{
        header("Location: turmas.php?id=all&c=blue400&s=ee");
    }
?>
