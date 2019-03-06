<?php
session_start();
if(isset($_SESSION["idusuario"]) != ""){
	$CodigoServicio = isset($_GET["CodigoServicio"]) ? $_GET["CodigoServicio"] : null;
	if($CodigoServicio  != ""){
		include("../funciones/funciones.php");
		require("../fphp/fpdf.php");

		$Marcador1 = "";
		$imagePath1 = "";
		$Marcador2 = "";
		$imagePath2 = "";

		$conexionMkr1 = ConMySQL();
		$sqlMkr1 = "call sp_MarkerMaps('".mysqli_real_escape_string($conexionMkr1,$CodigoServicio)."',1);";
		$resultMkr1 = mysqli_query($conexionMkr1,$sqlMkr1);
			if(mysqli_num_fields($resultMkr1) >= 0){ 
				while($rowMkr1 = mysqli_fetch_array($resultMkr1)){
					$Marcador1 = $rowMkr1[0];
				}
			}else{
				echo 'Error: No se Encontro Informacion del Servicio.';
			}
		mysqli_free_result($resultMkr1);
		DesMysql($conexionMkr1);


		$conexionMkr2 = ConMySQL();
		$sqlMkr2 = "call sp_MarkerMaps('".mysqli_real_escape_string($conexionMkr2,$CodigoServicio)."',2);";
		$resultMkr2 = mysqli_query($conexionMkr2,$sqlMkr2);
			if(mysqli_num_fields($resultMkr2) >= 0){ 
				while($rowMkr2 = mysqli_fetch_array($resultMkr2)){
					$Marcador2 = $rowMkr2[0];
				}
			}else{
				echo 'Error: No se Encontro Informacion del Servicio.';
			}
		mysqli_free_result($resultMkr2);
		DesMysql($conexionMkr2);

		if($Marcador1 != "NULL"){
			$src = 'https://maps.googleapis.com/maps/api/staticmap?center='.$Marcador1.'&zoom=12&size=300x300&key=AIzaSyDWe7m06fwxnTWDSKHKtHIxDj8zgPb33-c';
		    $tipo = 1;
		    $desFolder = '../mapas/';
		    $imageName = $CodigoServicio.'_'.$tipo.'.png';
		    $imagePath1 = $desFolder.$imageName;
		    file_put_contents($imagePath1,file_get_contents($src));
		}

		if($Marcador2 != "NULL"){
			$src = 'https://maps.googleapis.com/maps/api/staticmap?center='.$Marcador2.'&zoom=12&size=300x300&key=AIzaSyDWe7m06fwxnTWDSKHKtHIxDj8zgPb33-c';
		    $tipo = 2;
		    $desFolder = '../mapas/';
		    $imageName = $CodigoServicio.'_'.$tipo.'.png';
		    $imagePath2 = $desFolder.$imageName;
		    file_put_contents($imagePath2,file_get_contents($src));
		}


		$FechaAutorizacion = "";
		$NumSolicitud = "";
		$Tipo = "";
		$LinEmpleador = "";
		$NumDocumento = "";
		$NomUsuario = "";
		$NumCeluldar = "";
		$TipoTraslado = "";
		$TipoTrayecto = "";
		$FechaCita = "";
		$TiempoTransalado1 = "";
		$KmRecorrido1 = "";
		$TiempoTransalado2 = "";
		$KmRecorrido2 = "";
		$Proveedor1 = "";
		$NumAnexo1 = "";
		$DirOrigen = "";
		$Proveedor2 = "";
		$NumAnexo2 = "";
		$DirDestino = "";
		$HoraIniServIda = "";
		$HoraIniServRet = "";
		$TipoTrayectoNum = "";

		$Empresa = 'Viajemos por Colombia SAS';

		//$Marcador1 = '<img src="https://maps.googleapis.com/maps/api/staticmap?center=40.714728,-73.998672&markers=color:red%7Clabel:C%7C40.718217,-73.998284&zoom=12&size=300x300"/>';

		$conexion = ConMySQL();
		$sql = "call sp_RptInfServicio('".mysqli_real_escape_string($conexion,$CodigoServicio)."');";
		$result = mysqli_query($conexion,$sql);
			if(mysqli_num_fields($result) >= 0){ 
				while($row = mysqli_fetch_array($result)){
					$FechaAutorizacion = $row[0];
					$NumSolicitud = $row[1];
					$Tipo = $row[2];
					$LinEmpleador = $row[3];
					$NumDocumento = $row[4];
					$NomUsuario = $row[5];
					$NumCeluldar = $row[6];
					$TipoTraslado = $row[7];
					$TipoTrayecto = $row[8];
					$FechaCita = $row[9];
					$TiempoTransalado1 = $row[10];
					$KmRecorrido1 = $row[11];
					$TiempoTransalado2 = $row[12];
					$KmRecorrido2 = $row[13];
					$Proveedor1 = $row[14];
					$NumAnexo1 = $row[15];
					$DirOrigen = $row[16];
					$Proveedor2 = $row[17];
					$NumAnexo2 = $row[18];
					$DirDestino = $row[19];
					$HoraIniServIda = $row[20];
					$HoraIniServRet = $row[21];
					$TipoTrayectoNum = $row[22];
				}
			}else{
				echo 'Error: No se Encontro Informacion del Servicio.';
			}
		mysqli_free_result($result);
		DesMysql($conexion);

		$pdf = new FPDF('P','mm','letter');
		$pdf->SetMargins(2, 2, 2); 
		$pdf->AddPage();

		$pdf->Image('../images/siscomvc.png',80,12,50,25);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetFont('Arial','',15);
		$pdf->Ln(35);
		$pdf->SetX(70);
		$pdf->MultiCell(0,8,$Empresa,0);
		$pdf->SetFont('Arial','',12);
		$pdf->Ln(10);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$FechaAutorizacion."                                                          ".$NumSolicitud,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$Tipo."          ".$LinEmpleador,0);
		$pdf->Line(18, 72 , 200, 72);
		$pdf->Ln(3);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$NumDocumento." ".$NomUsuario,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$NumCeluldar,0);
		$pdf->Ln(2);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$TipoTraslado."          ".$TipoTrayecto,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$FechaCita,0);
		$pdf->Line(18, 110 , 200, 110);
		$pdf->Ln(2);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$NumAnexo1."        ".$HoraIniServIda,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$Proveedor1,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$DirOrigen,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$KmRecorrido1."      ".$TiempoTransalado1,0);
		$pdf->Line(18, 147 , 200, 147);
		$pdf->Ln(2);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$NumAnexo2."        ".$HoraIniServRet,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$Proveedor2,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$DirDestino,0);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$KmRecorrido2."     ".$TiempoTransalado2,0);
		$pdf->Line(18, 184 , 200, 184);
		$pdf->Ln(1);
		$pdf->SetX(18);
		$pdf->MultiCell(0,8,$NumAnexo1."                                                   ".$NumAnexo2,0);
		if($TipoTrayectoNum == 1 || $TipoTrayectoNum == 2){ $pdf->Image($imagePath1,20,200,80,50);}
		if($TipoTrayectoNum == 2){ $pdf->Image($imagePath2,110,200,80,50);}
		$pdf->Output();

	}else{echo "Error al Generar el Informe del Servicio";}
}else{
	header('Location: nuevoservicio.php');
}
?>