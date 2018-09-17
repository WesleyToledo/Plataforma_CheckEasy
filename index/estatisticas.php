

<?php session_start();

    include("general_functions.php");
    include("conexao.php");


?>

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

</head>f

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
            
                        
   <?php echo setSidebar_wrapper('estatisticas'); ?>
           
           
            
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
                        <a class="navbar-brand" href="#">Estatísticas</a>
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
                                
                            </li>
                             <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                                 <ul class="dropdown-menu">
                                    <li>
                                        <a onclick="exitSession()" class="dropdown-toggle">Logout    
                                    <i class="material-icons">clear</i>
                                </a>
                                    </li>
                                     <li><a href="user.php" class="dropdown-toggle">Perfil
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a></li>
                                </ul>
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

                    <h4>Turmas</h4>

                    <div class="row">
                        <?php
                        
                        echo exibeTurma();
                        
                        ?>
                        
                    </div>

                    <h4>Provas</h4>

                    <div class="row">
                        
                        <?php
                        
                        echo exibeProva();
                        
                        ?>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-chart">
                                <div class="card-header card-header-success">
                                    <div class="ct-chart" id="dailySalesChart"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Daily Sales</h4>
                                    <p class="card-category">
                                        <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> updated 4 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-chart">
                                <div class="card-header card-header-danger">
                                    <div class="ct-chart" id="completedTasksChart"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Completed Tasks</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                                    </div>
                                </div>
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
                    <a href="#">CheckEasy</a>, a plataforma online dedicada aos professores
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
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome da Turma</label>
                            <input type="text" class="form-control" name="nome_turma" placeholder="">
                        </div>
                        <div class="form-group" style="display: flex;flex-direction: column;">
                            <label for="exampleInputEmail1">Série</label>
                            <div style="display: flex; flex-direction: row;justify-content: flex-start">
                                <select id="turma" class="custom-select" style="margin-top: 13px;margin-bottom: 13px;border: 0.5px #ccc solid; border-radius: 5px;width: 70%;">
                                  <option value="1">Ensino Fundamental</option>
                                  <option value="2">Ensino Médio</option>
                                  <option value="3">Superior</option>
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
                    <form action="#" method="post">
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

<?php

function exibeTurma(){

    include ("conexao.php");
    
    $id_user = $_SESSION["id_user"];
        
         $sql = "SELECT * FROM serie, turma WHERE id_serie_professor='$id_user'";   
    
     $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()){
            

            $nome_turma = $row["nome"];
            $ensino = $row["ensino"];
            

            
            echo " <div class='col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100' style=''>
                            <div class='card card-stats '>
                                <a href='' style='color: inherit;'>
                                    <div class='card-header' data-background-color='blue400'>
                                        <i class='fa fa-graduation-cap'></i>
                                    </div>
                                    <div class='card-content card-turmas'>
                                        <p class='category'>&nbsp;</p>
                                        <h3 class='title'>  $nome_turma
                                            <!-- <small>GB</small> -->
                                        </h3>
                                    </div>
                                </a>
                                <div class='card-footer'>
                                    <div class='stats'>
                                        <i class='material-icons'>group</i>
                                        <a href='#' style='color: inherit;'>$ensino</a>
                                    </div>
                                </div>
                            </div>
                        </div> ";
                
                echo "</form>";
    
    }
}



?>

<?php


function exibeProva(){
    
    include ("conexao.php");
    
     $id_user = $_SESSION["id_user"];
        
         $sql = "SELECT * FROM avaliacao WHERE id_avaliacao_professor='$id_user'";   
    
     $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()){
        
        $quant = $row["quant_alternativas"];
        $valor = $row["valor"];
        $quant_questoes = $row["quant_questoes"];
        $gabarito = $row["gabarito"];
        
    
    
echo "<div class='col-lg col-md-6 col-sm-6 col-xs-6 col-ws-100' style=''>
                            <div class='card card-stats '>
                                <a href='' style='color: inherit;'>
                                    <div class='card-header' data-background-color='blue400'>
                                        <i class='material-icons'>assignment</i>
                                    </div>
                                    <div class='card-content card-turmas'>
                                        <p class='category'>&nbsp;</p>
                                        <h3 class='title'>$gabarito
                                            <!-- <small>GB</small> -->
                                        </h3>
                                    </div>
                                </a>
                                <div class='card-footer' style='display: flex;flex-direction: row;justify-content: space-around;'>
                                    <div class='stats'>
                                        <i class='material-icons'>visibility</i>
                                        <a href='#' style='color: inherit;'>$quant_questoes Questões</a>
                                    </div> 
                                    <div class='stats'>
                                        <i class='material-icons'>edit</i>
                                        <a href='#' style='color: inherit;'>$quant Alternativas</a>
                                    </div> 
                                    <div class='stats'>
                                        <i class='material-icons'>local_offer</i>
                                        <a href='#' style='color: inherit;'>$valor Pontos</a>
                                    </div>          
                                </div>
                            </div>
                        </div>" ;
        

    
}
}

?>
