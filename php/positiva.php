<?php 
	session_start();

	if(isset($_SESSION["idusuario"]) != ""){
		$privilegio = $_SESSION["privilegios"];
		$idusuario = $_SESSION["idusuario"];
		include("../funciones/funciones.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>SISCOM para Viajemos</title>
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
		<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../css/pop.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../js2/ui/interface/jquery-ui.css" type="text/css" media="screen" />
		<script src="../js2/jquery-1.12.0.min.js" type="text/javascript"></script>
		<script src="../js2/jquery.tablesorter.min.js" type="text/javascript"></script>
		<script src="../js2/jquery.equalHeight.js" type="text/javascript"></script>
		<script src="../js2/ui/interface/jquery-ui.js" type="text/javascript"></script>
		<script src="../js2/jquery.maskedinput.min.js" type="text/javascript"></script>
		<script src="../js2/hora/jquery.timepicker.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="../css/defaultTheme.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../css/myTheme.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../js2/hora/jquery.timepicker.min.css" type="text/css" media="screen" />
		<script src="../js2/jquery.fixedheadertable.js" type="text/javascript"></script>
		<script src="../js2/jquery.fixedheadertable.min.js" type="text/javascript"></script>
		<script src="../css/jquery.mousewheel.js" type="text/javascript"></script>
	
	<script>
		$(document).ready(function() {
			$("#NumSolicitud").focus();
			$("#IdBusqueda").css("display", "none");

			//----- Deshabilitar Boton de Buscar ---------------------------------------------------------
				$("#BuscarSolicitud").attr('disabled',true);
				$("#BuscarAnexo").attr('disabled',true);
			//--------------------------------------------------------------------------------------------

			//---- Habilitar Boton de Buscar -------------------------------------------------------------
				$("#NumSolicitud").keyup(function(event){
					$("#BuscarSolicitud").attr('disabled',false);
				});

				$("#NumAnexo").keyup(function(event){
					$("#BuscarAnexo").attr('disabled',false);
				});
			//--------------------------------------------------------------------------------------------

			$("#NumAnexo").keyup(function (){
            		this.value = (this.value + '').replace(/[^0-9]/g, ''); //Solo numeros
          		});

			$("#NumSolicitud").keyup(function (){
            		this.value = (this.value + '').replace(/[^0-9]/g, ''); //Solo numeros
          		});

			//---- Buscar Servicio -----------------------------------------------------------------------
				$("#BuscarSolicitud").click(function(event){
					var varNumSolicitud = $("#NumSolicitud").val();

					if(varNumSolicitud != ""){
						$("#NumSolicitud").val("");

						var dataString = {
							'NumSolicitud' : varNumSolicitud,
							'Flag' : 2
						}

						$.ajax({
							type: "POST",
							url: "servicios/BuscarServicio.php",
							data: dataString,
							beforeSend: function() {
								$('#mensaje').html("<center><img src='../images/carga.gif'/></center>");
							},
							success: function(data){	
								//console.log(varNumServicio);
								$('#mensaje').html("");
								$("#IdBusqueda").css("display", "block");
								$("#ResBusqueda").html(data);
								
							}
						});

					}else{
						$("#mensaje").html("<h4 class='alert_warning'>El Numero de Solicitud es Obligatorio.</h4>");
						$("#NumSolicitud").focus();
					}
				});
			//--------------------------------------------------------------------------------------------

			//---- Buscar Anexo -----------------------------------------------------------------------
				$("#BuscarAnexo").click(function(event){
					var varNumAnexo = $("#NumAnexo").val();

					if(varNumAnexo != ""){
						$("#NumAnexo").val("");

						var dataString = {
							'NumSolicitud' : varNumAnexo,
							'Flag' : 4
						}

						$.ajax({
							type: "POST",
							url: "servicios/BuscarServicio.php",
							data: dataString,
							beforeSend: function() {
								$('#mensaje').html("<center><img src='../images/carga.gif'/></center>");
							},
							success: function(data){	
								console.log(data);
								$('#mensaje').html("");
								$("#IdBusqueda").css("display", "block");
								$("#ResBusqueda").html(data);
								
							}
						});

					}else{
						$("#mensaje").html("<h4 class='alert_warning'>El Numero de Anexo es Obligatorio.</h4>");
						$("#NumAnexo").focus();
					}
				});
			//--------------------------------------------------------------------------------------------

		});	
	</script>
</head>
<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a>VIAJEMOS por COLOMBIA</a></h1>
			<h2 class="section_title"></h2><div class="btn_view_site"><?php echo "<a href='cerrarSesion.php'>Log Out</a>"; ?></div>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo strtoupper($_SESSION["nombre"]); ?></p>
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><div class="breadcrumb_divider"></div><a class="current">Inicio</a></article>
		</div>
	</section><!-- end of secondary bar -->

	<!-- Columna de Menus-->
	<aside id="sidebar" class="column">
		<hr/>
		<form class="quick_search">
			<!-- <input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;"> -->
		</form>
			<?php // Contenidos(1,$privilegio,$idusuario); ?>
			<p><IMG SRC="../images/siscomvc.png" BORDER=0 VSPACE=3 HSPACE=3></p>
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2017 SISCOM</strong></p>
		</footer>
	</aside><!-- end of sidebar -->

	<!-- Columna de Informacion de Contenidos-->
	<section id="main" class="column">
		<article class="module width_full">
			<header><h3>Busqueda de Solicitudes</h3></header>
			<div class="module_content">
				<fieldset style="width:30%; float:left;">
					<p><input type="text" id="NumSolicitud" placeholder="Numero de Solicitud" style="width:89%; margin-top: 1%; font-size: 18px; text-align: center;"></p>
						<center>
							<p><input type="submit" id="BuscarSolicitud" name="" value="Buscar Solicitud" style="width:89%; margin-top: 1%; font-size: 18px;"></p>			
						</center>
				</fieldset>
			</div>

			<div class="module_content">
				<fieldset style="width:30%; float:left; margin-left: 20%">
					<p><input type="text" id="NumAnexo" placeholder="Numero de Anexo" style="width:89%; margin-top: 1%; font-size: 18px; text-align: center;"></p>
						<center>
							<p><input type="submit" id="BuscarAnexo" name="" value="Buscar Anexo" style="width:89%; margin-top: 1%; font-size: 18px;"></p>			
						</center>
				</fieldset>
			</div>

			<div id="IdBusqueda">
				<div class="module_content">
					<fieldset style="width:100%; float:left;">
					<center><h2>Resumen de Solicitud Encontrada</h2></center>
						<div id="ResBusqueda"></div>
					</fieldset>	
				</div>
			</div>

			<div class="clear"></div>
		</article>

		
		 <!-- end of stats article -->
	</section>
</body>
</html>
<?php
	}else{
		header('Location: ../index.php');
	}
?>