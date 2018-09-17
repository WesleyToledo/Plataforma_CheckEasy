<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_avaliacao = $_GET["idA"];

    $gabarito = "";
     $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    

    $count = 1;
    while(isset($_GET["$count"])){
        $certas[$count] = $_GET["$count"];
        $gabarito .= $count."/".$alternativas[$certas[$count] - 1]."/";
        $count++;
    }
    
    $gabarito = substr($gabarito,0,strrpos($gabarito,"/"));

    echo $gabarito;


    $sql = "UPDATE avaliacao SET gabarito = '$gabarito' WHERE idavaliacao = $id_avaliacao";
        
    if ($conn->query($sql) === TRUE) {
            header("Location: prova-edit.php?idA=$id_avaliacao");
        }else{
            echo "Erro ao cadastrar aluno";
        }
    
?>