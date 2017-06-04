<div id="login">
	<form action="?controller=login&action=validate" method="POST">
		<h2>Login</h2>
		<input type="text" name="mail" value="<?= isset($mail)?$mail:"" ?>" required placeholder="Correo">
		<input type="password" name="pass" required placeholder="Contraseña"><br>
		<input class="btn btn-info" type="submit" name="login" value="Iniciar Sesion">
	</form>
</div>