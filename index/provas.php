<!doctype html>
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
    
    function listProvas(){
        include("conexao.php");
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        
        $sql= "SELECT * FROM avaliacao WHERE id_avaliacao_professor = $id_user";
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                $nome = $row["nome"];
                $quant_questoes = $row["quant_questoes"];
                $quant_alternativas = $row["quant_alternativas"];
                $valor = $row["valor"];
                $id_avaliacao = $row["idavaliacao"];
                
                $html .= "<div class='col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                            <div class='card text-center'>
                                <div class='card-header' data-background-color='blue400' style='position: absolute; width: 6em;height: 6em; display: flex; justify-content: center;flex-direction: column;align-items: center;'>
                                    <i class='material-icons' style='font-size: 2.8em;'>assignment</i>
                                </div>
                                    <button class='card-header' style='position: absolute; width: 4em;height: 1em; display: flex; justify-content: center;flex-direction: column;align-items: center; background-color: transparent;box-shadow: none;margin-left: 80%;margin-top: 0.1em;color: white;border:none;' data-toggle='modal' data-target='#excluirProva$id_avaliacao'>
                                        <i class='material-icons' style='color: #ef5350; font-weight: 800;cursor: pointer;font-size: 1.3em;'>clear</i>
                                    </button>
                                    
                                    <button class='card-header' style='position: absolute; width: 4em;height: 1em; display: flex; justify-content: center;flex-direction: column;align-items: center; background-color: transparent;box-shadow: none;margin-left: 67%;margin-top: 0.1em;color: white;border:none;' data-toggle='modal' data-target='#editarProva$id_avaliacao'>
                                        <i class='material-icons' style='color: #fff; font-weight: 800;cursor: pointer;font-size: 1.3em;'>create</i>
                                    </button>
 
                                <a href='prova-edit.php?idA=$id_avaliacao&value=$valor'>
                                <img class='card-img-top' src='https://picsum.photos/1900/1080?image=315' >
                                <div class='card-body' id='card'>
                                    <h5 class='card-title text-info' style='font-weight: 500'>$nome</h5>
                                </div>
                                <div class='card-footer text-muted'>
                                    <div class='row'>
                                        <div style='display: flex;justify-content: space-around; flex-direction: row;'>
                                            <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                                <i class='material-icons' style='padding: 5px; font-size: 1.2em'>visibility</i>
                                                <p style='margin: 0; font-size: 0.8em'>$quant_questoes questões</p>
                                            </div>
                                            <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                                <i class='material-icons' style='padding: 5px; font-size: 1.2em'>edit</i>
                                                <p style='margin: 0; font-size: 0.8em'>$quant_alternativas Alternativas</p>
                                            </div>
                                            <div style='display: flex; flex-direction: row;justify-content: center; align-items: center;'>
                                                <i class='material-icons' style='padding: 5px; font-size: 1.2em'>local_offer</i>
                                                <p style='margin: 0; font-size: 0.8em'>$valor pontos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                                <a href='prova-results.php?idA=$id_avaliacao&idT=all&c=blue400'>
                                    <button type='button' class='btn btn-info'>Correções</button>
                                </a>
                            </div>
                        </div>";
            }
        } else {
            echo "<p style='margin: 15px'>Nenhuma Prova Cadastrada</p>";
        }
        return $html;
    }
    
    function geraExcluirProva(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idavaliacao,nome FROM avaliacao WHERE id_avaliacao_professor = $id_user";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_avaliacao = $row["idavaliacao"];
                    $nome = $row["nome"];
                    
                    $html .= "<div class='modal fade' id='excluirProva$id_avaliacao' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Excluir Prova</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                Tem certeza que deseja excluir a prova \" $nome \" ?
                            </div>
                            <div class='modal-footer'>
                            <form action='excluirProva.php?idA=$id_avaliacao' method='post'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn btn-info' >Excluir</button>
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
    
     function geraEditProva(){
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $html = "";
        
        $sql = "SELECT idavaliacao,quant_questoes,quant_alternativas,nome,valor FROM avaliacao WHERE id_avaliacao_professor = $id_user";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    
                    $id_avaliacao = $row["idavaliacao"];
                    $quant_questoes = $row["quant_questoes"];
                    $quant_alternativas = $row["quant_alternativas"];
                    $nome = $row["nome"];
                    $valor = $row["valor"];
                    
                    $html .= "<div class='modal fade' id='editarProva$id_avaliacao' tabindex='-1' role=''dialog' aria-labelledby='modalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'></span><span class='sr-only'>Close</span></button>
                            <h3 class='modal-title mx-auto' id='lineModalLabel'>Editar Prova</h3>
                        </div>
                        <div class='modal-body'>
                            <form action='editarProva.php?idA=$id_avaliacao' method='post'>
                                <div class='form-group'>
                                    <label >Nome/Identificação</label>
                                    <input type='text' class='form-control' name='nome_prova' value='$nome' required>
                                </div>

                                <div style='display: flex;flex-direction: row; justify-content: flex-start;'>
                                    <div class='form-group' style='width: 30% !important;margin-right: 10px;'>
                                        <label>Número de Questões</label>
                                        <input type='number' class='form-control' name='num_questoes' value='$quant_questoes' required>
                                    </div>
                                    <div class='form-group' style='width: 30% !important;margin-right: 10px; '>
                                        <label >Número de Alternativas</label>
                                        <input type='number' class='form-control' name='num_alternativas' value='$quant_alternativas' required>
                                    </div>
                                    <div class='form-group' style='width: 30% !important;margin-right: 10px;'>
                                        <label>Valor Total</label>
                                        <input type='number' step='0.1' class='form-control' name='valor_total' value='$valor' required>
                                    </div>

                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                    <button type='submit' class='btn btn-info'>Editar Turma</button>

                                    <!-- onclick='demo.showNotification('top','right','Turma Cadastrada')' -->

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
        
    
    

    
?>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-1.jpg">
            
            <div class="logo">
                <a href="index.html" class="simple-text">
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
                        <a class="navbar-brand" href="#">Provas</a>
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
                        <ul class="nav navbar-nav navbar-left">
                            <li class="col-xs-12 col-sm-8 d-flex flex-row bd-highlight mb-3">
                                <button type="button" class="btn btn-info" style="justify-content: center;align-items: center;display: flex;flex-direction: row;" data-toggle="modal" data-target="#criarProva">
                                    <i class="material-icons" style="font-size: 27px;">add_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp;Criar Prova
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="row">

                        <?php echo listProvas(); ?>

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
            <div class="modal fade" id="criarProva" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
                            <h3 class="modal-title mx-auto" id="lineModalLabel">Criar Prova</h3>
                        </div>
                        <div class="modal-body">
                            <!-- content goes here -->
                            <form action="cadastrarProva.php" method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome/Identificação</label>
                                    <input type="text" class="form-control" name="nome_prova" placeholder="" required>
                                </div>

                                <div style="display: flex;flex-direction: row; justify-content: flex-start;">
                                    <div class="form-group" style="width: 30% !important;margin-right: 10px;">
                                        <label for="exampleInputEmail1">Número de Questões</label>
                                        <input type="number" class="form-control" name="num_questoes" placeholder="" required>
                                    </div>
                                    <div class="form-group" style="width: 30% !important;margin-right: 10px; ">
                                        <label for="exampleInputEmail1">Número de Alternativas</label>
                                        <input type="number" class="form-control" name="num_alternativas" placeholder="" required>
                                    </div>
                                    <div class="form-group" style="width: 30% !important;margin-right: 10px; ">
                                        <label for="exampleInputEmail1">Valor Total</label>
                                        <input type="number" step="0.1" class="form-control" name="valor_total" placeholder="" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-info">Criar</button>

                                    <!-- onclick="demo.showNotification('top','right','Turma Cadastrada')" -->

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php  
                echo geraExcluirProva();  
                echo geraEditProva();
            ?>

        </div>
    </div>
</body>



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
 var vars = [], hash
         var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            //alert(hash[1])
            if(hash[0] === "s"){
                if(hash[1] === "s"){
                    demo.showNotification('top', 'right', 'Prova excluída', 'success', 'assignment')
                }else {
                    demo.showNotification('top', 'right', '<strong> Erro </strong> ao excluir prova', 'danger', 'assignment')
                }
            }
            if(hash[0] === "es"){
                if(hash[1] === "s"){
                    demo.showNotification('top', 'right', 'Prova editada', 'success', 'assignment')
                }else {
                    demo.showNotification('top', 'right', '<strong> Erro </strong> ao editar prova', 'danger', 'assignment')
                }
            }
        }
        

    });

</script>

</html>
