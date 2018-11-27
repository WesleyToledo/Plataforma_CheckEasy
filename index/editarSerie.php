<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_serie = $_GET["idS"];
    $nome = $_POST['nome_serie'];

    $sql = "UPDATE serie SET nome = '$nome' WHERE idserie = $id_serie AND id_serie_professor=$id_user";

    if ($conn->query($sql) === TRUE) {
           header("Location: turmas.php?id=all&c=blue400&s=edss");  
    }else{
           header("Location: turmas.php?id=all&c=blue400&s=edse");
        }
    
?>