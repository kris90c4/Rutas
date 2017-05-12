<?php 
	session_start();
	
	require 'autoload.php';
	require "config.php";
	//define("__RAIZ__","C:\Users\Bender\Dropbox\FP Superior\2 Curso\Aplicaciones\Rutas");
	require 'vendor/autoload.php';
	//require 'controller/registerController.php"';
	
	if (isset($_POST["usuario"])) {
		
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
	
	<?php
		//Se imprime el menu a traves de su controlador
		$controladorMenu=new menu();
		$menu->pintar_menu();
	?>

		<!-- The Modal -->
		<div id="myModal" class="modal">
		
		  <!-- Modal content -->
			<div class="modal-content">

			</div>
		
		</div>
		<div id="cuerpo">
		<?php 
		
		?>
		
		</div>
	</body>
</html>