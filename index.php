<?php 
	header ('Content-type: text/html; charset=utf-8');
	//define("__RAIZ__","C:\Users\Bender\Dropbox\FP Superior\2 Curso\Aplicaciones\Rutas");
	require 'vendor/autoload.php';
	//require 'controller/registerController.php"';
	define("__RAIZ__","Aplicaciones\Rutas");
	
	if (isset($POST["usuario"])) {
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gestoria</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="asset/css/style.css">
		<script type="text/javascript" src="asset/js/index.js"></script>
	</head>
	<body>
	
	<!--  Menu Navegación -->
		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<li class="right"><a href="?controller=login">Login</a></li>
				<li class="right"><a href="?controller=register">Registrar</a></li>
			</ul>
		</nav>
 
		<!-- The Modal -->
		<div id="myModal" class="modal">
		
		  <!-- Modal content -->
			<div class="modal-content">

			</div>
		
		</div>
		<div id="cuerpo">
		<?php 
		if (isset($_GET["controller"])){
			if($_GET["controller"]=="register") {
				include 'template/registrar.html"';
			}else if($_GET['controller']=="login"){
				include 'template/login.html"';
			}
			
		}
		
		?>
		
		</div>
	</body>
</html>

<?php


?>