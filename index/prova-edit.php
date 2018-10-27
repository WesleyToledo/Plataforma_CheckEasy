<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <!--<link rel="stylesheet" href="assets/css/radio.css">-->
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
        
        $sql = "SELECT idturma, nome FROM turma WHERE idturma NOT IN (SELECT id_turma_prova_turma FROM turma_prova WHERE id_turma_prova_professor = $id_user AND id_turma_prova_avaliacao = {$_GET["idA"]}) AND id_turma_professor = $id_user";
        
         $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nomeTurma = $row["nome"];
                $id_turma = $row["idturma"];
                
                $html .= "<div class='funkyradio-info'>
                            <input type='checkbox' name='checkbox".str_replace(" ", "",$nomeTurma)."' id='checkbox$count' value='$id_turma'/>
                            <label for='checkbox$count'>$nomeTurma</label>
                        </div>";
                $count++;
            }
        return $html;
    }else{
        echo "Nenhuma turma disponível";
        }
    }
    
    function listTurmas(){
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        include("conexao.php");
        $sql = "SELECT t.idturma AS 'id_turma',t.nome AS 'nome_turma',s.cor AS 'cor',s.icone AS 'icone' ,s.nome AS 'nome_serie' FROM turma AS t INNER JOIN turma_prova AS tp JOIN serie as s WHERE tp.id_turma_prova_turma = t.idturma AND t.id_turma_serie = s.idserie AND t.id_turma_professor = $id_user AND tp.id_turma_prova_professor = $id_user AND tp.id_turma_prova_avaliacao = {$_GET["idA"]}";
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
                                <a href='turmas.php?id=$id_turma&c=$cor' style='color: inherit;'>
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
                                        <a style='color: inherit'>$serie_nome</a>
                                    </div>
                                    <div class='stats' style='float: right;'>
                                       <a data-toggle='modal' data-target='#excluirTurma$id_turma'>   
                                            <i class='material-icons' style='color: #ef5350; font-weight: 800;cursor: pointer;'>clear</i>
                                       </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        } else {
            echo "<p style='margin: 15px'>Nenhuma Turma Vinculada</p>";
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
                    $id_avaliacao = $_GET["idA"];
                    
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
                            <form action='excluirTurmaProva.php?idT=$id_turma&idA=$id_avaliacao' method='post'>
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
    
    
    function geraCabecalhoGabarito(){
        
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $id_avaliacao = $_GET["idA"];
        $html = "";
        
         $sql = "SELECT quant_alternativas FROM avaliacao WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor = $id_user";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $num_alternativas = $row["quant_alternativas"];
        }
        
        $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

        $html = "<th>
                    <center>
                        &nbsp;
                    </center>
                </th>";
        
        for($x=1;$x<=$num_alternativas;$x++)
        {
            $html .= "<th>
                        <center>
                            <h4>".strtoupper($alternativas[$x-1])."</h4>
                        </center>
                    </th>";
        }
     
        $html .= "<th>
                    <center>
                        &nbsp;
                    </center>
                </th>
                <th style='width: 20%'>
                    <center>
                        <h4>Pontuação</h4>
                    </center>
                  </th>";
        
    return $html;
    }
    
    function geraCorpoGabarito(){
        
        include("conexao.php");
        $id_user = $_SESSION["id_user"];
        $id_avaliacao = $_GET["idA"];
        $html = "";
        
         $sql = "SELECT quant_questoes,gabarito,quant_alternativas,valor FROM avaliacao WHERE idavaliacao = $id_avaliacao AND id_avaliacao_professor = $id_user";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $num_questoes = $row["quant_questoes"];
            $num_alternativas = $row["quant_alternativas"];
            $gabarito = $row["gabarito"];
            $valor = $row["valor"];
        }
        
        $alternativas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

        $html .= "<tbody class='body-gabarito'>";
        
        $count = 0;
        while($gabarito != ""){      
            $barra = strpos($gabarito,"/");
            $tamanho = strlen($gabarito);
            if(strpos($gabarito,"/")){
                $gabarito_array[$count] = substr($gabarito,0,$barra);
                //echo $gabarito_array[$count]."<br>";
                $gabarito = substr($gabarito, $barra + 1, $tamanho);
                $count++;
            }else{
                $gabarito_array[$count] = substr($gabarito, 0, $tamanho);
                $gabarito = "";
            }
        }
        
        $count = 0;
        for($x=0;$x<sizeof($gabarito_array);$x++){
            if($x%3 == 0){
                $certas[$count] = $gabarito_array[$x + 1];
                $valores[$count] = floatval($gabarito_array[$x + 2]);
                //echo "-".$certas[$count];
                //echo "-".$valores[$count];
                $count++;
            }
        }
        
        for($x=1;$x<=$num_questoes;$x++)
        {
            $html .= "<tr>
                        <td>
                            <center>
                                <h4>$x</h4>
                            </center>
                        </td>";
            
            for($y=1;$y<=$num_alternativas;$y++){
                
                if($certas[$x-1] == $alternativas[$y-1]){
                    $check = "checked";
                }else{
                    $check = "";
                }
                
                $html .= "<td class='radio-gabarito'>
                            <center>
                                <label class='btn-default'>
                                    <input type='radio' name='$x' value='$y' $check >
                                <label>
                            </center>
                          </td>";
                
            }
            
            $html .= "<td class='radio-gabarito'>
                        <center>
                            &nbsp;
                        </center>
                    </td>
                    <td class='radio-gabarito'>
                        <div style='padding: 0;margin: 0;display: flex;flex-direction: column;justify-content: flex-start'>
                            <input type='number' min='0' max='$valor' step='0.1' style='border: none; border-bottom: 1px solid #ccc;text-align:center;' value='".floatval($valores[$x-1])."' name='v$x'>
                        </div>
                    </td>";
        }
     
        $html .= "<input type='radio' name='idA' value='$id_avaliacao' checked style='visibility:hidden;'><input type='radio' name='value' value='$valor' checked style='visibility:hidden;'><input type='radio' name='nQ' value='$num_questoes' checked style='visibility:hidden;'></tbody>";
        
    return $html;
    }
    
    
    function geraGabarito(){
        $id_avaliacao = $_GET["idA"];
        $html = "";
        $html = "<thead class='text-success th-gabarito'>
                    ".geraCabecalhoGabarito()."</thead>".geraCorpoGabarito();
        
        return $html;    
    }
?>

<style>
    input[type="radio"] {
        height: 18px !important;
        width: 18px !important;
    }

    input[type="radio"]:checked+label:before,
    input[type="radio"]:not(:checked)+label:before {
        left: 0;
        top: 0;
        width: 25px;
        height: 25px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff !important;
    }

</style>


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
                        <a class="navbar-brand" href="#">
                            <?php echo setNomeProva(); ?>
                        </a>
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
                                <button type="button" class="btn btn-info" style="justify-content: center;align-items: center;display: flex;flex-direction: row;" data-toggle="modal" data-target="#adicionarTurma" onclick="verificaSerie();">
                                    <i class="material-icons" style="font-size: 27px;">add_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp;Adicionar Turma
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <?php echo listTurmas(); ?>
                    </div>


                    <form action="cadastrarGabarito.php">
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header" data-background-color="blue400" style="text-align:justify;">
                                        <h3 class="title" style="font-weight: 600;">Gabarito</h3>
                                    </div>
                                    <div class="card-content table-responsive">
                                        <table class="table">

                                            <?php echo geraGabarito(); ?>

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
                                    <button type="submit" class="btn btn-success" style="justify-content: center;align-items: center;display: flex;flex-direction: row;" onclick="return verificaSoma();">
                                    <i class="material-icons" style="font-size: 27px;">check_circle_outline</i>
                                    &nbsp;&nbsp;&nbsp; Confirmar
                                </button>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())

                        </script>
                        <a href="#">CheckEasy</a>, a plataforma online dedicada a professores
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!----- MODAL AREA ----->


    <!----- ADICIONAR TURMA ----->
    <div class="modal fade" id="adicionarTurma" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                            <button type="submit" class="btn btn-info" id="submitAdicionar">Adicionar</button>

                            <!-- onclick="demo.showNotification('top','right','Turma Cadastrada')" -->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo geraExcluirTurma(); ?>

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
    
    function verificaSerie() {
        $.post('general_functions_JS.php?a=VSerieAvaliacao', {
            idUser: <?php echo $_SESSION["id_user"]; ?>,
            idA : <?php echo $_GET['idA'] ?>
        }, function(data) {
            var valor = data.toString();
            valor = valor.substring(1, valor.length)
            if (valor === 'existe') {
                document.querySelector('#submitAdicionar').disabled = false;
            } else {
                document.querySelector('#submitAdicionar').disabled = true;
            }
        });
    }
    
    function verificaSoma() {
        var somaValores = 0;
        var valor = parseFloat("<?php echo $_GET["value"]; ?>");

        $('form input[type=number]').each(function() {
            somaValores += parseFloat($(this).val());
        });
        
        if (parseFloat(somaValores) !== parseFloat(valor)) {
            if(parseFloat(somaValores) > parseFloat(valor)){
                demo.showNotification('top', 'right', 'Soma dos valores das questões é <strong>MAIOR</strong> que o limite', 'danger', 'info','10')
                return false
            }
            else{
                demo.showNotification('top', 'right', 'Soma dos valores das questões é <strong>MENOR</strong> que o limite', 'danger', 'info','10')
                return false
            }
            
            return false
            
        }else{
            return true
        }

    }
    
    $(document).ready(function() {
        var vars = [], hash
         var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            //alert(hash[1])
            if(hash[0] === "s"){
                if(hash[1] === "es"){
                    demo.showNotification('top', 'right', 'Gabarito Editado', 'success', 'assignment')
                }else {
                    demo.showNotification('top', 'right', '<strong> Erro </strong> ao editar gabarito', 'danger', 'assignment')
                }
            }
        }
        var url = window.location.href
        var newUrl = url.substring(0,(url.lastIndexOf("s=") - 1))
        history.pushState('teste','CheckEasy',newUrl)

    });
    
    
    

</script>

</html>
