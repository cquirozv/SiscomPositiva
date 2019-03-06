<?php
session_start();
	if(isset($_SESSION["idusuario"]) != ""){
			$idusuario = $_SESSION["idusuario"];
	include("../../../../funciones/funciones.php");
			LogRed("CerrarSesion",$idusuario);
		session_destroy();
		header('Location: ../../../../index.php');
		exit(0);
	}else{
		header('Location: ../../../../index.php');
	}
?>