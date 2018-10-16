<?php
    //include("general_functions.php");
header("Content-Type: text/html; charset=ISO-8859-1");
    include("conexao.php");

    $action = $_GET["a"];

    if($action == "VEmail"){
         $sql = "SELECT email FROM professor
                WHERE email = '{$_POST['email']}'";//monto a query

        $result = $conn->query($sql);

        if($result-> num_rows > 0 ){//se retornar algum resultado
            echo "usado";  
        }
        else{
            echo "";
        }
    }
    
    if($action == "VNomeUser"){
        
         $sql = "SELECT nome_user FROM professor
                WHERE nome_user = '{$_POST['nomeUser']}'";//monto a query

        $result = $conn->query($sql);

        if($result-> num_rows > 0 ){//se retornar algum resultado
            echo "usado";  
        }
        else{
            echo "";
        }
    }

?>
