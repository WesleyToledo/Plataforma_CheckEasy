<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_avaliacao = $_GET["idA"];
    $valorA = $_GET["value"];
    $num_questoes = $_GET["nQ"];

     $gabarito = "";
     $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    
    $valor_alternativa = $valorA / $num_questoes;

    $count = 1;
    while(isset($_GET["$count"])){
        $certas[$count] = $_GET["$count"];
        $valor = $_GET["v$count"];
        $gabarito .= $count."/".$alternativas[$certas[$count] - 1]."/".$valor."/";
        $count++;
    }
    
    //tira a última barra
    $gabarito = substr($gabarito,0,strrpos($gabarito,"/"));
    echo $gabarito;

    $sql = "UPDATE avaliacao SET gabarito = '$gabarito' WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor=$id_user";
        
    if ($conn->query($sql) === TRUE) {
        header("Location: prova-edit.php?idA=$id_avaliacao&value=$valorA");
    }else{
        echo "Erro ao cadastrar aluno";
    }
    
?>