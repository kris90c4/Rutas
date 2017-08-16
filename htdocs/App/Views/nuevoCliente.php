<div>
	<form class="form" action="?controller=cliente&action=save" method="POST">
		<h3>Cliente</h3>
		<br>
		<label for="nombre">Nombre</label>
		<input id="nombre" type="text" name="nombre" value="<?php echo isset($cliente)?$cliente['nombre']:""; ?>" required>
		<br>
		<label for="mail">Mail</label>
		<input id="mail" type="mail" name="mail" value="<?php echo isset($cliente)?$cliente['mail']:""; ?>" required>
		<br>
		<label for="telefono">Telefono</label>
		<input id="telefono" type="text" name="telefono" value="<?php echo isset($cliente)?$cliente['telefono']:""; ?>" required >
		<br>
		<br>
		<input type="hidden" name="id" value="<?= isset($cliente)?$cliente['id']:"" ?>">
		<input type="submit" name="<?= isset($cliente)?"editar":"nuevo" ?>" value="<?= isset($cliente)?"Actualizar":"Nuevo" ?>">
		<span><?= isset($error)?$error:"" ?></span>
	</form>
</div>