<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="formMatri">
	<form action="?controller=matri&action=save" method="POST">
		<ul>
			<li>
				<label for="entrada">Entrada</label>
				<input id="entrada" type="date" name="entrada" required value="<?= date("Y-m-d") ?>"/>
			</li>
			<li>
				<label for="bastidor">Bastidor<font color="red">*</font></label>
				<input id="bastidor" onkeyup="aMays(event,this)" type="text" name="bastidor" pattern="[a-zA-Z0-9]{6}" placeholder="bastidor" required/>
			</li>
			<li>
				<label for="matricula">Matricula<font color="red">*</font></label>
				<input id="matricula" onkeyup="aMays(event,this)" type="text" name="matricula" pattern="([a-zA-Z]{2})?\d{4}[a-zA-Z]{3}" placeholder="matricula" required/>
			</li>
			<li>
				<label for="cliente">Cliente<font color="red">*</font></label>
				<input id="cliente" type="text" name="cliente" placeholder="cliente" required/>
			</li>
			<li>
				<label for="alta">Precio alta<font color="red">*</font></label>
				<input id="alta" type="number" step="0.01" name="alta" placeholder="precio alta" required/>
			</li>
			<li>
				<label for="suplido">Suplido</label>
				<input id="suplido" type="number" step="0.01" name="suplido" placeholder="Precio Suplido"/>
			</li>
			<li>
				<label for="exento">Exento</label>
				<input type="checkbox" id="exento" value="1" name="exento"/>
			</li>
			<li>
				<label for="provincias">Provincias<font color="red">*</font></label>
				<select id="provincias" name="provincia" required></select>
			</li>
			<li>
				<label for="municipios">Municipios<font color="red">*</font></label>
				<select id="municipios" name="municipio" required></select>
			</li>
			<li>
				<label for="salida">Salida</label>
				<input id="salida" type="date" name="salida"/>
			</li>
			<li>
				<input type="submit">
				<?php 
	if(isset($error)){
		echo "<font color='red'>$error</font>";
	}
?>
			</li>
		</ul>
	</form>
</div>



<script>
	//SIN HACER; HAY QUE MODIFICAR TODO
	var rutaProvincias="?controller=matri&action=provincias"
	var rutaMunicipios="?controller=matri&action=municipios"
	
	//Se vuelcan todos los paises en el select con id S1
	loadDataDoc(rutaProvincias,"",'provincias');

	//se captura el select de los paises
	provincias=document.getElementById('provincias');
	municipios=document.getElementById('municipios');
	//Coje el value de la provincia seleccionada y recupera todos sus municipios
	provincias.onchange=function(){
		loadDataDoc(rutaMunicipios,"id_provincia="+provincias.value,'municipios');
	}
	setTimeout(function(){
		console.log("despieta");
		valor=7;
		$("#provincias option[value="+ valor +"]").attr("selected",true);
		loadDataDoc(rutaMunicipios,"id_provincia="+valor,'municipios');
	}, 500);
	
</script>