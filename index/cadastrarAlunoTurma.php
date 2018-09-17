<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_turma = $_GET["idT"];

    $matricula = $_POST["matricula"];
    $sobrenome = $_POST["sobrenome"];
    $nome = $_POST["nome_aluno"];

    $sql = "INSERT INTO aluno(id_aluno_turma,id_aluno_professor,matricula,nome,sobrenome) VALUES($id_turma,$id_user,'$matricula','$nome','$sobrenome')";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php?id=$id_turma");
        }else{
            echo "Erro ao cadastrar aluno";
        }
    
?>