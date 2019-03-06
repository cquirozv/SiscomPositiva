<?php 

	//Funcion Conectar a base de datos
	function ConMySQL(){
		$host = "localhost";
		$usuario = "root";
		$pass = "ca8610qv";
		$db = "bd_viajemos";

		$con = mysqli_connect($host,$usuario,$pass,$db);
		
		if(! $con){
			die("Error al Conectar a la MySQL...".mysql_error());
		}

		return $con;
	}//Fin Conexion a base de datos

	function DesMysql($conexion){
		$close = mysqli_close($conexion) or die ("No se ha podido cerrar la conexión");

		return $close;
	}

	//Funcion Log del Sistema
	function LogRed($descripcion,$idusuario,$IdServicio){
		$conexion = ConMySQL();
			$sql = "call sp_logred('".mysqli_real_escape_string($conexion,$descripcion)."',".mysqli_real_escape_string($conexion,$idusuario).",'".mysqli_real_escape_string($conexion,$IdServicio)."')";
			mysqli_query($conexion,$sql);
		DesMysql($conexion);
	}

	//Funcion Obtener los Menus de Contenido
	function Contenidos($menu,$privilegio,$idusuario){
		$conexion = ConMySQL();
		$sql= "call sp_menuboard(".mysqli_real_escape_string($conexion,$menu).",0,'".mysqli_real_escape_string($conexion,$privilegio)."',".mysqli_real_escape_string($conexion,$idusuario).");";
		$result = mysqli_query($conexion,$sql);
			while($row = mysqli_fetch_array($result)){
				$idcontenido = $row[0];
				echo $row[1];
				echo "<ul class='toggle'>";
				SubContenidos($idcontenido,$privilegio,$idusuario);
				echo "</ul>";
			}
		mysqli_free_result($result);
		DesMysql($conexion);
		//return $idcontenido;
	}

	//Funcion Obtener los Submenus para los Contenidos
	function SubContenidos($IdContenido,$privilegio,$idusuario){
		$conexion = ConMySQL();
		$sql= "call sp_menuboard(2,".mysqli_real_escape_string($conexion,$IdContenido).",'".mysqli_real_escape_string($conexion,$privilegio)."',".mysqli_real_escape_string($conexion,$idusuario).");";
		$result = mysqli_query($conexion,$sql);
			while($row = mysqli_fetch_array($result)){
				echo utf8_encode($row[1]);
			}
		mysqli_free_result($result);
		DesMysql($conexion);
	}


//----- Buscar Servicios -----------------------------------------
			function BuscarServicio($CodServicioUsr,$Flag){
				$conexion = ConMySQL();
				$sql1 = "call sp_BusquedaServicios('".mysqli_real_escape_string($conexion,$CodServicioUsr)."',".mysqli_real_escape_string($conexion,$Flag).")";
				$result1 = mysqli_query($conexion,$sql1);
				if(mysqli_num_rows($result1) >= 1){
					/*echo '<article class="module width_full">
									<header><h3>Servicios Activos</h3></header>
									<div class="module_content">'; */
				echo "<div class='fancyTable'>";
				echo "<center> <table id='tblServiciosAct'>";
				echo "<thead> 
						<tr> 
		    				<th>Fecha Ingreso SISCOM</th>
		    				<th>Num. Solicitud</th> 
		    				<th>Fecha Autorizacion</th>
		    				<th>Cedula</th> 
		    				<th>Nombre</th> 
		    				<th>Tel. Celular</th>
		    				<th>Tipo Traslado</th>
		    				<th>Tipo Trayecto</th>
		    				<th>Fecha Cita</th>
		    				<th>Descargar Informe</th>
							<th>Descargar Informe Rastra</th>
						</tr> 
						</thead>
						<tbody>";
						while($row1 = mysqli_fetch_array($result1)){
							echo "<tr>";
							echo "<td>".$row1[1]."</td>";
							echo "<td>".$row1[2]."</td>";
							echo "<td>".$row1[3]."</td>";
							echo "<td>".$row1[4]."</td>";
							echo "<td>".$row1[5]."</td>";
							echo "<td>".$row1[6]."</td>";
							echo "<td>".$row1[7]."</td>";
							echo "<td>".$row1[8]."</td>";
							echo "<td>".$row1[9]."</td>";
							//echo "<td>".$row1[10]."</td>";
							echo '<td><center><a href="RptServicio.php?CodigoServicio='.$row1[0].'" target="_blank">
								<img src="../images/RptPDF.png" ></a></center></td>';
							if($row1[11] == "Sin Archivo PDF"){
								echo '<td> <center>'.$row1[11].'</center> </td>';
							}else{
								echo '<td> <center> 
										<a href="'.$row1[11].'" target="_blank">
											<img src="../images/RptPDF.png" >
										</a>	
									  </center> </td>';
								};	
							echo "</tr>";
						}
				
				}else{
						echo '<h4 class="alert_error">No se Encotro la Solicitud: '.$CodServicioUsr.', Valide e Intente Nuevamente</h4>';
					}
				mysqli_free_result($result1);
				DesMysql($conexion);
			}
		//----------------------------------------------------------------

	//Actualizar Contraseña
	function actualizarContasena($Usuario,$Contrasena){
		$conexion = ConMySQL();
		$sql = "select count(0) as 'total' from sis_usuarios where usuario = '".mysqli_real_escape_string($conexion,$Usuario)."' and estado = 1;";
		$result = mysqli_query($conexion,$sql);
			if(mysqli_num_fields($result) >= 1){ 
				while($row = mysqli_fetch_array($result)){
					if($row[0] == 1){

						$sql1 = "update sis_usuarios set contrasena = '".mysqli_real_escape_string($conexion,$Contrasena)."' where usuario = '".mysqli_real_escape_string($conexion,$Usuario)."';";
						mysqli_query($conexion,$sql1);
						echo "1"; //Existe el Usuario 
					}else{
						echo '<h4 class="alert_error">Error: El Usuario Ingresado No Existe</h4>';
					}
				}
			}else {
				echo 'Error: No se Encontro Informacion, Contacte al Administrador';
			}
		mysqli_query($conexion,$sql);
		DesMysql($conexion);
	}
?>