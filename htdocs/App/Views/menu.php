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
        <?php if(isset($_SESSION['usuario'])):?> <!--Menu para registrados-->
          <?php if($_SESSION['usuario']->getNombre()=="Myrna"): ?>
            <li><a href="?controller=estadisticas&action=view">Estadisticas</a></li>
          <?php else: ?>
            <!--Seccion Comun-->
              <li><a href="?controller=test&action=novedades">Novedades</a></li>
              <li><a href="?controller=compraventa&action=view">Compraventas</a></li>
              <li><a href="?controller=cliente&action=view">clientes</a></li>
            <!--Fin Seccion Comun-->
            <?php if($_SESSION['usuario']->getAdmin()): ?> <!--Sección usuario Admin-->
              <li><a href="?controller=perfil&action=gestion">GestionUsuarios</a></li>
              <li><a href="?controller=reportes&action=view">Reportes<span class="badge" id="pen"></span></a></li>
              <li><a href="?controller=estadisticas&action=view">Estadisticas</a></li>
            <?php else: ?><!--Seccion Usuario normal-->
              <!--li><a href="?controller=traspasos&action=view">Traspasos</a></li>
              <li><a href="?controller=matri&action=view">Matriculaciones</a></li-->
              <li class=""><a href="?controller=entrada&action=view">Entradas</a></li>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(defined('ACCESS')):?>
       
     	<?php elseif(!isset($_SESSION['usuario'])): ?>
         <li><a href="?controller=registrar&action=view"><span class="glyphicon glyphicon-user"></span> Registrar</a></li>
        <li><a href="?controller=login&action=view"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <?php else: ?>
    <li class="report"><a href="?controller=reportes&action=create">Sugerencias</a></li>
		<li><a id="username" href="?controller=perfil&action=view"><?= $_SESSION['usuario']->getNombre()?></a></li>
    <!--li><a id="buzon" href="?controller=perfil&action=buzon"><i class="glyphicon glyphicon-envelope"></i></a></li-->
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

  $.post('?controller=reportes&action=pendientes',{

  },function(data){
    $('#pen').html(data);
  });


</script>
