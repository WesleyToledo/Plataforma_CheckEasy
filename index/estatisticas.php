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
    <script src="https://code.highcharts.com/highcharts.js"></script>

</head>
<?php
    session_start();
    include("conexao.php");
    include("general_functions.php");
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
                                <a href='estatisticas.php?idT=$id_turma' style='color: inherit;'>
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
                                    
                                </div>
                            </div>
                        </div>";
            }
        } else {
            echo "0 resultados";
        }
        return $html;
    }
    
    function listProvas(){
        $id_user = $_SESSION["id_user"];
        $html = "";
        include("conexao.php");
        
        $sql = "SELECT id_turma_prova_avaliacao FROM turma_prova WHERE id_turma_prova_turma = {$_GET["idT"]} AND id_turma_prova_professor = $id_user";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id_prova = $row["id_turma_prova_avaliacao"];
                    $sql2 = "SELECT idavaliacao,quant_questoes,quant_alternativas, valor, nome FROM avaliacao WHERE idavaliacao = $id_prova AND id_avaliacao_professor = $id_user";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
                            $quant_questoes = $row2["quant_questoes"];
                            $quant_alternativas = $row2["quant_alternativas"];
                            $valor = $row2["valor"];
                            $nome = $row2["nome"];
                            $idavaliacao = $row2["idavaliacao"];
                            
                            $html .= " <div class='col-lg col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                                                <div class='card card-stats'>
                                                    <a href='estatisticas.php?idT={$_GET['idT']}&idA=$idavaliacao' style='color: inherit;'>
                                                        <div class='card-header' data-background-color='blue400'>
                                                            <i class='material-icons'>assignment</i>
                                                        </div>
                                                        <div class='card-content card-turmas'>
                                                            <p class='category'>&nbsp;</p>
                                                            <h3 class='title'>$nome
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
                                                            <a href='#' style='color: inherit;'>$quant_alternativas Alternativas</a>
                                                        </div>
                                                        <div class='stats'>
                                                            <i class='material-icons'>local_offer</i>
                                                            <a href='#' style='color: inherit;'>$valor Pontos</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                        }
                    }
            }
        } else {
            $html .= "<p>Nenhuma prova vinculada</p>";
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
                                <?php echo userDropDown(); ?>
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

                            <?php echo listTurmas(); ?>

                        </div>

                        <div class="row">

                            <?php    
                            if ($_GET["idT"] == "all"){
                                echo "<h4>Provas</h4><br><p>Nenhuma Turma Selecionada</p>";     
                            }else{
                                echo "<h4>Provas</h4><br>".listProvas();   
                            }
                        ?>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="card card-chart">
                                    <div class="card-header card-header-warning" style="background-color: white">
                                        <div class="ct-chart" id="chart"></div>
                                    </div>
                                    <!-- <div class="card-body" style="margin: 15px">
                                    <h4 class="card-title">Rendimento</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div> -->
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> Atualizado a x minutos
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-chart">
                                    <div class="card-header card-header-warning" style="background-color: white">
                                        <div class="ct-chart" id="chart2"></div>
                                    </div>
                                    <!-- <div class="card-body" style="margin: 15px">
                                    <h4 class="card-title">Rendimento</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div> -->
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> Atualizado a x minutos
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        
                         <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-warning" data-background-color="green400">
                                    <h3 class="title" style="font-weight: 600;">3ºE1</h3>
                                    <p class="card-category">Alunos</p>
                                </div>
                                <div class="card-body table-responsive" style="margin: 15px">
                                    <table class="table table-hover table-striped">
                                        <thead class="text-warning">
                                            <th style="max-width: 40px;">Matrícula</th>
                                            <th>Nome</th>
                                            <th>&nbsp;</th>
                                        </thead>
                                        <tbody id="rowsAlunos" style="overflow-y: auto">
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rie</td>
                                                <td><a href="#" style="color: black"><i class="material-icons">arrow_right_alt</i></a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rie</td>
                                                <td><a href="#"><i class="material-icons">arrow_right_alt</i></a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rie</td>
                                                <td><a href="#"><i class="material-icons">arrow_right_alt</i></a></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rie</td>
                                                <td><a href="#"><i class="material-icons">arrow_right_alt</i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header card-header-warning" style="background-color: white">
                                    <div class="ct-chart" id="alunoxturma"></div>
                                </div>
                                <!-- <div class="card-body" style="margin: 15px">
                                    <h4 class="card-title">Rendimento</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div> -->
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> Atualizado a x minutos
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

            $(function() {
                var myChart = Highcharts.chart('chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Média de Acertos \'<b>Sistemas Lineares</b>\'<br>Turma <b>3ºE1</b> '
                    },
                    xAxis: {
                        title: {
                            text: 'Questões'
                        },
                        categories: [1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    yAxis: {
                        title: {
                            text: 'Acertos'
                        },
                        tickInterval: 1
                    },
                    tooltip: {
                        formatter: function() {
                            return 'Questão ' + this.x + '<br> Média: <b>' + this.y + '</b>';
                        }
                    },
                    series: [{
                        name: 'Turma E1',
                        data: [1, 5, 4, 5, 6, 7, 9, 10]
                    }]
                });
            });


            $(function() {
                var myChart = Highcharts.chart('chart2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Média de Acertos por Turma <br> <b>Sistemas Lineares</b>'
                    },
                    xAxis: {
                        title: {
                            text: 'Questões'
                        },
                        categories: [1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    yAxis: {
                        title: {
                            text: 'Acertos'
                        },
                        tickInterval: 1
                    },
                    tooltip: {
                        formatter: function() {
                            return 'Questão ' + this.x + '<br> Média: <b>' + this.y + '</b>';
                        }
                    },
                    series: [{
                        name: 'Turma 3ºE1',
                        data: [1, 5, 4, 5, 6, 7, 9, 10]
                    }, {
                        name: 'Turma 3ºE2',
                        data: [2, 3, 6, 5, 4, 8, 6, 7]
                    }, {
                        name: 'Turma 3ºE2',
                        data: [2, 3, 6, 5, 4, 8, 6, 7]
                    }]
                });
            });

            $(function() {
                var myChart = Highcharts.chart('alunoxturma', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Gráfico Aluno x Turma'
                    },
                    xAxis: {
                        title: {
                            text: 'Questões'
                        },
                        categories: ['Sistema Lineares', 'Sistemas Lineares II']
                    },
                    yAxis: {
                        title: {
                            text: 'Média da Nota'
                        },
                        tickInterval: 1
                    },
                    tooltip: {
                        formatter: function() {
                            return 'Média: <b>' + this.y + '</b>';
                        }
                    },
                    series: [{
                        name: 'Wesley Toledo',
                        data: [10, 9.5]
                    }, {
                        name: 'Turma 3ºE1',
                        data: [8, 6]
                    }]
                });
            });

        });

    </script>

</html>
