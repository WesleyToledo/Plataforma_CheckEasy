<?php
    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $sql = "SELECT idturma,nome FROM turma WHERE id_turma_professor = $id_user";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //se coincidir o nome da turma com o checkbox, cadastrar prova com os valores 
            if(isset($_POST["checkbox".$row['nome']])){
               
                 $sql = "INSERT INTO turma_prova(id_turma_prova_professor,id_turma_prova_turma, id_turma_prova_avaliacao) VALUES($id_user,".$row['idturma'].",".$_GET['idA'].")";
                 
                 if ($conn->query($sql) === TRUE) {
                    header("Location: prova-edit.php?idA=".$_GET["idA"]);
                }else{
                    echo "Erro ao cadastrar turma";
                }
            }
        }
    }else{
        
    }
?>
