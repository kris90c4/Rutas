<?php 

	//define("__RAIZ__","C:\Users\Bender\Dropbox\FP Superior\2 Curso\Aplicaciones\Rutas");
	require 'vendor/autoload.php';
	define("__RAIZ__","Aplicaciones\Rutas");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gestoria</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="asset/css/style.css">
		<script type="text/javascript" src="asset/js/index.js"></script>
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<li class="right"><a id="myBtn">login</a></li>
				<li class="right"><a href="registrar.php">registrar</a></li>
			</ul>
		</nav>
 
		<!-- The Modal -->
		<div id="myModal" class="modal">
		
		  <!-- Modal content -->
			<div class="modal-content">
				<span class="close">&times;</span>
				<form id="login" method="POST">
				<label>Usuario</label>
				<input type="text" name="login">
				<label>Contraseña</label>
				<input type="password" name="contrasena"><br>
				<input type="submit" value="Iniciar Sesion">
				</form>
			</div>
		
		</div>
		<div id="cuerpo">
		
		
		</div>
	</body>
</html>

<?php


?>