<!--  Menu Navegación -->
<nav>
	<ul>
		<li><a href="index.php">Inicio</a></li>
		<li> <?= $_SESSION['usuario']->getNombre() ?> </li>
		<li class="right"><a href="?controller=sessionUser&action=edit">Modificar</a></li>
		<li class="right"><a href="?controller=sessionUser&action=logout">Salir</a></li>
	</ul>
</nav>