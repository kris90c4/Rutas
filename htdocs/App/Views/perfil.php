
<!-- Si se intenta acceder directamente a la vista -->

<?php defined("USUARIO") OR die("Acceso denegado"); defined("APPPATH") OR die("Acceso denegado");?>

<div id="perfil">
	<H2>PERFIL</H2>
	<div>
		<label for="nombre">Nombre</label>
		<span id="nombre"><?= $_SESSION['usuario']->getNombre() ?></span><br>
		<label for="apellidos">Apellidos</label>
		<span id="apellidos"><?= $_SESSION['usuario']->getApellidos() ?></span><br>
		<label for="mail">Correo</label>
		<span id="mail"><?= $_SESSION['usuario']->getMail() ?></span><br>
		<button class="btn btn-info dropmenu" onclick="">Desplegar cambio contraseña</button>
		<h3 id="modificada"></h3>
		<div id="cambio" style="display:none;">
			<label for="old">Antigua contraseña</label><br>
			<input id="old" type="password" >
			<label for="new">Nueva contraseña</label><br>
			<input id="new" type="password" required pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
			<label for="cNew">Confirmar nueva contraseña</label><br>
			<input id="cNew" type="password" placeholder="Confirmar nueva contraseña"><br>
			<button class="btn btn-info modificar">Modificar contraseña</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".dropmenu").click(function(){
		$("#cambio").slideToggle();
	});
	$(".modificar").click(function(){
		$.post("?controller=perfil&action=modificarPass",{
			id: <?= $_SESSION['usuario']->getId() ?>,
			oldPass: $('#old').val(),
			newPass: $('#new').val(),
			cNewPass: $('#cNew').val()
		},
		function(data){
			if(data)
				if(data=="Contraseña modificada con exito"){
					$("#modificada").html(data).css({"color":"green"});
					$("#cambio").slideToggle();
				}else{
					$("#modificada").html(data).css({"color":"red"});
				}
		});
	});
</script>