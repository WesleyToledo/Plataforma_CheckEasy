<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_avaliacao = $_GET["idA"];

    $nome = $_POST["nome_prova"];
    $num_questoes = $_POST["num_questoes"];
    $num_alternativas = $_POST["num_alternativas"];
    $valor = $_POST["valor_total"];

    $sql = "UPDATE avaliacao SET nome = '$nome', quant_questoes = $num_questoes, quant_alternativas = $num_alternativas, valor = $valor  WHERE id_avaliacao_professor = $id_user AND idavaliacao = $id_avaliacao";

    if ($conn->query($sql) === TRUE) {
            header("Location: provas.php?es=s");
        }else{
            header("Location: provas.php?es=e");
        }
    
?>
