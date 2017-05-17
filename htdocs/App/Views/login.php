<div id="login">
	<form action="?controller=login&action=validate" method="POST">
		<h2>Login</h2>
		<input type="text" name="mail" value="<?= isset($mail)?$mail:"" ?>" required placeholder="usuario@gestoriaportol.com">
		<input type="password" name="pass" required placeholder="contraseña"><br>
		<input class="btn-blue" type="submit" name="login" value="Iniciar Sesion">
	</form>
</div>