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
                $html .= "<div class='col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                            <div class='card card-stats'>
                                <a href='turmas.php?id=$id_turma' style='color: inherit;'>
                                    <div class='card-header' data-background-color='$cor'>
                                        <i class='$icone'></i>
                                    </div>
                                    <div class='card-content card-turmas'>
                                        <p class='category'>&nbsp;</p>
                                        <h3 class='title'>$turma_nome
                                        </h3>
                                    </div>
                                </a>
                                <div class='card-footer'>
                                    <div class='stats'>
                                        <i class='material-icons'>group</i>
                                        <a href='#' style='color: inherit'>$serie_nome</a>
                                    </div>
                                    <div class='stats' style='float: right'>
                                       <a data-toggle='modal' data-target='#excluirTurma'>   
                                            <i class='material-icons' style='color: #ef5350; font-weight: 800;cursor: pointer;'>clear</i>
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
    
    
    function setSeriesCadastrarTurma(){
        
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
                
                $html .= "<option value='$id_serie'>$nome_serie</option>";
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>';
        }else{
            
            $sql = "";
            
            $sql = "SELECT a.idaluno AS 'idaluno', a.nome AS 'nome', a.matricula AS 'matricula',a.sobrenome AS 'sobrenome' FROM aluno AS a INNER JOIN turma as t where a.id_aluno_turma = $id_turma and t.idturma = $id_user and t.id_turma_professor = $id_user";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_serie = $row["idaluno"];
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
                                            <button type='button' class='btn' style='margin: 0; background-color: transparent;' data-toggle='modal' data-target='#editarAluno$id_serie'>
                                            <i class='material-icons' style='font-size: 20px; color: #404040'>create</i>
                                        </button>
                                        </div>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0;background-color: transparent;' data-toggle='modal' data-target='#excluirAluno'>
                                            <i class='material-icons' style='font-size: 20px;color: #404040'>clear</i>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                }
            } else {
            }
        }
        return $html;
    }
    
    
    function setTitleAlunosTurma(){
        
        include("conexao.php");
        $id_turma = $_GET["id"];
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        if($id_turma != 'all'){
        $sql = "SELECT t.nome as 'turma_nome', s.nome as 'nome_serie' FROM turma AS t INNER JOIN serie as s where t.idturma = $id_turma";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $html = "<h3 class='title' style='font-weight: 600;'>".$row["turma_nome"]."</h3>
                 <p class='category' style='font-weight: 500;'>".$row["nome_serie"]."</p>";
            
        } else {
            
        }
    }else{
            $html = $html = "<h3 class='title' style='font-weight: 600;'>Turma</h3>
                 <p class='category' style='font-weight: 500;'>Série</p>";
        }
        return $html;
        
    }
    
?>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
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
                                    &nbsp;&nbsp;&nbsp;Cadastrar turma
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                       
                       <?php  echo listTurmas(); ?>
                       
                       <!-- 
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100" style="">
                            <div class="card card-stats ">
                                <a href="" style="color: inherit;">
                                    <div class="card-header" data-background-color="blue400">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <div class="card-content card-turmas">
                                        <p class="category">&nbsp;</p>
                                        <h3 class="title">3ºE1
                                            <small>GB</small>
                                        </h3>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i>
                                        <a href="#" style="color: inherit;">Ensino Médio</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100">
                            <div class="card card-stats ">
                                <a href="" style="color: inherit;">
                                    <div class="card-header" data-background-color="red400">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <div class="card-content card-turmas">
                                        <p class="category">&nbsp;</p>
                                        <h3 class="title">9º A
                                            <small>GB</small>
                                        </h3>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i>
                                        <a href="#" style="color: inherit;">Ensino Fundamental</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100">
                            <div class="card card-stats ">
                                <a href="" style="color: inherit;">
                                    <div class="card-header" data-background-color="green400">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <div class="card-content card-turmas">
                                        <p class="category">&nbsp;</p>
                                        <h3 class="title">1ºE1
                                            <small>GB</small>
                                        </h3>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i>
                                        <a href="#" style="color: inherit;">Ensino Médio</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100">
                            <div class="card card-stats ">
                                <a href="" style="color: inherit;">
                                    <div class="card-header" data-background-color="orange400">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <div class="card-content card-turmas">
                                        <p class="category">&nbsp;</p>
                                        <h3 class="title">Proeja
                                            <small>GB</small>
                                        </h3>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i>
                                        <a href="#" style="color: inherit;">Ensino Médio</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="green400" style="text-align:justify;">
                                    <?php  echo setTitleAlunosTurma(); ?>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table">
                                        <thead class="text-success">
                                            <th>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Sobrenome</th>
                                            <th>
                                                <center>
                                                    Ações
                                                </center>
                                            </th>
                                        </thead>
                                        <tbody>
                                           <?php  echo setAlunosTurma(); ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                            <input type="text" name="nomeTurma" class="form-control" name="nome_turma" placeholder="">
                        </div>
                        <div class="form-group" style="display: flex;flex-direction: column;">
                            <label for="exampleInputEmail1">Série</label>
                            <div style="display: flex; flex-direction: row;justify-content: flex-start">
                                <select id="turma" name="serie" class="custom-select" style="margin-top: 13px;margin-bottom: 13px;border: 0.5px #ccc solid; border-radius: 5px;width: 70%;">
                                 
                                 <?php  echo setSeriesCadastrarTurma();  ?>
                                </select>
                                <div style="display: flex;flex-direction: column; ustify-content: center; align-items: center; width: 30%">

                                    <button type="button" class="btn btn-info" style="justify-content: center;align-items: center;display: flex;flex-direction: row;" data-toggle="modal" data-target="#criaSerie">
                                    <i class="material-icons" style="font-size: 20px;">add_circle_outline</i>
                                   
                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-info">Cadastrar Turma</button>

                            <!-- onclick="demo.showNotification('top','right','Turma Cadastrada')" -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----- CRIA SÉRIE ----->
    <div class="modal fade" id="criaSerie" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                        <div class="form-group" style="display: flex;flex-direction: column;">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-info">Salvar Informações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----- Editar Aluno ----->
    <div class="modal fade" id="editarAluno" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title mx-auto" id="lineModalLabel">Editar Aluno</h3>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Matrícula</label>
                            <input type="text" class="form-control" name="nome_turma" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome</label>
                            <input type="text" class="form-control" name="nome_turma" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sobrenome</label>
                            <input type="text" class="form-control" name="nome_turma" placeholder="">
                        </div>

                        <div class="form-group" style="display: flex;flex-direction: column;">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-info">Salvar Informações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----- Excluir Aluno ----->
    <div class="modal fade" id="excluirAluno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir o aluno x ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-info">Excluir</button>
                </div>
            </div>
        </div>
    </div>

<!----- Excluir Turma ----->
    <div class="modal fade" id="excluirTurma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Turma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir o turma x ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-info">Excluir</button>
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
