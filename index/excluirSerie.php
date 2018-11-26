<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_serie = $_GET['idS']; 

    $sql = "DELETE FROM serie WHERE idserie = $id_serie AND id_serie_professor=$id_user";

    if ($conn->query($sql) === TRUE) {
        echo "funcionou";
        //header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=eas");
    }else{
        
        $sql2 = "SELECT idturma FROM turma WHERE id_turma_serie = $id_serie AND id_turma_professor = $id_user";
        
        $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) {
                while($row = $result2->fetch_assoc()) {
                    $sql = "DELETE FROM correcoes WHERE id_correcoes_turma = {$row['idturma']} AND id_correcoes_professor = $id_user";
                    if ($conn->query($sql) === TRUE) {
                         $sql = "DELETE FROM aluno WHERE id_aluno_turma = {$row['idturma']} AND id_aluno_professor=$id_user";
                            if ($conn->query($sql) === TRUE) {
                                $sql = "DELETE FROM turma_prova WHERE id_turma_prova_turma = {$row['idturma']} AND id_turma_prova_professor=$id_user";
                                if ($conn->query($sql) === TRUE) {
                                    $sql = "DELETE FROM turma WHERE idturma = {$row['idturma']} AND id_turma_professor=$id_user";
                                    if ($conn->query($sql) === TRUE) {

                                        $sql = "DELETE FROM serie WHERE idserie = $id_serie AND id_serie_professor=$id_user";
                                        if ($conn->query($sql) === TRUE) {
                                            //echo "funcionou";
                                            header("Location: turmas.php?id=all&c=blue400&s=eees");
                                        }else{
                                            $conn->error;
                                             //header("Location: turmas.php?id=all&c=blue400&s=eeee");
                                        }
                                    } else {
                                        echo $conn->error;
                                         //header("Location: turmas.php?id=all&c=blue400&s=eeee");
                                    }
                                } else {
                                    echo $conn->error;
                                     //header("Location: turmas.php?id=all&c=blue400&s=eeee");
                                }
                            } else {
                                echo $conn->error;
                                 //header("Location: turmas.php?id=all&c=blue400&s=eeee"); 
                            }   
                }else{
                       echo $conn->error; 
                    }
                }
            }
         //header("Location: turmas.php?id=all&c=blue400&s=eeee"); 
    }

?>
