<!--  Menu Navegación asd-->
<nav style="display:none"'>
	<ul id="menu">
		<li><a href="?controller=home&action=view">Inicio</a></li>
		<div>
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
		</div>
		<li id="desplegar"><a>O</a></li>
	</ul>
</nav>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Page 1-1</a></li>
            <li><a href="#">Page 1-2</a></li>
            <li><a href="#">Page 1-3</a></li>
          </ul>
        </li>
        <li><a href="#">Page 2</a></li>
        <li><a href="#">Page 3</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
<script type="text/javascript">
$("#desplegar").click(function(){
	$("#menu div").slideToggle();
});

</script>
