<!--  Menu Navegación asd-->
<nav>
	<ul>
		<li><a href="?controller=home&action=saludo">Inicio</a></li>
		
		<?php 
		if(isset($_SESSION['usuario'])){?>
			<li class="right"><span><?= $_SESSION['usuario']?></span></li>
			<li class="right"><a href="?controller=matri&action=view">Matriculaciones</a></li>
		<?php }else{?>
		<li class="right"><a href="?controller=login&action=view">Login</a></li>
		<li class="right"><a href="?controller=registrar&action=view">Registrar</a></li>
		<?php }?>
		<li class="right"><a href="?controller=pruebas&action=view">Pruebas</a></li>
	</ul>
</nav>