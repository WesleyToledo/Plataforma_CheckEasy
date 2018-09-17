<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];

    $nome = $_POST["nome_prova"];
    $num_questoes = $_POST["num_questoes"];
    $num_alternativas = $_POST["num_alternativas"];
    $valor = $_POST["valor_total"];
    
    $gabarito = "";
    $alfabeto = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

    for($x=1;$x<=$num_questoes;$x++){
        $gabarito .= $x.$alfabeto[$x-1]."/";
    }

    $sql = "INSERT INTO avaliacao(gabarito,quant_questoes, id_avaliacao_professor, quant_alternativas, valor,nome) VALUES('$gabarito',$num_questoes,$id_user,$num_alternativas,$valor,'$nome');";

    if ($conn->query($sql) === TRUE) {
            header("Location: provas.php");
        }else{
            echo "Erro ao cadastrar prova";
        }
    
?>