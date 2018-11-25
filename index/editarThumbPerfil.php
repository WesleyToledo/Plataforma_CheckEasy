<?php

    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];


   if(isset($_FILES['thum_perfil']))
   {
      date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      $ext = strtolower(substr($_FILES['thum_perfil']['name'],strrpos($_FILES['thum_perfil']['name'], "."))); //Pegando extensão do arquivo
      $new_name = date("Y.m.d-H.i.s").$ext; //Definindo um novo nome para o arquivo
      $dir = 'assets/img/users/'; //Diretório para uploads
              
       $path = $dir.$new_name;
       if(move_uploaded_file($_FILES['thum_perfil']['tmp_name'], $dir.$new_name)){
            $sql = "UPDATE professor SET img='$path' WHERE idprofessor=$id_user";
            if ($conn->query($sql) === TRUE) {
                    header("Location: user.php?s=eds");
                }else{
                    header("Location: user.php?s=ede");
                }
       }else{
               $erro = $_FILES["thum_perfil"]["error"];
                echo $erro;
                header("Location: user.php?s=ede");
           }
   
   }


?>
