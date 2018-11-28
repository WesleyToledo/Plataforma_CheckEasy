<?php

    session_start();
    include("conexao.php");

    $id_user = $_SESSION["id_user"];
    $id_turma = $_GET['idT'];


//$dados = $_FILES['arquivo'];
//var_dump($dados);

if(!empty($_FILES['arquivo']['tmp_name'])){
    
    $arquivo = new domdocument();
    $arquivo->load($_FILES['arquivo']['tmp_name']);
    
    $linhas = $arquivo->getElementsByTagName("Row");
    
    $primeira_linha = true;
    
    foreach($linhas as $linha){
    
    if($primeira_linha == false){    
    $matricula = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
    echo "Matricula: $matricula <br>";
        
        $nome = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
    echo "Nome: $nome <br>";
        
        $sobrenome = substr($nome,0,strpos($nome," "));
    echo "Sobrenome: $sobrenome <br>";
    
    echo "<hr>";
        

        
        $result_usuario = "INSERT INTO  aluno (id_aluno_turma,id_aluno_professor,matricula, nome, sobrenome) VALUES ($id_turma,$id_user,'$matricula', '$nome', '$sobrenome')";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
    }
        $primeira_linha = false;
        
            if ($conn->query($sql) === TRUE) {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=edae");
    } else {
        header("Location: turmas.php?id=$id_turma&c={$_GET['c']}&s=edas");
    }
}
}

?>