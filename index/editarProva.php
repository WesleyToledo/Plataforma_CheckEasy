<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_avaliacao = $_GET["idA"];

    $nome = $_POST["nome_prova"];
    $num_questoes = $_POST["num_questoes"];
    $num_alternativas = $_POST["num_alternativas"];
    $valor = $_POST["valor_total"];


    $sql = "SELECT gabarito FROM avaliacao WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor = $id_user";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    $gabaritoOld = $row['gabarito'];

     $gabaritoNew = "";
     $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    
    $valor_alternativa = $valor / $num_questoes;

    $count = 0;
    while($gabaritoOld != ""){      
        $barra = strpos($gabaritoOld,"/");
        $tamanho = strlen($gabaritoOld);
        if(strpos($gabaritoOld,"/")){
            $gabarito_array[$count] = substr($gabaritoOld,0,$barra);
            $gabaritoOld = substr($gabaritoOld, $barra + 1, $tamanho);
            $count++;
        }else{
            $gabarito_array[$count] = substr($gabaritoOld, 0, $tamanho);
            $gabaritoOld = "";
        }
    }

    $count = 0;
    for($x=0;$x<sizeof($gabarito_array);$x++){
        if($x%3 == 0){
            $respostas[$count] = $gabarito_array[$x + 1];
            //echo "-".$respostas[$count];
            $count++;
        }
    }

    for($x = 1;$x<=$num_questoes;$x++){
        $gabaritoNew .= $x."/".$respostas[$x-1]."/".$valor_alternativa."/";
        $count++;
    }

    $sql = "UPDATE avaliacao SET nome = '$nome', quant_questoes = $num_questoes, quant_alternativas = $num_alternativas, valor = $valor,gabarito = '$gabaritoNew'  WHERE id_avaliacao_professor = $id_user AND idavaliacao = $id_avaliacao";

    if ($conn->query($sql) === TRUE) {
            header("Location: provas.php?s=eds");
        }else{
            header("Location: provas.php?s=ede");
        }
?>
