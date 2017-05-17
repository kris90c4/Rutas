<div id="login">
	<form action="?controller=login&action=validate" method="POST">
		<label>Usuario</label>
		<input type="text" name="mail" value="<?= isset($mail)?$mail:"" ?>" required>
		<label>Contraseña<?= isset($ePass)?"<font color='red'>*</font>":"" ?></label>
		<input type="password" name="pass" required><?php  ?><br>
		<input type="submit" name="login" value="Iniciar Sesion">
	</form>
</div>