<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<!--  Menu Navegación-->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="?controller=home&action=view">Gestoria Portol</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class=""><a href="?controller=home&action=view">Home</a></li>
        <?php if(isset($_SESSION['usuario'])):?>
            <li><a href="?controller=agenda&action=view">Agenda</a></li>
	        <?php if($_SESSION['usuario']->getAdmin()): ?> 
		        <li><a href="?controller=perfil&action=gestion">GestionUsuarios</a></li>
            <li><a href="?controller=reportes&action=view">Reportes</a></li>
			<?php else: ?>
		        <li><a href="?controller=traspasos&action=view">Traspasos</a></li>
		        <li><a href="?controller=matri&action=view">Matriculaciones</a></li>
            <li class=""><a href="?controller=home&action=excel">Excel</a></li>
	        <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<?php if(!isset($_SESSION['usuario'])):?>
        <li><a href="?controller=registrar&action=view"><span class="glyphicon glyphicon-user"></span> Registrar</a></li>
        <li><a href="?controller=login&action=view"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
     	<?php else: ?>
    <li class="report"><a href="?controller=reportes&action=create">Sugerencias</a></li>
		<li><a href="?controller=perfil&action=view"><?= $_SESSION['usuario']->getNombre()?></a></li>
 		<li><a href="?controller=perfil&action=logout">salir</a></li>
		 <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<script type="text/javascript">
$("#desplegar").click(function(){
	$("#menu div").slideToggle();
});

</script>
