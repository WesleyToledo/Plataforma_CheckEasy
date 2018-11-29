<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>CheckEasy</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0' name='viewport' />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />

    <!-- Data-color-pallete-->
    <link rel="stylesheet" href="assets/css/data-background-color.css">
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel='stylesheet'>
</head>
<?php session_start();
    
    include("general_functions.php");
    include("conexao.php");
    
	if(!isset($_SESSION["login"])){
		header("Location: login.html");
	}
    
    $id_user = $_SESSION["id_user"];
    $nome = $_SESSION["nome"];
    

    function listTurmas(){
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        include("conexao.php");
        $sql = "SELECT t.idturma AS 'id_turma', t.nome AS 'nome_turma', s.cor AS 'cor' , s.icone AS 'icone', s.nome AS 'nome_serie' FROM turma AS t INNER JOIN serie AS s WHERE t.id_turma_serie = s.idserie AND t.id_turma_professor = $id_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $turma_nome = $row["nome_turma"];
                $cor = $row["cor"];
                $icone = $row["icone"];
                $serie_nome = $row["nome_serie"];
                $id_turma = $row["id_turma"];
                
                $selecionado = "";
                if($_GET['id'] == "$id_turma"){
                    $selecionado = "box-shadow: 0px -2px 19px 4px rgba(0, 0, 0, 0.19);";
                }
                
                $html .= "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                            <div class='card card-stats' style='$selecionado'>
                                <a href='turmas.php?id=$id_turma&c=$cor' style='color: inherit;'>
                                    <div class='card-header' data-background-color='$cor'>
                                        <i class='$icone'></i>
                                    </div>
                                    <div class='card-content card-turmas' style='overflow:auto'>
                                        <p class='category'>&nbsp;</p>
                                        <h3 class='title' style='overflow:initial; width:100%;text-align:center; height: 50px' title='$turma_nome'>$turma_nome
                                        </h3>
                                    </div>
                                </a>
                                <div class='card-footer'>
                                    <div class='stats'>
                                        <i class='material-icons' style='color:#4e4e4e'>group</i>
                                        <a href='#' style='color: inherit;font-weight: 500;color: #4e4e4e'>$serie_nome</a>
                                    </div>
                                    <div class='stats' style='float: right;'>
                                       <a data-toggle='modal' data-target='#excluirTurma$id_turma'>   
                                            <i class='material-icons' style='color: #ef5350; font-weight: 800;cursor: pointer;'>clear</i>
                                       </a>
                                    </div>
                                    <div class='stats' style='float: right'>
                                       <a data-toggle='modal' data-target='#editarTurma$id_turma'>   
                                            <i class='material-icons' style='color: #404040; font-weight: 800;cursor: pointer;padding-right:5px;'>create</i>
                                       </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        } else {
            echo "<p style='margin: 15px'>Nenhuma Turma Cadastrada</p>";
        }
        return $html;
    }
    
    function setSeries(){
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $html = "";
        
        include("conexao.php");
        
        $sql = "SELECT idserie, nome FROM serie WHERE id_serie_professor = $id_user";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                $id_serie = $row["idserie"];
                $nome_serie = $row["nome"];
                
                $html .= " <option value='$id_serie'>$nome_serie</option>";
            }
        } else {
        }
        
        return $html;
        
    }
    
    function setAlunosTurma(){
        include("conexao.php");
        $id_turma = $_GET["id"];
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $html = '';
        
        if($id_turma == "all"){
            $html = '<tr>
                        <td>Nenhuma Turma Selecionada</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>';
        }else{
            $sql = "SELECT a.idaluno AS 'idaluno', a.nome AS 'nome', a.matricula AS 'matricula',a.sobrenome AS 'sobrenome' FROM aluno AS a INNER JOIN turma as t where a.id_aluno_turma = $id_turma and t.idturma = $id_turma and t.id_turma_professor = $id_user ORDER BY nome ASC";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_aluno = $row["idaluno"];
                    $matricula = $row["matricula"];
                    $nome = $row["nome"];
                    $sobrenome = $row["sobrenome"];

                    $html .= "<tr>
                                <td>$matricula</td>
                                <td>$nome</td>
                                <td>$sobrenome</td>
                                <td>
                                    <div style='display: flex; flex-direction: row; justify-content: space-around;align-items: center;'>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0; background-color: transparent;' data-toggle='modal' data-target='#editarAluno$id_aluno'>
                                            <i class='material-icons' style='font-size: 20px; color: #404040'>create</i>
                                        </button>
                                        </div>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0;background-color: transparent;' data-toggle='modal' data-target='#excluirAluno$id_aluno'>
                                            <i class='material-icons' style='font-size: 20px;color: #404040'>clear</i>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                }
            } else {
                echo "<tr>
                        <td>Nenhum Aluno Cadastrado</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>";
            }
        }
        return $html;
    }
    
    function setTitleAlunosTurma(){
        include("conexao.php");
        $id_turma = $_GET["id"];
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $html = "";
        
        if($id_turma != 'all'){
        $sql = "SELECT t.nome as 'turma_nome', s.nome as 'nome_serie', idturma FROM turma AS t INNER JOIN serie AS s ON t.idturma = $id_turma AND t.id_turma_serie = s.idserie AND t.id_turma_professor = $id_user";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $html = "<div style='width: 95%;'>
                        <h3 class='title' style='font-weight: 600;'>".$row["turma_nome"]."</h3>
                        <p class='category' style='font-weight: 500;'>".$row["nome_serie"]."</p>
                    </div>
                    <div style='float: right;display:flex;flex-direction:row;margin:'>
                        <button type='button' class='btn' style='margin: 0; background-color: transparent;margin:10px' data-toggle='modal' data-target='#inserirAluno'>
                        <i class='material-icons' style='font-size: 20px; color: #fff'>archive</i>
                        </button>
                        <button type='button' class='btn' style='margin: 0; background-color: transparent;margin:10px' data-toggle='modal' data-target='#cadastrarAluno'>
                        <i class='material-icons' style='font-size: 20px; color: #fff'>add_circle_outline</i>
                        </button>
                    </div>";
        }else{
            $html = "<div style='width: 95%;'>
                        <h3 class='title' style='font-weight: 600;'>Turma</h3>
                        <p class='category' style='font-weight: 500;'>Série</p>
                    </div>";
        }
    }else{
            $html = $html = "<div style='width: 95%;'>
                        <h3 class='title' style='font-weight: 600;'>Turma</h3>
                        <p class='category' style='font-weight: 500;'>Série</p>
                    </div>";
        }
        return $html;
        
        
    }
    
    function geraEditAluno(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idaluno,id_aluno_turma,matricula,nome,sobrenome FROM aluno WHERE id_aluno_professor = $id_user";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_aluno = $row["idaluno"];
                    $matricula = $row["matricula"];
                    $nome = $row["nome"];
                    $sobrenome = $row["sobrenome"];
                    $id_turma = $row["id_aluno_turma"];
                    
                    $html .= "<div class='modal fade' id='editarAluno$id_aluno' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                                    <h3 class='modal-title mx-auto' id='lineModalLabel'>Editar Aluno</h3>
                                </div>
                                <div class='modal-body'>
                                    <!-- content goes here -->
                                    <form action='editarAlunoTurma.php?id=$id_aluno&idT=$id_turma&c={$_GET['c']}' method='post'>
                                        <div class='form-group'>
                                            <label>Matrícula</label>
                                            <input type='text' class='form-control' name='matricula' value='$matricula'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Nome</label>
                                            <input type='text' class='form-control' name='nome_aluno' value='$nome $sobrenome'>
                                        </div>
                                        <div class='form-group' style='display: flex;flex-direction: column;'>

                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                            <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Salvar Informações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "";
            }
        return $html;
    }
    
    function geraEditTurma(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idturma,nome,id_turma_serie FROM turma WHERE id_turma_professor = $id_user";
        
        //$sql = "SELECT a.idaluno,a.id_aluno_turma,a.matricula,a.nome,a.sobrenome,t.id_turma_serie,s.cor FROM aluno AS a INNER JOIN turma AS t INNER JOIN serie AS s ON a.id_aluno_turma = t.idturma AND id_aluno_professor = $id_user AND id_aluno_turma = {$_GET['idT']} AND t.id_turma_serie = s.idserie";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $id_turma = $row["idturma"];
                    $nome = $row["nome"];
                    $id_serie = $row["id_turma_serie"];
                    $html .= "
                            <div class='modal fade' id='editarTurma$id_turma' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                                            <h3 class='modal-title mx-auto' id='lineModalLabel'>Editar Turma</h3>
                                        </div>
                                        <div class='modal-body'>
                                        <!-- content goes here -->
                                        <form action='editarTurma.php?idT=$id_turma' method='post'>
                                            <div class='form-group'>
                                                <label >Nome da Turma</label>
                                                <input type='text' name='nomeTurma' class='form-control' name='nome_turma' value='$nome' required>
                                            </div>
                                            <div class='form-group' style='display: flex;flex-direction: column;'>
                                                <label>Série</label>
                                                <div style='display: flex; flex-direction: row;justify-content: flex-start'>
                                                    <select id='turma' name='serie' class='custom-select' style='margin-top: 13px;margin-bottom: 13px;border: 0.5px #ccc solid; border-radius: 5px;width: 100%;'>    ".setSeries()."     
                                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                                <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Editar Turma</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                    ";
                }
            } else {
            }
        return $html;
    }
  
    
    
                                               /* onclick="demo.showNotification('top','right','Turma Cadastrada')" */

    
    function geraExcluirAluno(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idaluno,id_aluno_turma,matricula,nome,sobrenome FROM aluno WHERE id_aluno_professor = $id_user AND id_aluno_turma = {$_GET['id']}";
        if($_GET['id'] != "all"){
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_aluno = $row["idaluno"];
                    $matricula = $row["matricula"];
                    $nome = $row["nome"];
                    $sobrenome = $row["sobrenome"];
                    $id_turma = $row["id_aluno_turma"];
                    
                    $html .= "<div class='modal fade' id='excluirAluno$id_aluno' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Excluir Aluno</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                Tem certeza que deseja excluir o aluno $nome $sobrenome ?
                            </div>
                            <div class='modal-footer'>
                            <form action='excluirAlunoTurma.php?id=$id_aluno&idT=$id_turma&c={$_GET['c']}' method='post'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Excluir</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
            } else {
            }
        }
        return $html;
    }
    
    function geraExcluirTurma(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idturma,nome FROM turma WHERE id_turma_professor = $id_user";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_turma = $row["idturma"];
                    $nome = $row["nome"];
                    
                    $html .= "<div class='modal fade' id='excluirTurma$id_turma' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Excluir Turma</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                Tem certeza que deseja excluir a turma $nome ?
                            </div>
                            <div class='modal-footer'>
                            <form action='excluirTurma.php?idT=$id_turma' method='post'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Excluir</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
            } else {
            }
        return $html;
    }
    
    function setSeriesTable(){
        
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT nome,idserie FROM serie WHERE id_serie_professor = $id_user ";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_serie = $row["idserie"];
                    $nome = $row["nome"];
                    
                    $html .= "<tr>
                                <td>$nome</td>
                                <td>
                                    <div style='display: flex; flex-direction: row; justify-content: space-around;align-items: center;'>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0; background-color: transparent;' data-toggle='modal' data-target='#editarSerie$id_serie'>
                                            <i class='material-icons' style='font-size: 20px; color: #404040'>create</i>
                                            </button>
                                        </div>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0;background-color: transparent;' data-toggle='modal' data-target='#excluirSerie$id_serie'>
                                            <i class='material-icons' style='font-size: 20px;color: #404040'>clear</i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                            }
            } else {
                $html = "<tr>
                                <td>Nenhuma Série Encontrada</td>
                                <td>
                                    <div style='display: flex; flex-direction: row; justify-content: space-around;align-items: center;'>
                                        
                                    </div>
                                </td>
                            </tr>";
            }
        return $html;
    }
    
    function geraEditSerie(){
        
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT nome,idserie FROM serie WHERE id_serie_professor = $id_user ";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_serie = $row["idserie"];
                    $nome = $row["nome"];
                    
                    $html .= "<div class='modal fade' id='editarSerie$id_serie' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true' style=''>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                                        <h3 class='modal-title mx-auto' id='lineModalLabel'>Editar Série</h3>
                                    </div>
                                    <div class='modal-body'>
                                        <!-- content goes here -->
                                        <form action='editarSerie.php?idS=$id_serie' method='post'>
                                            <div class='form-group'>
                                                <label for='exampleInputEmail1'>Nome da Série</label>
                                                <input type='text' class='form-control' name='nome_serie' value='$nome'>

                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                                <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Salvar Informações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                            }
            } else {
                $html = "";
                            }
            
        return $html;
        
    }
    
    function geraExcluirSerie(){
        
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT nome,idserie FROM serie WHERE id_serie_professor = $id_user ";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_serie = $row["idserie"];
                    $nome = $row["nome"];
                    
                    $html .= "<div class='modal fade' id='excluirSerie$id_serie' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Excluir Série</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                Tem certeza que deseja excluir a série <strong>'$nome'</strong> e todas a turmas vinculadas a ela?
                            </div>
                            <div class='modal-footer'>
                            <form action='excluirSerie.php?idS=$id_serie' method='post'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd);'>Excluir</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
            } else {
                $html = "";
                            }
            
        return $html;
        
    }
?>

<style>
    .cores {
        position: relative;
        width: 30%;
    }

    .cores input[name="seleciona-cor"] {
        display: none;
    }

    .cores label[for="seleciona-cor"] {
        background-color: #ddd;
        box-sizing: border-box;
        position: absolute;
        left: calc(100% - 20px);
        height: 30px;
        width: 30px;
    }

    .cores label[for="seleciona-cor"]::after {
        display: block;
        content: "\1a06";
        font-size: 17px;
        padding-left: 9px;
        margin-top: 1px;
        position: relative;
    }

    .cores label[for="seleciona-cor"]:checked::after {
        content: "\1a08";
    }

    .cores input[name="seleciona-cor"]:checked~.cor label {
        display: block;
    }


    input[name="cor"] {
        display: none;
    }

    input[name="cor"]:checked+label::after {
        color: #fff;
        padding: 0px 5px;
    }

    input[name="cor"]:checked+label {
        display: block;
    }

    label[for^="cor"] {
        display: none;
        height: 30px;
        border-radius: 5px;
        width: calc(100% - 20px);
    }

</style>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="index.html" class="simple-text">
                    CheckEasy
                </a>
            </div>

            <?php echo setSidebar_wrapper('turmas'); ?>

        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Turmas</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            <?php echo userDropDown(); ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="col-xs-12 col-sm-8 d-flex flex-row bd-highlight mb-3">
                                <button type="button" class="btn " style="justify-content: center;align-items: center;display: flex;flex-direction: row;background:linear-gradient(45deg, #1de099, #1dc8cd)" data-toggle="modal" data-target="#cadastrarTurma">
                                    <i class="material-icons" style="font-size: 27px;">add_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp;Cadastrar turma
                                </button>
                            </li>
                        </ul>
                    </div>

                    <?php  echo listTurmas(); ?>
                </div>

                <div class="row">
                    <?php
                        if($_GET['id'] != "all"){ 
                            echo "<div class='col-md-12'>
                            <div class='card'>
                                <div class='card-header' style='text-align:justify;display:flex; align-items: center; background-color:#' data-background-color='{$_GET["c"]}'>";
                                    echo setTitleAlunosTurma();
                                echo "</div>
                                <div class='card-content table-responsive'>
                                    <table class='table'>
                                        <thead class='text-success' style='color: #666;font-weight: 800;'>
                                            <th style='font-weight: 550;'>Matrícula</th>
                                            <th style='font-weight: 550;'>Nome</th>
                                            <th style='font-weight: 550;'>Sobrenome</th>
                                            <th style='font-weight: 550;'>
                                                <center>
                                                    Ações
                                                </center>
                                            </th>
                                        </thead>
                                        <tbody>";
                                            echo setAlunosTurma();
                                        echo "
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
";
                        }
                        
                        ?>

                </div>


            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())

                    </script>
                    <a href="#" class="text-info">CheckEasy</a>, a plataforma online dedicada aos professores
                </p>
            </div>
        </footer>
    </div>

    <!----- MODAL AREA ----->


    <!----- CRIA TURMA ----->
    <div class="modal fade" id="cadastrarTurma" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title mx-auto" id="lineModalLabel">Cadastrar Turma</h3>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form action="cadastrarTurma.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome da Turma</label>
                            <input type="text" name="nomeTurma" class="form-control" name="nome_turma" placeholder="" required>
                        </div>
                        <div class="form-group" style="display: flex;flex-direction: column;">
                            <label for="exampleInputEmail1">Série</label>
                            <div style="display: flex; flex-direction: row;justify-content: flex-start">
                                <select id="turma" name="serie" class="custom-select" style="margin-top: 13px;margin-bottom: 13px;border: 0.5px #ccc solid; border-radius: 5px;width: 70%;">
                                 
                                 <?php  echo setSeries();  ?>
                                </select>
                                <div style="display: flex;flex-direction: row; ustify-content: center; align-items: center; width: 30%">

                                    <button type="button" class="btn" style="justify-content: center;align-items: center;display: flex;flex-direction: row;background: linear-gradient(45deg, #1de099, #1dc8cd);margin:10px;width: 40%;" data-toggle="modal" data-target="#criaSerie">
                                    <i class="material-icons" style="font-size: 20px;">add_circle_outline</i>
                                </button>

                                    <button type="button" class="btn" style="justify-content: center;align-items: center;display: flex;flex-direction: row;background: linear-gradient(45deg, #1de099, #1dc8cd);width: 40%;" data-toggle="modal" data-target="#listSerie">
                                    <i class="material-icons" style="font-size: 20px;">assignment</i>
                                   
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" style="background: linear-gradient(45deg, #1de099, #1dc8cd);">Cadastrar Turma</button>

                            <!-- onclick="demo.showNotification('top','right','Turma Cadastrada')" -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----- CRIA SÉRIE ----->
    <div class="modal fade" id="criaSerie" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title mx-auto" id="lineModalLabel">Criar Série</h3>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form action="cadastrarSerie.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome da Série</label>
                            <input type="text" class="form-control" name="nome_turma" placeholder="">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Selecione a Cor</label>
                            <div class="cores">

                                <label for="seleciona-cor"></label>
                                <input id="seleciona-cor" type="checkbox" name="seleciona-cor" />

                                <div class="cor">
                                    <input id="cor1" type="radio" name="cor" value="red400" />
                                    <label for="cor1" style="background :linear-gradient(45deg, #FF5252, #D32F2F)"></label>
                                </div>
                                <div class="cor">
                                    <input id="cor2" type="radio" name="cor" value="purple400" />
                                    <label for="cor2" style="background :linear-gradient(45deg, #E040FB, #6A1B9A);"></label>
                                </div>
                                <div class="cor">
                                    <input id="cor3" type="radio" name="cor" value="blue4002" checked />
                                    <label for="cor3" style="background :linear-gradient(45deg, #40C4FF, #0277BD);"></label>
                                </div>
                                <div class="cor">
                                    <input id="cor4" type="radio" name="cor" value="green400" />
                                    <label for="cor4" style="background :linear-gradient(45deg, #66bb6a, #2E7D32);"></label>
                                </div>
                                <div class="cor">
                                    <input id="cor5" type="radio" name="cor" value="orange400" />
                                    <label for="cor5" style="background :linear-gradient(45deg, #FFAB40, #EF6C00);"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" style="background: linear-gradient(45deg, #1de099, #1dc8cd);">Salvar Informações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="listSerie" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title mx-auto" id="lineModalLabel">Séries</h3>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60%;">Nome</th>
                                <th scope="col">
                                    <center>Ações</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo setSeriesTable();  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
        echo geraEditAluno();
        echo geraEditTurma();
        echo geraExcluirAluno();
        echo geraExcluirTurma();
        echo geraEditSerie();
        echo geraExcluirSerie();
    ?>

        <div class='modal fade' id='cadastrarAluno' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                        <h3 class='modal-title mx-auto' id='lineModalLabel'>Cadastrar Aluno</h3>
                    </div>
                    <div class='modal-body'>
                        <!-- content goes here -->
                        <form action='cadastrarAlunoTurma.php?idT=<?php echo $_GET['id']."&c={$_GET['c']}"; ?>' method='post'>
                            <div class='form-group'>
                                <label>Matrícula</label>
                                <input type='text' class='form-control' name='matricula' value=''>
                            </div>
                            <div class='form-group'>
                                <label>Nome</label>
                                <input type='text' class='form-control' name='nome_aluno' value=''>
                            </div>

                            <div class='form-group' style='display: flex;flex-direction: column;'>

                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn' style="background: linear-gradient(45deg, #1de099, #1dc8cd);">Salvar Informações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='modal fade' id='inserirAluno' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'></span><span class='sr-only'>Close</span></button>
                            <h3 class='modal-title mx-auto' id='lineModalLabel'>Inserir Alunos</h3>
                        </div>
                        <div class='modal-body'>
                            <form action='processa_planilha.php?idT=<?php echo $_GET['id']."&c=".$_GET['c']; ?>' method='post' enctype='multipart/form-data'>
                                <div class='input-group mb-3'>
                                  <div class='input-group-prepend'>
                                    <span class='input-group-text'>Selecione o arquivo</span>
                                  </div>
                                  <div class='custom-file' style='margin: 15px 0 15px 0;'>
                                    <input type='file' class='custom-file-input' name='arquivo'>
                                  </div>
                                  <div class='input-group-prepend' style="display:flex;flex-direction:row;align-items: center;justify-content:flex-start"> 
                                    <span class='input-group-text'>Baixe o Template</span>
                                    <a href="assets/importByExcell/modelo.zip" target="_blank">
                                    <i class='material-icons' style='color:#4e4e4e;margin: 15px'>cloud_download</i>
                                    </a>
                                  </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                    <button type='submit' class='btn' style='background: linear-gradient(45deg, #1de099, #1dc8cd)' value="Enviar">Inserir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</body>
<script type="text/javascript">
    $('#turma').on('change', function() {
        if ($(this).val() == "1") {
            $('#criaSerie').modal('show');
        }
    });

</script>
<!--   Core JS Files   -->
<script src="assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!--  Google Maps Plugin    -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!-- Material Dashboard javascript methods -->
<script src="assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
                var vars = [],
                    hash
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    //alert(hash[1])
                    if (hash[0] === "s") {

                        switch (hash[1]) {
                            //cadastrar turma
                            case 'cs':
                                demo.showNotification('top', 'right', 'Turma Cadastrada', 'success', 'group')
                                break
                            case 'ce':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Cadastrar Turma', 'danger', 'group')
                                break
                                //excluir turma
                            case 'es':
                                demo.showNotification('top', 'right', 'Turma Excluída', 'success', 'group')
                                break
                            case 'ee':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Excluir Turma', 'danger', 'group')
                                break
                                ///editar turma
                            case 'eds':
                                demo.showNotification('top', 'right', 'Turma Editada', 'success', 'group')
                                break
                            case 'ede':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Editar Turma', 'danger', 'group')
                                break
                                //excluir aluno
                            case 'eas':
                                demo.showNotification('top', 'right', 'Aluno Excluído', 'success', 'group')
                                break
                            case 'eae':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Excluir Aluno', 'danger', 'group')
                                break
                                //editar aluno
                            case 'edas':
                                demo.showNotification('top', 'right', 'Aluno Editado', 'success', 'group')
                                break
                            case 'edae':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Editar Aluno', 'danger', 'group')
                                break
                                //Cadastrar serie
                            case 'edas':
                                demo.showNotification('top', 'right', 'Série Cadastrada', 'success', 'group')
                                break
                            case 'ese':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Cadastrar Série', 'danger', 'group')
                                break
                                //editar serie
                            case 'edss':
                                demo.showNotification('top', 'right', 'Série Editada', 'success', 'group')
                                break
                            case 'edse':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Editar Série', 'danger', 'group')
                                break
                                //excluir serie
                            case 'eees':
                                demo.showNotification('top', 'right', 'Série Excluída', 'success', 'group')
                                break
                            case 'eeee':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Editar Série', 'danger', 'group')
                                break
                                //inserir aluno
                            case 'iats':
                                demo.showNotification('top', 'right', 'Alunos Inseridos', 'success', 'group')
                                break
                            case 'iate':
                                demo.showNotification('top', 'right', '<strong> Erro </strong> ao Inserir Alunos', 'danger', 'group')
                                break
                        }
                    }
                }

                var url = window.location.href
                var newUrl = url.substring(0, (url.lastIndexOf("s=") - 1))
                history.pushState('teste', 'CheckEasy', newUrl)

                var cores = document.querySelectorAll("label[for^='cor']");
            
                for (i = 0; i < cores.length; i++) {
                    cores[i].addEventListener("click", function() {
                        document.querySelector("input[name='seleciona-cor']").checked = false;
                    });
                }



                    //alert($( "#turma option:selected" ).text());


                });

</script>

</html>
