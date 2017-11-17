
<form action="?controller=compraventa&action=save" method="POST">
	<h3>Compraventa</h3>
	<label for="nombre">Nombre</label>
	<input id="nombre" type="text" name="nombre" value="<?php echo isset($compraventa)?$compraventa['nombre']:""; ?>" required>
	<label for="gestion">Gestión</label><i id="info_gestion" class="glyphicon glyphicon-info-sign" title="Como calcular el precio"></i>
	<input id="gestion" type="number" step="0.1" name="gestion" value="<?php echo isset($compraventa)?$compraventa['gestion']:""; ?>" required>
	<label for="mail">Mail</label>
	<input id="mail" type="mail" name="mail" value="<?php echo isset($compraventa)?$compraventa['mail']:""; ?>" required>
	<label for="telefono">Teléfono</label>
	<input id="telefono" type="text" name="telefono" value="<?php echo isset($compraventa)?$compraventa['telefono']:""; ?>" required >
	<br>
	<input type="hidden" name="id" value="<?= isset($compraventa)?$compraventa['id']:"" ?>">
	<input type="submit" name="<?= isset($compraventa)?"editar":"nuevo" ?>" value="<?= isset($compraventa)?"Actualizar":"Nuevo" ?>">
	<span><?= isset($error)?$error:"" ?></span>
</form>

<script>
	$('#info_gestion').on('click',function(){
	swal('Para calcular el precio de la gestión', 'Hay que restar 58€ al total del traspaso<br>Por ejemplo, Rollandi paga 85€ por traspaso, al restarle 58€(Que son las tasas fijas), el coste de la gestión se queda en 27€','info');
	});
</script>