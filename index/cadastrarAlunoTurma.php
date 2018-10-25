<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_turma = $_GET["idT"];

    $matricula = $_POST["matricula"];
    //$sobrenome = $_POST["sobrenome"];
    $nome = $_POST["nome_aluno"]." ";
         
        $sobrenome = substr($nome,strpos($nome," "),strlen($nome));
        $nome = substr($nome,0,strpos($nome," "));

    $sql = "INSERT INTO aluno(id_aluno_turma,id_aluno_professor,matricula,nome,sobrenome) VALUES($id_turma,$id_user,'$matricula','$nome','$sobrenome')";

    if ($conn->query($sql) === TRUE) {
            header("Location: turmas.php?id=$id_turma&c={$_GET['c']}");
        }else{
            echo "Erro ao cadastrar aluno";
        }
    
?>