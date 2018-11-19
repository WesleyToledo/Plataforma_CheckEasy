<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Plataforma CheckEasy</title>
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

<?php
    session_start();
    
    include("general_functions.php");
    include("conexao.php");
    
	if(!isset($_SESSION["login"])){
		header("Location: login.html");
	}
    
    $id_user = $_SESSION["id_user"];
    $nome = $_SESSION["nome"];
    

    function initUserEdit(){
        include("conexao.php");
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        
        $sql = "SELECT * FROM professor WHERE idprofessor=$id_user";
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $primeiro_nome = $row["primeiro_nome"];
                $sobrenome = $row["sobrenome"];
                $nome_user = $row["nome_user"];
                $email = $row["email"];
                $instituicao = $row["instituicao"];
                $cidade = $row["cidade"];
                $estado = $row["estado"];
                $cep = $row["cep"];
                $curriculo = $row["curriculo"];
                $senha = $row["senha"];
                
                $html .= "<div class='col-md-8'>
                            <div class='card'>
                                <div class='card-header' data-background-color='blue400'>
                                    <h4 class='title'>Editar Perfil</h4>
                                    <!-- <p class='category'>&nbsp;</p> -->
                                </div>
                                <div class='card-content'>
                                    <form action='editarUser.php' method='post'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fa fa-user'></i></span>Primeiro Nome</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$primeiro_nome' name='nome'>
                                                </div>
                                            </div>

                                            <div class='col-md-6'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fa fa-user'></i></span>Sobrenome</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$sobrenome' name='sobrenome'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fa fa-address-card'></i></span>Nome de Usuário</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$nome_user' name='nome_user'>
                                                </div>
                                            </div>

                                            <div class='col-md-6'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fa fa-envelope'></i></span>E-mail</label>
                                                    <input type='email' class='form-control' style='width: 100%;' value='$email' name='email'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fas fa-university'></i></span>Instituição</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$instituicao' name='instituicao'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><span><i class='fas fa-building'></i></span>Cidade</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$cidade' name='cidade'>
                                                </div>
                                            </div>
                                            <div class='col-md-3'>
                                                <div class='form-group label-floating'>
                                                    <select name='estado' class='form-control' style='width: 100%;' required name='estado'>
                                                        <option value='$estado'>$estado</option>
                                                        <option value='Acre'>Acre</option>
                                                        <option value='Alagoas'>Alagoas</option>
                                                        <option value='Amapá'>Amapá</option>
                                                        <option value='Amazonas'>Amazonas</option>
                                                        <option value='Bahia'>Bahia</option>
                                                        <option value='Ceará'>Ceará</option>
                                                        <option value='Distrito Federal'>Distrito Federal</option>
                                                        <option value='Espirito Santo'>Espirito Santo</option>
                                                        <option value='Goiás'>Goiás</option>
                                                        <option value='Maranhão'>Maranhão</option>
                                                        <option value='Mato Grosso do Sul'>Mato Grosso do Sul</option>
                                                        <option value='Mato Grosso''>Mato Grosso</option>
                                                        <option value='Minas Gerais'>Minas Gerais</option>
                                                        <option value='Pará'>Pará</option>
                                                        <option value='Paraíba'>Paraíba</option>
                                                        <option value='Paraná'>Paraná</option>
                                                        <option value='Pernambuco'>Pernambuco</option>
                                                        <option value='Piauí'>Piauí</option>
                                                        <option value='Rio de Janeiro'>Rio de Janeiro</option>
                                                        <option value='Rio Grande do Norte'>Rio Grande do Norte</option>
                                                        <option value='Rio Grande do Sul'>Rio Grande do Sul</option>
                                                        <option value='Rondônia'>Rondônia</option>
                                                        <option value='Roraima'>Roraima</option>
                                                        <option value='Santa Catarina'>Santa Catarina</option>
                                                        <option value='São Paulo'>São Paulo</option>
                                                        <option value='Sergipe'>Sergipe</option>
                                                        <option value='Tocantins'>Tocantins</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class='col-md-3'>
                                                <div class='form-group label-floating'>
                                                    <label class='control-label'><i class='fas fa-building'></i>CEP</label>
                                                    <input type='text' class='form-control' style='width: 100%;' value='$cep' name='cep'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label style='color: #999 !important;'>Sobre</label>
                                                    <div class='form-group label-floating' >
                                                        <label class='control-label'><span><i class='fa fa-book-open'></i></span>Breve Currículo</label>
                                                        <textarea name='curriculo' cols='20' rows='5' class='form-control is-focused' style='border: 1px #ccc solid' style='width: 100%;' name='curriculo'>$curriculo</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <button type='button' class='btn pull-left' style='margin:15px;padding:12px;background: linear-gradient(45deg, #1de099, #1dc8cd)' data-toggle='modal' data-target='#novaSenha'>Alterar Senha</button>
                                        </div>
                                        
                                        <button type='submit' id='submit' class='btn pull-right' style='background: linear-gradient(45deg, #1de099, #1dc8cd)'>Salvar alterações</button>
                                            
                                        <div class='clearfix'></div>
                                    </form>
                                </div>
                            </div>
                        </div>";
            }
        } else {
        }
        
        return $html;
        
    }
    
    
    function initUserFolder(){
        include("conexao.php");
        
        $id_user = $_SESSION["id_user"];
        $nome = $_SESSION["nome"];
        $html = "";
        
        $sql = "SELECT primeiro_nome,sobrenome,instituicao,curriculo FROM professor WHERE idprofessor=$id_user";
        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $primeiro_nome = $row["primeiro_nome"];
                $sobrenome = $row["sobrenome"];
                $instituicao = $row["instituicao"];
                $curriculo = $row["curriculo"];
                
                $html .= "<div class='card card-profile'>
                                    <div class='card-avatar'>
                                        <a href='#chicao'>
                                        <img class='img' src='assets/img/users/chico.jpg'/>
                                    </a>
                                    </div>
                                    <div class='content'>
                                        <h6 class='category text-gray' style='margin: 15px;'>Professor no(a) $instituicao</h6>
                                        <h4 class='card-title'>$nome $sobrenome</h4>
                                        <p class='card-content'>
                                            $curriculo
                                        </p>
                                        <!-- <a href='#' class='btn btn-primary btn-round'>Follow</a> -->
                                    </div>
                            </div>";
            }
        } else {
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

                <?php echo setSidebar_wrapper(''); ?>

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
                            <div class="col-md-4">
                                <?php  echo initUserFolder();  ?>
                            </div>

                            <?php echo initUserEdit(); ?>

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

        <div class='modal fade' id='novaSenha' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                        <h3 class='modal-title mx-auto' id='lineModalLabel'>Nova Senha</h3>
                    </div>
                    <div class='modal-body'>
                        <!-- content goes here -->
                        <form action='cadastrarNovaSenhaUser.php' method='post'>
                            <div class='form-group'>
                                <label>Nova senha</label>
                                <input type='password' name='senhaAnterior' class='form-control' name='nome_turma'>
                            </div>
                            <div class='form-group'>
                                <label>Confirmar nova senha</label>
                                <input type='password' name='senhaAnteriorC' class='form-control' name='nome_turma'>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' id='submitSenha' class='btn' disabled style="background: linear-gradient(45deg, #1de099, #1dc8cd)">Salvar Alteração</button>
                            </div>
                        </form>
                    </div>
                </div>
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
    <script src="assets/js/jquery.maskedinput-1.1.4.pack.js"></script>
    <script src="assets/js/demo.js"></script>
    <script type="text/javascript">
        
        $(function() { // declaro o início do jquery
            $("input[name='email']").blur(function() {
                var email = $("input[name='email']").val();
                var idUser = <?php echo $_SESSION["id_user"]; ?>

                //alert(email);
                $.post('general_functions_JS.php?a=VEmailUser', {
                    email: email,
                    id_user: idUser
                }, function(data) {
                    var valor = data.toString();
                    valor = valor.substring(1, valor.length)

                    if (valor === 'usado') {
                        //alert("Este email já está sendo usado");
                        //from/align/message/icon
                        demo.showNotification('top', 'right', 'Este e-mail já está sendo usado', 'danger', 'email')
                        $("input[name='email']").focus()
                    }
                });
            });


            $("input[name='nome_user']").blur(function() {
                var nomeUser = $("input[name='nome_user']").val();
                var idUser = <?php echo $_SESSION["id_user"]; ?>

                $.post('general_functions_JS.php?a=VNomeUserUser', {
                    nomeUser: nomeUser,
                    id_user: idUser
                }, function(data) {

                    var valor = data.toString();
                    valor = valor.substring(1, valor.length)

                    if (valor === 'usado') {
                        //alert("Este email já está sendo usado");
                        //from/align/message/icon
                        demo.showNotification('top', 'right', 'Este nome de usuário já está sendo usado', 'danger', 'person')
                        $("input[name='nome_user']").focus();
                    }
                });
            });

            $("input[name='senhaAnteriorC']").blur(function() {
                var senha = $("input[name='senhaAnterior']").val();
                var Csenha = $("input[name='senhaAnteriorC']").val();
                
                if (Csenha.toString() !== senha.toString()) {
                    $("input[name='senhaAnterior']").focus()
                    document.querySelector('#submitSenha').disabled = true
                    demo.showNotification('top', 'right', 'Senhas não coincidem', 'danger', 'lock')
                } else {
                    document.querySelector('#submitSenha').disabled = false;
                }
            });





        }); // fim do jquery

        $(document).ready(function() {
            $("input[name='cep']").mask("99.999-999");
        });



    </script>

</html>
