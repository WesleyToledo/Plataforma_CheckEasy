<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_serie = $_POST["serie"];
    $nome = $_POST["nomeTurma"];

    $sql = "INSERT INTO turma(id_turma_professor,id_turma_serie,nome) VALUES('$id_user','$id_serie','$nome')";

    if ($conn->query($sql) === TRUE) {
            $sql = "SELECT cor FROM serie WHERE idserie = $id_serie AND id_serie_professor=$id_user";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        
            header("Location: turmas.php?id=all&c={$row['cor']}&s=cs");
        }else{
            header("Location: turmas.php?id=all&c={$row['cor']}&s=ce");
        }
    
?>