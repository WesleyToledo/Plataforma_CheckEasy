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
    
    function setNomeProva(){
        include("conexao.php");
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $id_avaliacao = $_GET["idA"];
        
        $sql = "SELECT nome FROM avaliacao WHERE idavaliacao = $id_avaliacao";
        
        $nomeAvaliacao = "";
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nomeAvaliacao = $row["nome"];
            }
        return $nomeAvaliacao;
    }
    }
    
    function setSeriesCheck(){
        include("conexao.php");
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        $count = 1;
        
        $sql = "SELECT idturma, nome FROM turma where idturma not in (select id_turma_prova_turma from turma_prova where id_turma_prova_professor = $id_user) and id_turma_professor = $id_user";
        
         $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nomeTurma = $row["nome"];
                $id_turma = $row["idturma"];
                
                $html .= "<div class='funkyradio-info'>
                            <input type='checkbox' name='checkbox$nomeTurma' id='checkbox$count' value='$id_turma'/>
                            <label for='checkbox$count'>$nomeTurma</label>
                        </div>";
                $count++;
            }
        return $html;
    }}
    
    function listTurmas(){
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        include("conexao.php");
        $sql = "SELECT t.idturma AS 'id_turma',t.nome AS 'nome_turma',s.cor AS 'cor',s.icone AS 'icone' ,s.nome AS 'nome_serie' FROM turma AS t INNER JOIN turma_prova AS tp JOIN serie as s WHERE tp.id_turma_prova_turma = t.idturma AND t.id_turma_serie = s.idserie AND t.id_turma_professor = $id_user AND tp.id_turma_prova_professor = $id_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $turma_nome = $row["nome_turma"];
                $cor = $row["cor"];
                $icone = $row["icone"];
                $serie_nome = $row["nome_serie"];
                $id_turma = $row["id_turma"];
                $html .= "<div class='col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                            <div class='card card-stats'>
                                <a href='turmas.php?id=$id_turma' style='color: inherit;'>
                                    <div class='card-header' data-background-color='$cor'>
                                        <i class='$icone'></i>
                                    </div>
                                    <div class='card-content card-turmas'>
                                        <p class='category'>&nbsp;</p>
                                        <h3 class='title' style='overflow:hidden; width:130px;text-align:center;' title='$turma_nome'>$turma_nome
                                        </h3>
                                    </div>
                                </a>
                                <div class='card-footer'>
                                    <div class='stats'>
                                        <i class='material-icons'>group</i>
                                        <a href='#' style='color: inherit'>$serie_nome</a>
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
            echo "0 resultados";
        }
        return $html;
    }
    
    
    
    
    
    
?>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-1.jpg">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    CheckEasy
                </a>
            </div>
            
            <?php echo setSidebar_wrapper('provas'); ?>
            
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
                        <a class="navbar-brand" href="#"><?php echo setNomeProva(); ?></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Número de correções disponíveis">
                                    <i class="material-icons">assignment</i>
                                    
                                    <!--
                                        Se númeroCorreções <10
                                            set style=""
                                       
                                        Se númeroCorreções > 9
                                            set style="right: 5px;";
                                        se número Correções > 99
                                            set style="right: 0px;"
                                        se numeroCorreções > 999
                                            set style="right: -3px;"
                                    
                                    -->
                                    <span class="notification" style="right: 0">150</span>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <!-- <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul> -->
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                        </ul>
                        <!-- <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form> -->
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="col-xs-12 col-sm-8 d-flex flex-row bd-highlight mb-3">
                                <button type="button" class="btn btn-info" style="justify-content: center;align-items: center;display: flex;flex-direction: row;" data-toggle="modal" data-target="#cadastrarTurma">
                                    <i class="material-icons" style="font-size: 27px;">add_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp; Adicionar Turma
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <?php echo listTurmas(); ?>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" data-background-color="green400" style="text-align:justify;">
                                    <h3 class="title" style="font-weight: 600;">Gabarito</h3>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table">
                                        <form action="">
                                            <thead class="text-success th-gabarito">
                                                <th>
                                                    <center>
                                                        &nbsp;
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>A</h4>
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>B</h4>
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>C</h4>
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>D</h4>
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>E</h4>
                                                    </center>
                                                </th>
                                                <th>
                                                    <center>
                                                        <h4>&nbsp;</h4>
                                                    </center>
                                                </th>
                                                <th style="width: 20%">
                                                    <center>
                                                        <h4>Pontuação</h4>
                                                    </center>
                                                </th>

                                            </thead>
                                            <tbody class="body-gabarito">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <h4>1</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>2</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>3</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>4</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>5</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>6</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>7</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>8</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>9</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>
<tr>
                                                    <td>
                                                        <center>
                                                            <h4>10</h4>
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            <input type="radio" name="1" value="male">
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <center>
                                                            &nbsp;
                                                        </center>
                                                    </td>
                                                    <td class="radio-gabarito">
                                                        <div style="padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start">
                                                            <input type="number" min="0" max="10" step="0.1" style="border: none; border-bottom: 1px solid #ccc">
                                                        </div>
                                                    </td>
                                                </tr>

                                                
                                            </tbody>
                                        </form>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                    <div class="row">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="col-xs-12 col-sm-8 d-flex flex-row bd-highlight mb-3">
                                <button type="button" class="btn btn-success" style="justify-content: center;align-items: center;display: flex;flex-direction: row;">
                                    <i class="material-icons" style="font-size: 27px;">check_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp; Confirmar
                                </button>
                            </li>
                        </ul>
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
                        <a href="#">CheckEasy</a>, a plataforma online dedicada aos professores
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!----- MODAL AREA ----->


    <!----- CRIA TURMA ----->
    <div class="modal fade" id="cadastrarTurma" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title mx-auto" id="lineModalLabel">Adicionar Turma</h3>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    
                    <form action="adicionarTurmaProva.php?idA=<?php echo $_GET["idA"]; ?>" method="post">
                        <div class="form-group" style="display: flex;flex-direction: column;">
                            <label for="exampleInputEmail1">Turmas</label>

                            <div class="funkyradio">
                                <?php echo setSeriesCheck(); ?>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-info">Adicionar</button>

                            <!-- onclick="demo.showNotification('top','right','Turma Cadastrada')" -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

<script>
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

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>

</html>
