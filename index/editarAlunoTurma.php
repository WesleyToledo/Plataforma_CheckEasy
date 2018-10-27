<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_aluno = $_GET["id"];
    $id_turma = $_GET["idT"];

    $matricula = $_POST["matricula"];
    $nome= $_POST["nome_aluno"];

    $sobrenome = substr($nome,strpos($nome," "),strlen($nome));
    $nome = substr($nome,0,strpos($nome," "));

    $sql = "UPDATE aluno SET matricula='$matricula', nome = '$nome', sobrenome = '$sobrenome' WHERE idaluno = $id_aluno AND id_aluno_professor=$id_user AND id_aluno_turma = $id_turma";

    if ($conn->query($sql) === TRUE) {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=edas");
    } else {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=edae");
    }
?>