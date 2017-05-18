<div id="registrar">
	<form action="?controller=registrar&action=save" method="POST">
		<h2>Registrar</h4>
		<input type="text" name="nombre" pattern="[a-zA-Z]{3,20}" placeholder="Nombre" required value="<?= isset($nombre)?$nombre:"" ?>" >
		<input type="text" name="apellidos" pattern="[a-zA-Z]{3,15}(\s[a-zA-Z]{3,15}){0,2}" placeholder="Apellidos" required value="<?= isset($apellidos)?$apellidos:"" ?>" >
		<input class="<?= isset($eMail)?"errorInput":"" ?>" type="text" name="mail"  placeholder="Correo" required value="<?= isset($mail)?$mail:"" ?>" >
		<input type="password" name="pass" placeholder="Contraseña" required oninvalid="this.setCustomValidity('Please Enter valid email')" title="dalta este campo">
		<input type="text" name="usuario" placeholder="Captcha"><br>
		<input class="btn-blue" type="submit" name="registrar" value="Registrar">
	</form>
</div>