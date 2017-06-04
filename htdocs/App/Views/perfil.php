<!-- Si se intenta acceder directamente a la vista -->
<?php defined("USUARIO") OR die("Access denied"); ?>

<div id="perfil">
	<H2>PERFIL</H2>
	<div>
		<label for="nombre">Nombre</label>
		<span id="nombre"><?= $usuario['nombre'] ?></span><br>
		<label for="apellidos">Apellidos</label>
		<span id="apellidos"><?= $usuario['apellidos'] ?></span><br>
		<label for="mail">Correo</label>
		<span id="mail"><?= $usuario['mail'] ?></span><br>
		<button class="btn btn-info dropmenu" onclick="">Desplegar cambio contraseña</button>
		<h3 id="modificada"></h3>
		<div id="cambio" style="display:none;">
			<h4>Cambio de contraseña</h4>
			<label for="old">Antigua contraseña</label><br>
			<input id="old" type="password"><br>
			<label for="new">Nueva contraseña</label><br>
			<input id="new" type="password">
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
			id: <?= $usuario['id'] ?>,
			oldPass: $('#old').val(),
			newPass: $('#new').val()
		},
		function(data,success){
			if(data)
				if(data=="Contraseña modificada con exito"){
					$("#modificada").html(data);
					$("#cambio").slideToggle();
				}else{
					alert(data);
				}
		});
	});
</script>