<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];

    $nome = $_POST["nome_prova"];
    $num_questoes = $_POST["num_questoes"];
    $num_alternativas = $_POST["num_alternativas"];
    $valor = $_POST["valor_total"];
    
    $gabarito = "";
    for($x=1;$x<=$num_questoes;$x++){
        $gabarito .= $x."/a/";
    }

    $sql = "INSERT INTO avaliacao(gabarito,quant_questoes, id_avaliacao_professor, quant_alternativas, valor,nome) VALUES('$gabarito',$num_questoes,$id_user,$num_alternativas,$valor,'$nome');";

    if ($conn->query($sql) === TRUE) {
            header("Location: provas.php");
        }else{
            echo "Erro ao cadastrar prova";
        }
    
?>