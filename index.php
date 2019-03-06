<!DOCTYPE html>
<html>
<head>
	<title>SISCOM para Viajemos</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<script src="js2/jquery-1.12.0.min.js" type="text/javascript"></script>
	<script src="js2/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script src="js2/jquery.equalHeight.js" type="text/javascript"></script>
	<script src="js2/ui/interface/jquery-ui.js" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			//console.log("Entra al focus");
			$("#usuario").focus();

			//Boton Login
			$("#aceptar").click(function(){
				var usuario =  $("#usuario").val();
				var contrasena = $("#contrasena").val();
				var longusuario = $("#usuario").val().length;
				var longcontrasena = $("#contrasena").val().length;

				if(usuario == ""){
					$("#info").html("<h4 class='alert_error'>Error: No se ha informado el Nombre de Usuaio.</h4>");
					$("#usuario").val("");
					$("#usuario").focus();
					return false;
				}else if(contrasena == ""){
					$("#info").html("<h4 class='alert_error'>Error: No se ha informado la Contraseña del Usuaio.</h4>");
					$("#contrasena").val("");
					$("#contrasena").focus();
					return false;
				}else{
					$("#usuario").val("");
					$("#contrasena").val("");
					//alert("entra");
					if(longusuario < 6){
						$("#info").html("<h4 class='alert_warning'>El Nombre de Usuario debe ser mayor a 6 caracteres.</h4>");
						$("#usuario").focus();
						return false;
					}else if(longcontrasena < 6){
						$("#info").html("<h4 class='alert_warning'>La Contraseña debe ser mayor a 6 caracteres.</h4>");
						$("#usuario").focus();
						return false;
					}else{
						//$("#info").html("<img src='images/ajax-loader.gif'").fadeOut(5000);
						
						if(contrasena == "12345678.a"){
							$('#info').html("<center><img src='images/viajemosload.gif' /></center>");
							$(location).attr('href',"php/cambioContrasena.php?usuario="+usuario);	
						}else{
						var dataString = {'usuario': usuario, 'contrasena': contrasena};
						
							$.ajax({
								type: "POST",
								url: "php/iniciarSesion.php",
								data: dataString,
								beforeSend: function() {
									$('#info').html("<center><img src='images/viajemosload.gif' /></center>");//text('Loading...');
								},
								success: function(data){
									if(data == "1"){
										$("#info").fadeIn(1000).html("<h4 class='alert_success'>Conectando.</h4>");
										$(location).attr('href',"php/positiva.php");	
									}else{
										$("#info").fadeIn(1000).html(data);
									}
								}
							});
						}
					}
				}
			}); //Fin Boton Login

			//Boton cancelar
			$("#cancelar").click(function(){
				$("#usuario").val("");
				$("#contrasena").val("");

				$("#usuario").focus();
			}); //Fin Boton Login
		});

		//--- Ingresar con Tecla Enter ------------------------------------------------------
		$(window).bind('keydown', function(e) {				
		  	if (e.charCode == 13 || e.keyCode == 13) {//ENTER
		    //alert("Ha pulsado la tecla enter");
		    	var usuario =  $("#usuario").val();
				var contrasena = $("#contrasena").val();
				var longusuario = $("#usuario").val().length;
				var longcontrasena = $("#contrasena").val().length;

				if(usuario == ""){
					$("#info").html("<h4 class='alert_error'>Error: No se ha informado el Nombre de Usuaio.</h4>");
					$("#usuario").val("");
					$("#usuario").focus();
					return false;
				}else if(contrasena == ""){
					$("#info").html("<h4 class='alert_error'>Error: No se ha informado la Contraseña del Usuaio.</h4>");
					$("#contrasena").val("");
					$("#contrasena").focus();
					return false;
				}else{
					$("#usuario").val("");
					$("#contrasena").val("");
					//alert("entra");
					if(longusuario < 6){
						$("#info").html("<h4 class='alert_warning'>El Nombre de Usuario debe ser mayor a 6 caracteres.</h4>");
						$("#usuario").focus();
						return false;
					}else if(longcontrasena < 6){
						$("#info").html("<h4 class='alert_warning'>La Contraseña debe ser mayor a 6 caracteres.</h4>");
						$("#usuario").focus();
						return false;
					}else{
						//$("#info").html("<img src='images/ajax-loader.gif'").fadeOut(5000);
						
						if(contrasena == "12345678.a"){
							$('#info').html("<center><img src='images/viajemosload.gif' /></center>");
							$(location).attr('href',"php/cambioContrasena.php?usuario="+usuario);	
						}else{
						var dataString = {'usuario': usuario, 'contrasena': contrasena};
						
							$.ajax({
								type: "POST",
								url: "php/iniciarSesion.php",
								data: dataString,
								beforeSend: function() {
									$('#info').html("<center><img src='images/viajemosload.gif' /></center>");//text('Loading...');
								},
								success: function(data){
									if(data == "1"){
										$("#info").fadeIn(1000).html("<h4 class='alert_success'>Conectando.</h4>");
										$(location).attr('href',"php/positiva.php");	
									}else{
										$("#info").fadeIn(1000).html(data);
									}
								}
							});
						}
					}
				}
		  	}		
		});
		//-----------------------------------------------------------------------------------
	</script>

</head>
<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a>Bienvenido a SISCOM</a></h1>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><div class="breadcrumb_divider"></div><a class="current">LogIn</a></article>
		</div>
	</section><!-- end of secondary bar -->

	<aside id="sidebar" class="column">
		<p><IMG SRC="images/siscomvc.png" BORDER=0 VSPACE=3 HSPACE=3></p>
	</aside>
	
	<center>
	<section id="main" class="column">
		<h4 class="alert_info">SISCOM para Viajemos por Colombia</h4>
		<div id="info"></div>
			<article class="module width_full">
			<header><h3></h3></header>
				<div class="module_content">
					<article class="stats_overview">
						<div class="module_content">
							<p><IMG SRC="images/siscomvc1.png" BORDER=0 VSPACE=3 HSPACE=3></p>
							<p><input type="text" id="usuario" name="usuario" placeholder="Nombre de Usuario" style="width:89%; margin-top: 1%;"></p>
							<p></p>
							<p><input type="password" id="contrasena" name="" placeholder="Contraseña" style="width:89%; margin-top: 1%;"></p>
						</div>
					<center>
						<div>
							<input type="reset" id="cancelar" name="" value="Cancelar"> 
							<input type="submit" id="aceptar" name="" value="Iniciar Sesion"> 
						</div>
						</br>
					</center>	
					</article>
					<div class="clear"></div>
				</div>
			</article>
		<footer>
			<center>
				<IMG SRC="images/siscom.png" BORDER=0 VSPACE=3 HSPACE=3 height="80" width="120"></IMG></br>
				<strong>Copyright &copy; 2017 SISCOM por <a href="https://www.ingenieriaquv.com" target="_blank"> IngenieriaQuV </a></strong>
			</center>
		</footer>
	</section>
	</center>
</body>
</html>