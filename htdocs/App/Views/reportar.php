<div id="reportar">
<a href="skype:kris18c4?call">Llamar al Skype del Administrador</a>
	<form  action="?controller=reportes&action=save" method="POST">
		<label for="titulo">Título<font color="red">*</font></label><br>
		<input id="titulo" name="titulo" placeholder="Titulo" required /><br>
		<label for="descripcion">Descripción<font color="red">*</font></label><br>
		<textarea id="descripcion" type="text" name="descripcion" placeholder="Detallar la modificación deseada" required></textarea><br>
		<input type="submit">
	</form>
</div>