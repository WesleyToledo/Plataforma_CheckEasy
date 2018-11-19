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
                $selecionado = "";
                
                if($_GET['idT'] == "$id_turma"){
                    $selecionado = "box-shadow: 0px -2px 19px 4px rgba(0, 0, 0, 0.19);";
                }
                
                $html .= "<div class='col-lg-3 col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                            <div class='card card-stats'  style='$selecionado'>
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
                            $selecionado = "";
                            if($_GET["idT"] != "all"){
                                if(isset($_GET['idA'])){
                                    if($_GET['idA'] == "$idavaliacao"){
                                        $selecionado = "box-shadow: 0px -2px 19px 4px rgba(0, 0, 0, 0.19);";
                                    }
                                }
                            }

                            
                            $html .= " <div class='col-lg col-md-6 col-sm-6 col-xs-6 col-ws-100'>
                                                <div class='card card-stats' style='$selecionado'>
                                                    <a href='estatisticas.php?idT={$_GET['idT']}&idA=$idavaliacao' style='color: inherit;'>
                                                        <div class='card-header' data-background-color='blue400'>
                                                            <i class='material-icons'>assignment</i>
                                                        </div>
                                                        <div class='card-content card-turmas'>
                                                            <p class='category'>&nbsp;</p>
                                                            <h3 class='title'>$nome
                                                                <!--<small>GB</small>-->
                                                            </h3>
                                                        </div>
                                                    </a>
                                                    <div class='card-footer' style='display: flex;flex-direction: row;justify-content: space-around;'>
                                                        <div class='stats'>
                                                            <i class='material-icons' style='background:linear-gradient(45deg, #1de099, #1dc8cd);-webkit-text-fill-color:transparent;-webkit-background-clip: text;'>visibility</i>
                                                            <a href='#' style='color: inherit;font-weight: 500;color: #4e4e4e''>$quant_questoes Questões</a>
                                                        </div>
                                                        <div class='stats'>
                                                            <i class='material-icons' style='background:linear-gradient(45deg, #1de099, #1dc8cd);-webkit-text-fill-color:transparent;-webkit-background-clip: text;'>edit</i>
                                                            <a href='#' style='color: inherit;font-weight: 500;color: #4e4e4e''>$quant_alternativas Alternativas</a>
                                                        </div>
                                                        <div class='stats'>
                                                            <i class='material-icons' style='background:linear-gradient(45deg, #1de099, #1dc8cd);-webkit-text-fill-color:transparent;-webkit-background-clip: text;'>local_offer</i>
                                                            <a href='#' style='color: inherit;font-weight:500;color: #4e4e4e''>$valor Pontos</a>
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
    
    //GRÁFICOS
    
    function geraGraficoAcertosPorQuestao(){
        $id_user = $_SESSION["id_user"];
        $html = "";
        include("conexao.php");
        
        if(isset($_GET['idA'])){
        $sql = "SELECT a.nome AS 'nome_avaliacao',t.nome AS 'nome_turma',a.quant_questoes,c.gabarito FROM avaliacao AS a INNER JOIN turma AS t INNER JOIN correcoes AS c ON c.id_correcoes_avaliacao = {$_GET['idA']} AND c.id_correcoes_turma = {$_GET['idT']} AND c.id_correcoes_avaliacao = a.idavaliacao AND c.id_correcoes_turma = t.idturma AND c.id_correcoes_professor = $id_user AND t.id_turma_professor = $id_user AND a.id_avaliacao_professor = $id_user";
        
        $sql2 = "SELECT a.nome AS 'nome_avaliacao',t.nome AS 'nome_turma',a.quant_questoes,c.gabarito FROM avaliacao AS a INNER JOIN turma AS t INNER JOIN correcoes AS c ON c.id_correcoes_avaliacao = {$_GET['idA']} AND c.id_correcoes_turma = {$_GET['idT']} AND c.id_correcoes_avaliacao = a.idavaliacao AND c.id_correcoes_turma = t.idturma AND c.id_correcoes_professor = $id_user AND t.id_turma_professor = $id_user AND a.id_avaliacao_professor = $id_user";
        
        
            
            $result2 = $conn->query($sql2);

            $row = $result2->fetch_assoc();
            for($x=0;$x<$row["quant_questoes"];$x++){
                        $acertos[$x] = 0;
                    }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row2 = $result->fetch_assoc()) {
                        $gabaritoAluno = $row2["gabarito"];

                        $count = 0;
                        while($gabaritoAluno != ""){      
                            $barra = strpos($gabaritoAluno,"/");
                            $tamanho = strlen($gabaritoAluno);
                            if(strpos($gabaritoAluno,"/")){
                                $gabarito_array[$count] = substr($gabaritoAluno,0,$barra);
                                $gabaritoAluno = substr($gabaritoAluno, $barra + 1, $tamanho);
                                $count++;
                            }else{
                                $gabarito_array[$count] = substr($gabaritoAluno, 0, $tamanho);
                                $gabaritoAluno = "";
                            }
                        }
                        $count = 0;
                        for($x=0;$x<sizeof($gabarito_array);$x++){
                            if($x%3 == 0){
                                if(substr($gabarito_array[$x+1],1,1) == "s"){
                                    $acertos[$count]= $acertos[$count] + 1;
                                    $count++;
                                }else if(substr($gabarito_array[$x+1],1,1) == "e"){
                                    $count++;
                                }

                            }
                        }

                    }
                    $html .= "$(function() {
                    var myChart = Highcharts.chart('chart', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Acertos por Questão \'<b>{$row['nome_avaliacao']}</b>\'<br>Turma <b>{$row['nome_turma']}</b> '
                        },
                        xAxis: {
                            title: {
                                text: 'Questões'
                            },
                            categories: [";
                        for($x=1;$x<$row['quant_questoes'];$x++){
                            $html .= "$x,";
                        }

                        $html .="{$row['quant_questoes']}]
                        },
                        yAxis: {
                            title: {
                                text: 'Acertos'
                            },
                            tickInterval: 1
                        },
                        tooltip: {
                            formatter: function() {
                                return 'Questão ' + this.x + '<br> Acertos: <b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Turma {$row["nome_turma"]}',";

                        $html .= "
                        data: [";
                        for($x=0;$x<sizeof($acertos) - 1;$x++){
                            $html .= "$acertos[$x],";   
                        }
                            $html .= $acertos[sizeof($acertos) - 1]."]
                        }]
                    });
                });";

            } else {
                $html = "$(function() {
                    var myChart = Highcharts.chart('chart', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Nenhuma Correção Encontrada'
                        },
                        xAxis: {
                            title: {
                                text: 'Questões'
                            },
                            categories: []
                        },
                        yAxis: {
                            title: {
                                text: 'Acertos'
                            },
                            tickInterval: 1
                        },
                        tooltip: {
                            formatter: function() {
                                return 'Questão ' + this.x + '<br> Acertos: <b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Turma Não Econtrada',";

                        $html .= "
                        data: []
                        }]
                    });
                });";
            }
                    
        }
            return $html;
    }
    
    function geraTabelaAlunos(){
         $id_user = $_SESSION["id_user"];
        $html = "";
        include("conexao.php");
        
        if(isset($_GET['idA'])){
            
            $sql = "SELECT al.nome,al.sobrenome,al.idaluno,al.matricula FROM turma_prova AS tp INNER JOIN aluno AS al ON tp.id_turma_prova_avaliacao = {$_GET['idA']} AND tp.id_turma_prova_turma = {$_GET['idT']} AND tp.id_turma_prova_professor = $id_user AND tp.id_turma_prova_turma = al.id_aluno_turma";

            $sql2 = "SELECT t.nome,s.cor FROM turma AS t INNER JOIN serie AS s ON t.id_turma_serie=s.idserie AND t.idturma = {$_GET['idT']} AND s.id_serie_professor = $id_user AND t.id_turma_professor = $id_user";
            
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
            
            $html = "<div class='col-lg-6 col-md-12'>
                            <div class='card'>
                                <div class='card-header card-header-warning' data-background-color='{$row2['cor']}'>
                                    <h3 class='title' style='font-weight: 600;'>{$row2['nome']}</h3>
                                    <p class='card-category'>Alunos</p>
                                </div>
                                <div class='card-body table-responsive' style='margin: 15px'>
                                    <table class='table table-hover table-striped'>
                                        <thead style='color: #666;font-weight: 800 !important;'>
                                            <th style='max-width: 40px;'>Matrícula</th>
                                            <th>Nome</th>
                                            <th>Ações</th>
                                        </thead>
                                        <tbody id='rowsAlunos' style='overflow-y: auto'>";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row=$result->fetch_assoc()) {
                    $selecionado = "";
                    if(isset($_GET['idAL'])){
                        if($row['idaluno'] == $_GET['idAL']){    
                            $selecionado = "font-weight: 600";
                        }
                    }
                    $html .= "<tr style='$selecionado'>
                                <td>{$row['matricula']}</td>
                                <td>{$row['nome']}{$row['sobrenome']}</td>
                                <td><a href='estatisticas.php?idT={$_GET['idT']}&idA={$_GET['idA']}&idAL={$row['idaluno']}' style='color: black;'><i class='material-icons'>arrow_right_alt</i></a></td>
                            </tr>
                        ";
                }    
            }
        $html .= "</tbody>
                    </table>
                    </div>
                </div>
            </div>";
        }
        
        return $html;
    }
    
    function geraGraficoAlunoXTurma(){
         $id_user = $_SESSION["id_user"];
        $html = "";
        include("conexao.php");
        
        if(isset($_GET['idAL'])){
            
            $sql = "SELECT a.nome AS 'nome_avaliacao',t.nome AS 'nome_turma' FROM avaliacao AS a INNER JOIN turma_prova AS tp INNER JOIN turma AS t ON tp.id_turma_prova_turma = {$_GET['idT']} AND tp.id_turma_prova_avaliacao = a.idavaliacao AND tp.id_turma_prova_professor = $id_user AND a.id_avaliacao_professor = $id_user AND t.id_turma_professor = $id_user AND t.idturma=tp.id_turma_prova_turma";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                    $html .= "$(function() {
                    var myChart = Highcharts.chart('alunoxturma', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Gráfico Aluno x Turma'
                        },
                        xAxis: {
                            title: {
                                text: 'Provas'
                            },
                            categories: [";
                $count = 0;
                while($row=$result->fetch_assoc()){
                        $html .= "'{$row['nome_avaliacao']}',";
                        $nomesTurmas[$count] = $row['nome_turma'];
                        $nomesAvaliacao[$count] = $row['nome_avaliacao'];
                        $count++;
                }
                
                $html .= "]
                },yAxis: {
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
                series: [";
                
                $sql2 = "SELECT co.nota FROM aluno AS a INNER JOIN correcoes AS co ON a.idaluno= {$_GET['idAL']} AND a.idaluno=co.id_correcoes_aluno AND co.id_correcoes_professor = $id_user AND a.id_aluno_professor = $id_user";
                
               
                $count = 0;
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2=$result2->fetch_assoc()){
                        $notasAluno[$count] = $row2['nota'];
                        //echo $notasAluno[$count];
                        $count++;
                    }    
                }else{
                    $notasAluno[$count] =0;
                }
                
                $sql4 = "SELECT tp.id_turma_prova_avaliacao AS 'id_avaliacao' FROM turma_prova AS tp WHERE tp.id_turma_prova_turma = {$_GET['idT']} AND tp.id_turma_prova_professor = $id_user";
                
                $sql5 = "SELECT COUNT(*) as 'quant' FROM turma_prova AS tp WHERE tp.id_turma_prova_turma = {$_GET['idT']} AND tp.id_turma_prova_professor = $id_user";
                
                
                $quant_results = 0;
                $result5 = $conn->query($sql5);
                $row5 = $result5->fetch_assoc();
                if($result5->num_rows>0){
                    $quant_results = $row5['quant'];
                }    
                
                $count = 0;
                $result4 = $conn->query($sql4);
                if ($result4->num_rows > 0) {
                    while($row4=$result4->fetch_assoc()){
                        $idAvaliacao = $row4['id_avaliacao'];
                        
                        $sql6 = "SELECT co.nota FROM correcoes AS co WHERE co.id_correcoes_avaliacao = $idAvaliacao AND co.id_correcoes_professor = $id_user AND co.id_correcoes_turma = {$_GET['idT']}";
                        
                        $somaNotas = 0;
                        $result6 = $conn->query($sql6);
                        if($result6->num_rows > 0){
                            while($row6=$result6->fetch_assoc()){
                                $somaNotas += $row6['nota'];
                            }
                        }
                        
                        $sql7 = "SELECT COUNT(*) AS 'quant' FROM correcoes AS co WHERE co.id_correcoes_avaliacao = $idAvaliacao AND co.id_correcoes_professor = $id_user";
                        
                        $quant_results = 1;
                        $result7 = $conn->query($sql7);
                        if($result7->num_rows > 0){
                            $row7=$result7->fetch_assoc();
                            if($row7['quant'] > 0){   
                                $quant_results = $row7['quant'];
                            }else{
                                $quant_results = 1;
                            }
                        }
                        $notasTurma[$count]=$somaNotas/$quant_results;
                        //echo $notasTurma[$count];
                        $count++;
                    }    
                }
                /*
                for($x=0;$x<sizeof($nomesTurmas);$x++){
                   echo "Nomes turmas".$nomesTurmas[$x];/*
                    echo "    Notas turmas".$notasTurma[$x];
                    echo "     Notas Aluno".$notasAluno[$x];
                   }*/

                    $sql8 = "SELECT a.nome FROM aluno AS a WHERE a.idaluno = {$_GET['idAL']} AND a.id_aluno_professor = $id_user";
                
                    $result8 = $conn->query($sql8);
                        if($result8->num_rows > 0){
                            $row8=$result8->fetch_assoc();
                            $nomeAluno = $row8['nome'];
                        }
                
                    $html .= "{
                        name: '$nomeAluno',
                        data: [";
                    
                    for($x=0;$x<sizeof($notasAluno);$x++){
                        $html .= "$notasAluno[$x],";
                    }
                            $html .= "]
                            },";
                
                    $html .= "{
                        name: '$nomesTurmas[0]',
                        data: [";
                     
                    for($x=0;$x<sizeof($notasTurma);$x++){
                        $html .= "$notasTurma[$x],";
                    }  
                
                $html .= "]
                        }
                        ]});
                        });";
            }else{
                $html .= "$(function() {
                var myChart = Highcharts.chart('alunoxturma', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Nenhuma Correção Encontrada'
                    },
                    xAxis: {
                        title: {
                            text: 'Questões'
                        },
                        categories: []
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
                        name: 'Aluno Não Encontrado',
                        data: []
                    }]
                });
            });";
            }
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
                                <?php echo userDropDown(); ?>
                            </ul>
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
                                //echo "<h4>Provas</h4><br><p>Nenhuma Turma Selecionada</p>";     
                            }else{
                                echo "<h4>Provas</h4><br>".listProvas();   
                            }
                        ?>
                        </div>

                        <div class="row">
                            <?php
                             if(isset($_GET['idA'])){
                                 $sql = "SELECT COUNT(*) AS 'quant' FROM correcoes AS co WHERE co.id_correcoes_turma = {$_GET['idT']} AND co.id_correcoes_avaliacao = {$_GET['idA']} AND co.id_correcoes_professor = $id_user";
                                 $result = $conn->query($sql);
                                 $row = $result->fetch_assoc();
                                 
                                 
                                 $sql2 = "SELECT COUNT(*) AS 'quant' FROM aluno AS a WHERE a.id_aluno_turma = {$_GET['idT']} AND a.id_aluno_professor = $id_user";
                                 $result2 = $conn->query($sql2);
                                 $row2 = $result2->fetch_assoc();
                                 
                                echo "<div class='col-md-6'>
                                        <div class='card card-chart'>
                                            <div class='card-header card-header-warning' style='background-color: white'>
                                                <div class='ct-chart' id='chart'></div>
                                            </div>
                                            <!-- <div class='card-body' style='margin: 15px'>
                                            <h4 class='card-title'>Rendimento</h4>
                                            <p class='card-category'>Last Campaign Performance</p>
                                                </div> -->
                                            <div class='card-footer' style='display: flex;flex-direction: row;justify-content: space-around;'>
                                                <div class='stats'>
                                                    <i class='material-icons'>person</i>
                                                    <a href='#' style='color: inherit;'><strong>{$row['quant']}</strong> correções de <strong>{$row2['quant']}</strong> alunos</a>
                                                </div>
                                                <div class='stats'>
                                                    <i class='material-icons'>person</i>
                                                    <a href='#' style='color: inherit;'>Alunos restantes para corrigir</a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>";    
                             }
                            ?>

                                <!-- <div class="col-md-6">
                                <div class="card card-chart">
                                    <div class="card-header card-header-warning" style="background-color: white">
                                        <div class="ct-chart" id="chart2"></div>
                                    </div>
                                    <div class="card-body" style="margin: 15px">
                                    <h4 class="card-title">Rendimento</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> Atualizado a x minutos
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>

                        <div class="row">

                            <?php echo geraTabelaAlunos(); ?>

                            <?php
                             if(isset($_GET['idAL'])){
                                 
                                 $sql = "SELECT COUNT(*) AS 'quant' FROM correcoes AS co WHERE co.id_correcoes_turma = {$_GET['idT']} AND co.id_correcoes_avaliacao = {$_GET['idA']} AND co.id_correcoes_professor = $id_user";
                                 $result = $conn->query($sql);
                                 $row = $result->fetch_assoc();
                                 
                                 
                                 $sql2 = "SELECT COUNT(*) AS 'quant' FROM aluno AS a WHERE a.id_aluno_turma = {$_GET['idT']} AND a.id_aluno_professor = $id_user";
                                 $result2 = $conn->query($sql2);
                                 $row2 = $result2->fetch_assoc();
                                 
                                echo "<div class='col-md-6'>
                                        <div class='card card-chart'>
                                            <div class='card-header card-header-warning' style='background-color: white'>
                                                <div class='ct-chart' id='alunoxturma'></div>
                                            </div>
                                            <!-- <div class='card-body' style='margin: 15px'>
                                            <h4 class='card-title'>Rendimento</h4>
                                            <p class='card-category'>Last Campaign Performance</p>
                                                </div> -->
                                            <div class='card-footer' style='display: flex;flex-direction: row;justify-content: space-around;'>
                                                <div class='stats'>
                                                    <i class='material-icons'>person</i>
                                                    <a href='#' style='color: inherit;'><strong>{$row['quant']}</strong> correções de <strong>{$row2['quant']}</strong> alunos</a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>";    
                             }
                            ?>
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
            <?php
             echo geraGraficoAcertosPorQuestao();
             echo geraGraficoAlunoXTurma();
            ?>

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



        });

    </script>

</html>
