<!--  Menu Navegación asd-->
<nav>
	<ul>
		<li><a href="?controller=home&action=view">Inicio</a></li>
		
		<?php if(isset($_SESSION['usuario'])){?>
			<li class="right"><a href="?controller=perfil&action=logout">salir</a></li>
			<li class="right"><a href="?controller=perfil&action=view"><?= $_SESSION['usuario']->getNombre()?></a></li>
			<?php if($_SESSION['usuario']->getAdmin()): ?> 
				<li class=""><a href="?controller=perfil&action=gestion">GestionUsuarios</a></li>
			<?php else: ?>
				<li class=""><a href="?controller=traspasos&action=view">Traspasos</a></li>
				<li class=""><a href="?controller=matri&action=view">Matriculaciones</a></li>
			<?php endif; ?>
		<?php }else{?>
		<li class="right"><a href="?controller=login&action=view">Login</a></li>
		<li class="right"><a href="?controller=registrar&action=view">Registrar</a></li>
		<?php }?>
		<li class=""><a href="?controller=pruebas&action=view">Pruebas</a></li>
	</ul>
</nav>
