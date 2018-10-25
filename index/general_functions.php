<?php
    include("conexao.php");
    
	if(!isset($_SESSION["login"])){
		header("Location: login.html");
	}
    
    $id_user = $_SESSION["id_user"];
    $nome = $_SESSION["nome"];


    function setSidebar_wrapper($active){
        
        $active1 = '';       
        $active2 = '';       
        $active3 = '';       
        $active4 = ''; 
        
        switch($active){
                case 'home':
                    $active1 = 'active';
                    break;
                case 'turmas':
                    $active2 = 'active';
                    break;
                case 'provas':
                    $active3 = 'active';
                    break;
                case 'estatisticas':
                    $active4 = 'active';
                    break;
        }
        
        $html = "<div class='sidebar-wrapper'>
                <ul class='nav'>
                    <li class='$active1'>
                        <a href='home.php'>
                            <i class='material-icons'>dashboard</i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class='$active2'>
                        <a href='./turmas.php?id=all&c=blue400'>
                            <i class=material-icons>group</i>
                            <p>Turmas</p>
                        </a>
                    </li>
                    <li class='$active3'>
                        <a href='./provas.php'>
                            <i class='material-icons'>assignment</i>
                            <p>Provas</p>
                        </a>
                    </li>
                    <li class='$active4'>
                        <a href='./estatisticas.php?idT=all'>
                            <i class='material-icons'>pie_chart</i>
                            <p>Estatísticas</p>
                        </a>
                    </li>
                </ul>
            </div>";
        
        return $html;
    }
    
function userDropDown(){
    return "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                    <i class='material-icons'>person</i>
                    <p class='hidden-lg hidden-md'>Notifications</p>
                </a>
                <ul class='dropdown-menu'>
                    <li>
                        <a href='user.php'><i class='material-icons' style='font-size: 1.6em;margin:0px 10px 0px 10px'>person</i>Profile</a>
                    </li>
                    <li>
                        <a href='#'><i class='material-icons' style='font-size: 1.6em;margin:0px 10px 0px 10px'>keyboard_tab</i>Profile</a>
                    </li>
                </ul>
            </li>";
}



?>
