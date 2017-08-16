<div>
	<form class="form" action="?controller=compraventa&action=save" method="POST">
		<h3>Compraventa</h3>
		<br>
		<label for="nombre">Nombre</label>
		<input id="nombre" type="text" name="nombre" value="<?php echo isset($compraventa)?$compraventa['nombre']:""; ?>" required>
		<br>
		<label for="gestion">Gestion</label>
		<input id="gestion" type="number" step="0.1" name="gestion" value="<?php echo isset($compraventa)?$compraventa['gestion']:""; ?>" required>
		<br>
		<label for="mail">Mail</label>
		<input id="mail" type="mail" name="mail" value="<?php echo isset($compraventa)?$compraventa['mail']:""; ?>" required>
		<br>
		<label for="telefono">Telefono</label>
		<input id="telefono" type="text" name="telefono" value="<?php echo isset($compraventa)?$compraventa['telefono']:""; ?>" required >
		<br>
		<br>
		<input type="hidden" name="id" value="<?= isset($compraventa)?$compraventa['id']:"" ?>">
		<input type="submit" name="<?= isset($compraventa)?"editar":"nuevo" ?>" value="<?= isset($compraventa)?"Actualizar":"Nuevo" ?>">
		<span><?= isset($error)?$error:"" ?></span>
	</form>
</div>