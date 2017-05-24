
<div id="formMatri">
	<form action="?controller=matri&action=create" method="POST">
		<ul>
			<li>
				<label for="entrada">Entrada</label>
				<input id="entrada" type="date" name="entrada" required value="<?= date("Y-m-d") ?>"/>
			</li>
			<li>
				<label for="bastidor">Bastidor</label>
				<input id="bastidor" type="text" name="bastidor" pattern="[A-Z0-9]{6}" placeholder="bastidor" required/>
			</li>
			<li>
				<label for="matricula">Matricula</label>
				<input id="matricula" type="text" name="matricula" pattern="([A-Z]{2})?\d{4}[A-Z]{3}" placeholder="matricula" required/>
			</li>
			<li>
				<label for="cliente">Cliente</label>
				<input id="cliente" type="text" name="cliente" placeholder="cliente" required/>
			</li>
			<li>
				<label for="alta">Precio alta</label>
				<input id="alta" type="number" step="0.01" name="alta" placeholder="precio alta" required/>
			</li>
			<li>
				<label for="provincias">Provincias</label>
				<select id="provincias" name="provincia" required></select>
			</li>
			<li>
				<label for="municipios">Municipios</label>
				<select id="municipios" name="municipio" required></select>
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
