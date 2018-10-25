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
<style>
    .dot {
        height: 27px !important;
        width: 27px !important;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        margin: 3px 10px 0px 5px;
        border: 1.3px solid #ccc;
    }

    .gabaritoAjuste td {
        padding: 0px;
        margin: 0px;
        height: 35px !important;
    }

    .markedCorrect {
        background-color: #43a047;
    }

    .markedWrong {
        background-color: #e53935;
    }

    .NotMarked {
        background-color: #fff;
    }

</style>
<?php
    session_start();
    
    include("general_functions.php");
    include("conexao.php");
    
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
                                <a href='prova-results.php?idT=$id_turma&idA={$_GET["idA"]}' style='color: inherit;'>
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
    function setTitleAlunosTurma(){
        include("conexao.php");
        $id_turma = $_GET["idT"];
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        if($id_turma != 'all'){
            
        $sql = "SELECT t.nome AS 'turma_nome',s.nome AS 'nome_serie' FROM turma AS t INNER JOIN serie AS s ON s.idserie = t.id_turma_serie AND t.id_turma_professor = $id_user AND s.id_serie_professor = $id_user AND t.idturma = $id_turma";
            
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $html = "<div style='width: 95%;'>
                        <h3 class='title' style='font-weight: 600;'>".$row["turma_nome"]."</h3>
                        <p class='category' style='font-weight: 500;'>".$row["nome_serie"]."</p>
                    </div>
                    <div style='float: right;'>
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
    
    function setAlunosTurma(){
        include("conexao.php");
        $id_turma = $_GET["idT"];
        $id_avaliacao = $_GET["idA"];
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $html = '';
        
        if($id_turma == "all"){
            $html = '<tr>
                        <td>Nenhuma Turma Selecionada</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>';
        }else{
            
            $sql = "SELECT c.idcorrecoes, c.nota, c.acertos, c.erros, c.gabarito,a.nome AS 'aluno_nome',a.sobrenome as 'sobrenome_aluno',a.idaluno AS 'idaluno' FROM correcoes AS c INNER JOIN turma AS t ON t.idturma = c.id_correcoes_turma AND t.id_turma_professor = $id_user AND c.id_correcoes_professor = $id_user INNER JOIN aluno AS a ON a.idaluno = c.id_correcoes_aluno AND a.id_aluno_professor = 8  INNER JOIN avaliacao AS av ON av.idavaliacao = $id_avaliacao AND av.id_avaliacao_professor = $id_user AND c.id_correcoes_avaliacao = $id_avaliacao AND t.idturma = $id_turma";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_correcoes = $row["idcorrecoes"];
                    $id_aluno = $row['idaluno'];
                    $nota = $row["nota"];
                    $acertos = $row["acertos"];
                    $erros = $row["erros"];
                    $gabarito = $row["gabarito"];
                    $idaluno = $row['idaluno'];
                    $nome = $row["aluno_nome"];
                    $sobrenome = $row["sobrenome_aluno"];

                    $html .= "<tr>
                                <td>$nome $sobrenome</td>
                                <td>$acertos</td>
                                <td>$erros</td>
                                <td>$nota</td>
                                <td>
                                    <div style='display: flex; flex-direction: row; justify-content: space-around;align-items: center;'>
                                        <div>
                                            <button type='button' class='btn' style='margin: 0;background-color: transparent;' data-toggle='modal' data-target='#mostrarGabarito$id_aluno'>
                                            <i class='material-icons' style='font-size: 20px;color: #404040'>assignment</i>
                                        </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                }
            } else {
                echo "<tr>
                        <td>Nenhum Correção Encontrada</td>
                        <td>&nbsp;</td>
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
    
    function geraModalGabarito(){
        include("conexao.php");
        $id_turma = $_GET["idT"];
        $id_avaliacao = $_GET["idA"];
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        
        $html = '';
        
        if($id_turma == "all"){
            $html = '';
        }else{
            
            $sql = "SELECT c.idcorrecoes, c.nota, c.acertos, c.erros, c.gabarito AS 'gabarito_correcoes',av.quant_questoes, av.quant_alternativas,a.nome AS 'nome_aluno',a.idaluno AS 'idaluno', a.sobrenome AS 'sobrenome_aluno',av.gabarito AS 'gabarito_avaliacao' FROM correcoes AS c INNER JOIN turma AS t ON t.idturma = c.id_correcoes_turma AND t.id_turma_professor = $id_user AND c.id_correcoes_professor = $id_user INNER JOIN aluno AS a ON a.idaluno = c.id_correcoes_aluno AND a.id_aluno_professor = 8  INNER JOIN avaliacao AS av ON av.idavaliacao = $id_avaliacao AND av.id_avaliacao_professor = $id_user AND c.id_correcoes_avaliacao = $id_avaliacao AND t.idturma = $id_turma";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_correcoes = $row["idcorrecoes"];
                    $id_aluno = $row["idaluno"];
                    $nome_aluno = $row["nome_aluno"];
                    $sobrenome_aluno = $row["sobrenome_aluno"];
                    $nota = $row["nota"];
                    $acertos = $row["acertos"];
                    $erros = $row["erros"];
                    $gabarito_correcoes = $row["gabarito_correcoes"];
                    //$gabarito_avaliacao = $row["gabarito_avaliacao"];
                    $quant_questoes = $row["quant_questoes"];
                    $quant_alternativas = $row["quant_alternativas"];
                    
                    $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
                    
                    $count = 0;
                    while($gabarito_correcoes != ""){      
                        $barra = strpos($gabarito_correcoes,"/");
                        $tamanho = strlen($gabarito_correcoes);
                        if(strpos($gabarito_correcoes,"/")){
                            $gabarito_array[$count] = substr($gabarito_correcoes,0,$barra);
                            echo $gabarito_array[$count]."<br>";
                            $gabarito_correcoes = substr($gabarito_correcoes, $barra + 1, $tamanho);
                            $count++;
                        }else{
                            $gabarito_array[$count] = substr($gabarito_correcoes, 0, $tamanho);
                            $gabarito_correcoes = "";
                        }
                    }

                    $count = 0;
                    for($x=0;$x<sizeof($gabarito_array);$x++){
                        if($x%3 == 0){
                            $respostas[$count] = $gabarito_array[$x + 1];
                            //$valores[$count] = floatval($gabarito_array[$x + 2]);
                            //echo "-".$certas[$count];
                            //echo "-".$valores[$count];
                            $count++;
                        }
                    }

                    $html .= "<div class='modal fade' id='mostrarGabarito$id_aluno' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
                                <div class='modal-dialog' style='width:350px' >
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                                            <h4 class='modal-title mx-auto' id='lineModalLabel' style='font-size:20px'>$nome_aluno $sobrenome_aluno</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <div style='width:100%;align-items:center;display:flex;flex-direction:column'>
                                                <table class='gabaritoAjuste'>
                                                    <tr>
                                                        <td>
                                                            &nbsp;
                                                        </td>";
                    
                    for($x=1;$x <= $quant_alternativas;$x++){
                        $html .= "<td style='text-align:center;justify-content:center;align-items:center'>
                                        <h3 style='margin: 10px;'>".strtoupper($alternativas[$x - 1])."</h3>
                                  </td>";
                    }


                    $html .= "</tr>
                              <tr style='padding: 0px;margin:0px'>";
                        
                    
                    for($x=1;$x <=$quant_questoes;$x++){
                        $html .= "<td style='text-align:center'>
                                        <h4 style='font-size: 25px;margin: 3px;padding-right:10px'>$x</h4>
                                  </td>";
                        
                            for($y = 1;$y <= $quant_alternativas;$y++){
                                if($respostas[$x-1] == $alternativas[$y-1]."c"){
                                    $class = "markedCorrect";
                                }else if ($respostas[$x-1] == $alternativas[$y-1]."e"){
                                    $class = "markedWrong";
                                }else{
                                    $class = "NotMarked";
                                }
                                
                                $html .= "<td style='text-align:center'>
                                              <p class='dot $class' ></p>
                                          </td>";
                            }
                             
                        $html .= "</tr>";
                    }
                    $html .= "</tr>
                                </table>
                                <div class='row'>
                                    <div style='display: flex;justify-content: space-around; flex-direction: row;'>
                                        <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                            <i class='material-icons' style='padding: 5px; font-size: 1.7em;color: #43a047'>check</i>
                                            <p style='margin: 0; font-size: 0.8em'>$acertos Acertos</p>
                                        </div>
                                        <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                            <i class='material-icons' style='padding: 5px; font-size: 1.7em; color: #e53935'>close</i>
                                            <p style='margin: 0; font-size: 0.8em'>$erros Erros</p>
                                        </div>
                                        <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                            <i class='material-icons' style='padding: 5px; font-size: 1.7em'>local_offer</i>
                                            <p style='margin: 0; font-size: 0.8em'>$nota pontos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
                }
            } else {
                echo "";
            }
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
                            <a class="navbar-brand" href="#">Prova</a>
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

                        <div class="row">
                            <?php echo listTurmas(); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" style="text-align:justify;display:flex; align-items: center; background-color:#1dc8cd">
                                        <?php  echo setTitleAlunosTurma(); ?>
                                    </div>
                                    <div class="card-content table-responsive">
                                        <table class="table">
                                            <thead class="text-success" style="color:#1dc8cd;">
                                                <th>Aluno</th>
                                                <th>Acertos</th>
                                                <th>Erros</th>
                                                <th>Nota</th>
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
                            <a href="#">CheckEasy</a>, a plataforma online dedicada aos professores
                        </p>
                    </div>
                </footer>
            </div>
        </div>

        <!----- MODAL AREA ----->
        <?php echo geraModalGabarito(); ?>

        <!----- MOSTRA GABARITO ----->



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
