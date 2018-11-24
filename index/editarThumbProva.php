<?php

    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_avaliacao = $_GET["idA"];


   if(isset($_FILES['thum_prova']))
   {
      date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      $ext = strtolower(substr($_FILES['thum_prova']['name'],strrpos($_FILES['thum_prova']['name'], "."))); //Pegando extensão do arquivo
      $new_name = date("Y.m.d-H.i.s").$ext; //Definindo um novo nome para o arquivo
      $dir = 'assets/img/img_provas/'; //Diretório para uploads
              
       $path = $dir.$new_name;
       if(move_uploaded_file($_FILES['thum_prova']['tmp_name'], $dir.$new_name)){
           
            $sql = "UPDATE avaliacao SET img = '$path' WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor = $id_user";
            if ($conn->query($sql) === TRUE) {
                    header("Location: provas.php?s=edfs");
                }else{
                    header("Location: provas.php?s=edfe");
                }
       }else{
               $erro = $_FILES["thum_prova"]["error"];
               header("Location: provas.php?s=edfe$erro");
           }
   
   }


?>
