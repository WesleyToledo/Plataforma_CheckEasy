<?php
	session_start();
	unset($_SESSION["nomeUser"]);
	unset($_SESSION["permission"]);
	session_destroy();
	header("Location:index.html");
?>