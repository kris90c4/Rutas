<div id="login">
	<form action="?controller=login&action=validate" method="POST">
		<h2>Login</h2>
		<input type="text" name="mail" value="<?= isset($mail)?$mail:"" ?>" required placeholder="Correo">
		<?php if(isset($ePass)): ?>
			<font color="red">Contraseña Incorrecta</font><br>
		<?php endif; ?>
		<input <?= isset($ePass)?"class=\"errorInput\"" :"" ?>" type="password" name="pass" required placeholder="Contraseña"><br>
		<input class="btn btn-info" type="submit" name="login" value="Iniciar Sesion">
	</form>
</div>