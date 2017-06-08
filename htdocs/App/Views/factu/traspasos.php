<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="formMatri">
	<form action="?controller=traspasos&action=save" method="POST">
		<ul>
			<li>
				<label for="entrada">Entrada</label>
				<input id="entrada" type="date" name="entrada" required value="<?= date("Y-m-d") ?>"/>
			</li>
			<li>
				<label for="matricula">Matricula</label>
				<input id="matricula" type="text" name="matricula" pattern="([a-Z]{2})?\d{4}[a-Z]{3}" placeholder="matricula" required/>
			</li>
			<li>
				<label for="cliente">Cliente</label>
				<input id="cliente" type="text" name="cliente" placeholder="cliente" required/>
			</li>
			<li>
				<label for="tipos">Tipo</label>
				<select id="tipos" name="tipo" required></select>
			</li>
			<li>
				<label for="salida">Salida</label>
				<input id="salida" type="date" name="salida"/>
			</li>
			<li>
				<input type="submit">
			</li>
		</ul>
	</form>
</div>
<script>
	var rutaTipos="?controller=traspasos&action=tipos"

	//Se vuelcan todos los paises en el select con id S1
	loadDataDoc(rutaTipos,"",'tipos');
</script>