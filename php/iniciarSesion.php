<?php
include("../funciones/funciones.php");
include("../Classes/SED.php");

sleep(1);

	if($_REQUEST){
		$conexion = ConMySQL();

		$usuario = htmlspecialchars($_POST["usuario"]);
		$contrasena = htmlspecialchars($_POST["contrasena"]);

		//$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    	//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $contrasena, MCRYPT_MODE_CBC, md5(md5($key))));
		$encrypted = SED::encryption($contrasena);
		
		$sql= "call sp_login('".mysqli_real_escape_string($conexion,$usuario)."','".mysqli_real_escape_string($conexion,$encrypted)."');";
		$result = mysqli_query($conexion,$sql);

		while($row = mysqli_fetch_array($result)){
			if(mysqli_num_fields($result) > 2){
				$resp = $row[0];
				$idusuario = $row[1];
				$usuario = $row[2];
				$nombre = $row[3];
				$privilegios = $row[4];
			}else{
				$resp = $row[0];
			}
		}

		mysqli_free_result($result);
		DesMysql($conexion);

		if($resp == "true"){
			session_start();
			$_SESSION["idusuario"] = $idusuario;
			$_SESSION["usuario"] = $usuario;
			$_SESSION["nombre"] = $nombre;
			$_SESSION["privilegios"] = $privilegios;
			LogRed("InicioSesion",$idusuario,$usuario);
			echo "1";
		}else if($resp == "false"){
			echo "<h4 class='alert_warning'>Usuario Invalido.</h4>";
		}else{
			echo "<h4 class='alert_error'>Error: No se ha establecido la conexion.</h4>";
		}
	}
?>