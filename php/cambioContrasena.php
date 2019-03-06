<?php 
	$usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;
	
	if(isset($usuario) != ""){
?>
<!DOCTYPE html>
<html>
<head>
	<title>SISCOM PDV</title>
		<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../css/pop.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../js2/ui/interface/jquery-ui.css" type="text/css" media="screen" />
		<script src="../js2/jquery-1.12.0.min.js" type="text/javascript"></script>
		<script src="../js2/jquery.tablesorter.min.js" type="text/javascript"></script>
		<script src="../js2/jquery.equalHeight.js" type="text/javascript"></script>
		<script src="../js2/ui/interface/jquery-ui.js" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			//console.log("Entra al focus");
			//$("#usuario").focus();

			//Boton Login
			$("#aceptar").click(function(){
				var varUsuario = $("#UsuarioA").val();
				//var varLongUsuario = $("#Usuario").val().length;
				var varContrasena = $("#Contrasena").val();
				var varLongContrasena = $("#Contrasena").val().length;
				var varContrasena1 = $("#Contrasena1").val();
				var varLongContrasena1 = $("#Contrasena1").val().length;

				varUsuario = varUsuario.trim();
				varContrasena = varContrasena.trim().toLowerCase();
				varContrasena1 = varContrasena1.trim().toLowerCase();
				//console.log(varUsuario+" "+varContrasena+" "+varContrasena1);
				
				if(varContrasena == "" || varContrasena1 == ""){
					$("#mensaje").html("<h4 class='alert_error'>Error: No se ha informado la Contraseña del Usuario.</h4>");
					$("#Contrasena").val("");
					$("#Contrasena1").val("");
						if(varContrasena == ""){
							$("#Contrasena").focus();
						}else{
							$("#Contrasena1").focus();
						}
					return false;
				}else if(varLongContrasena < 6 || varLongContrasena1 < 6){
					$("#mensaje").html("<h4 class='alert_warning'>Error: La Contraseña debe ser mayor a 6 caracteres.</h4>");
					$("#Contrasena").val("");
					$("#Contrasena1").val("");
						if(varContrasena < 6){
							$("#Contrasena").focus();
						}else{
							$("#Contrasena1").focus();
						}
					return false;
				}else{
					if(varContrasena != varContrasena1){
						$("#mensaje").html("<h4 class='alert_error'>Error: Las Contraseñas no son iguales.</h4>");
						$("#Contrasena").val("");
						$("#Contrasena1").val("");
							$("#Contrasena").focus();
							$("#Contrasena1").focus();	
						return false;
					}else{
						$("#Usuario").val("");
						$("#Contrasena").val("");
						$("#Contrasena1").val("");
						$("#Nombre").val("");
						
							var dataString = {
								'Usuario' : varUsuario,
								'Contrasena' : varContrasena
							};

							$.ajax({
								type: "POST",
								url: "comp/actualizarContrasena.php",
								data: dataString,
								beforeSend: function() {
									$('#mensaje').html("<center><img src='../images/viajemosload.gif' /></center>");//text('Loading...');
								},
								success: function(data){
									if(data == "1"){
										$("#mensaje").fadeIn(1000).html("<h4 class='alert_success'>Contraeña Actualizada Correctamente</h4>");
											//console.log(varCodigoPaciente);
												//return false;
												window.location.href = "../index.php";
												
										}else{
											$("#mensaje").fadeIn(1000).html(data);
											return false;
										}
									}
							});
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
	</script>

</head>
<body>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a>Bienvenido a SISCOM PDV</a></h1>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
		
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><div class="breadcrumb_divider"></div><a class="current">Actualizar Contraseña</a></article>
		</div>
	</section><!-- end of secondary bar -->

	<aside id="sidebar" class="column">
	
	</aside>
	
	<center>
	<section id="main" class="column">
	<div id="mensaje"></div>
		<div id="info"></div>
			<article class="module width_full">
			<header><h3></h3></header>
				<div class="module_content">
					<article class="stats_overview">
						<div class="module_content">
							<input type="text" id="UsuarioA" name="usuario" value="<?php echo $usuario; ?>"  disabled style="width:89%;">
							<p><input type="password" id="Contrasena" name="" placeholder="Contraseña" style="width:89%; margin-top: 1%;"></p>
							<p><input type="password" id="Contrasena1" name="" placeholder="Nuevamente Contraseña" style="width:89%; margin-top: 1%;"></p>
						</div>
					<center>
						<div>
							<input type="reset" id="cancelar" name="" value="Cancelar"> 
							<input type="submit" id="aceptar" name="" value="Actualizar Contraseña"> 
						</div>
					</center>	
					</article>
					<div class="clear"></div>
				</div>
			</article>
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2017 SISCOM</strong></p>
		</footer>
	</section>
	</center>
</body>
</html>
<?php
	}else{
		header('Location: ../index.html');
	}
?>