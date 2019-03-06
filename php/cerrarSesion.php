<?php 
	session_start();
	if(isset($_SESSION["idusuario"]) != ""){
			$idusuario = $_SESSION["idusuario"];
			$usuario = $_SESSION["usuario"];
			include("../funciones/funciones.php");
			LogRed("CerrarSesion",$idusuario,$usuario);
		session_destroy();
		header('Location: ../index.php');
		exit(0);
	}else{
		header('Location: ../index.php');
	}
?>