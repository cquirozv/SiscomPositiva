<?php
if(isset($_POST['Usuario']) != ""){
		include("../../funciones/funciones.php");
		include("../../Classes/SED.php");

		if($_REQUEST){
			 $Usuario = $_POST['Usuario'];
			 $Contrasena = $_POST['Contrasena'];

			//$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    		//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $Contrasena, MCRYPT_MODE_CBC, md5(md5($key))));
			$encrypted = SED::encryption($Contrasena);

			actualizarContasena($Usuario,$encrypted);	
		}
	}else{
		header('Location: ../../index.php');
	}
?>