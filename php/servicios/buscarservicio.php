<?php
session_start();

	if(isset($_SESSION["idusuario"]) != ""){
		include("../../funciones/funciones.php");
		
			if($_REQUEST){
				$NumSolicitud = $_POST["NumSolicitud"];
				$Flag = $_POST["Flag"];
				BuscarServicio($NumSolicitud,$Flag);
			}else{
				header('Location: ../nuevoservicio.php');
			}
	}else{
		header('Location: ../index.php');
	}
?>