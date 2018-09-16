
<?php session_start();

	  if(!isset($_SESSION["nome"]) AND ($_SESSION["id_user"])){
	  	header("Location:index.php");   
	  }
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Material Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />

    <!-- data-backgroud-color -->
    <link rel="stylesheet" href="assets/css/data-background-color.css">


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

</head>

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
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li  class="">
                        <a href="home.php">
                            <i class="material-icons">dashboard</i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="turmas.php">
                            <i class="material-icons">group</i>
                            <p>Turmas</p>
                        </a>
                    </li>
                    <li>
                        <a href="./provas.html">
                            <i class="material-icons">assignment</i>
                            <p>Provas</p>
                        </a>
                    </li>
                    <li>
                        <a href="./estatisticas.html">
                            <i class="material-icons">pie_chart</i>
                            <p>Estatísticas</p>
                        </a>
                    </li>
                </ul>
            </div>
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
                        <a class="navbar-brand" href="#">Perfil</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
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
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
                        <div class="col-md-4">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="#chicao">
                                        <img class="img" src="assets/img/users/chico.jpg"/>
                                    </a>
                                </div>
                                <div class="content">
                                    <h6 class="category text-gray">Professor no IFSULDEMINAS - Campus Inconfidentes</h6>
                                    <h4 class="card-title"><?php echo $nome;?></h4>
                                    <p class="card-content">
                                        Possui graduação em Licenciatura Plena em Física pela UFAM (2004), mestrado em Física da Matéria Condensada pela UFAM (2008) e Doutorado em Materiais para a Engenharia pela UNIFEI (2016).
                                    </p>

                                    <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" data-background-color="blue400">
                                    <h4 class="title">Editar Perfil</h4>
                                    <!-- <p class="category">&nbsp;</p> -->
                                </div>
                                <div class="card-content">
                                    <form>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fa fa-user"></i></span>Primeiro Nome</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fa fa-user"></i></span>Sobrenome</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fa fa-address-card"></i></span>Nome de Usuário</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fa fa-envelope"></i></span>E-mail</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fas fa-university"></i></span>Instituição</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fas fa-building"></i></span>Cidade</label>
                                                    <input type="email" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">CEP</label>
                                                    <input type="text" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label style="color: #999 !important;">Sobre</label>
                                                    <div class="form-group label-floating" >
                                                        <label class="control-label"><span><i class="fa fa-book-open"></i></span>Breve Currículo</label>
                                                        <textarea name="" id="" cols="20" rows="5" class="form-control is-focused" style="border: 1px #ccc solid" style="width: 100%;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><span><i class="fa fa-lock"></i></span>Senha</label>
                                                    <input type="password" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>


                                        <button type="submit" class="btn btn-info pull-right">Salvar alterações</button>
                                        <div class="clearfix"></div>
                                    </form>
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
</body>
<!--   Core JS Files   -->
<script src="assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Material Dashboard javascript methods -->
<script src="assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

</html>