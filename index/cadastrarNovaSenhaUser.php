<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $senha = $_POST["senhaAnterior"];
    
    $sql = "UPDATE professor SET senha = '$senha' WHERE idprofessor = $id_user";

    if ($conn->query($sql) === TRUE) {
            header("Location: user.php");
        }else{
            echo "Erro ao atualizar senha";
        }
    
?>    