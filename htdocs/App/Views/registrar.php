<div id="registrar">
	<form action="?controller=registrar&action=check" method="POST">
		<h2>Registrar</h2>
		<input type="text" name="nombre" pattern="[a-zA-Z]{3,20}" placeholder="Nombre" required value="<?= isset($nombre)?$nombre:"" ?>" >
		<input type="text" name="apellidos" pattern="[a-zA-Z]{3,18}(\s[a-zA-Z]{3,18})?" placeholder="Apellidos" oninvalid="this.setCustomValidity('De 3 a 18 caracteres por apellido, 2 apellidos como maximo')" required value="<?= isset($apellidos)?$apellidos:"" ?>" >
		<!-- Si se manda la variable eMail, el -->
		<input class="<?= isset($eMail)?"errorInput":"" ?>" type="text" name="mail"  placeholder="Correo" pattern="^\w+([.+-]\w+)*@\w+([.-]\w+)*\.\w{2,4}$" required value="<?= isset($mail)?$mail:"" ?>" >

		<input type="password" name="pass" placeholder="Contraseña" pattern="(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required oninvalid="this.setCustomValidity('Requisitos:\n1 Mayuscula\n1 Minuscula\n1 Numero\n6 Caracteres minimo')" title="Falta este campo">

		<input class="btn-blue" type="submit" name="registrar" value="Registrar">
	</form>
</div>