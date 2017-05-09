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
		<script>
			window.onload=function(){
				// Get the modal
				var modal = document.getElementById('myModal');
				
				// Get the button that opens the modal
				var btn = document.getElementById("myBtn");
				
				// Get the <span> element that closes the modal
				var span = document.getElementsByClassName("close")[0];
				
				// When the user clicks the button, open the modal 
				btn.onclick = function() {
					modal.style.display = "block";
				}
				
				// When the user clicks on <span> (x), close the modal
				span.onclick = function() {
					modal.style.display = "none";
				}
				
				// When the user clicks anywhere outside of the modal, close it
				window.onclick = function(event) {
					if (event.target == modal) {
						modal.style.display = "none";
					}
				}
			}
		</script>
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
				<p>Some text in the Modal..</p>
			</div>
		
		</div>
		<div id="cuerpo">
		
		
		</div>
	</body>
</html>

<?php


?>