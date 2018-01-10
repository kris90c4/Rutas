<form id="<?= isset($id)?$id:"" ?>" method="post" action="?controller=tarjeta_transporte&action=<?= isset($editar)?"editado":"save" ?>" enctype="multipart/form-data">
	<div class="separador">
		<h3>Datos Vehiculo</h3>
		<label for="matricula">Matricula <font color="red">*</font></label>
		<input id="matricula" type="text" name="matricula" tabindex="1" value="<?= isset($editar)?$editar['matricula']:"" ?>" required/>
		<i title="Datos del Vehiculo" id="datosVehiculo" class="glyphicon glyphicon-list-alt btn btn-info"></i>

	</div>
	<div class="separador">
		<h3 id="cliente">Cliente</h3>
		<!--button id="nuevo" class="cvButton btn btn-default" >Nuevo Compraventa</button-->
		<div class="wrap">
			<label for="cliente">Nombre <font color="red">*</font></label>
			<input class="nombre" list="cv" id="cliente" tabindex="1" type="text" name="cliente" required  value="<?= isset($editar)?$editar['cliente']:"" ?>" />
		</div>
		<label for="tlf">Telefono <font color="red">*</font></label>
		<input class="tlf" id="tlf" type="text" tabindex="1" name="tlf" pattern="\d{9}|\d{1,4}" required  value="<?= isset($editar)?$editar['tlf']:"" ?>" />
		<button id="vTND" title="No disponible" type="button" class="noTlf btn btn-warning">ND</button>
		<br>
		<div class="wrap">
			<label for="mail">Mail <font color="red">*</font></label>
			<input class="mail" list="autoMail" tabindex="1" id="mail" type="text" name="mail" required  value="<?= isset($editar)?$editar['mail']:"" ?>" />
			<button id="vMND" title="No disponible" type="button" class="default btn btn-warning">ND</button>
			<datalist id="autoMail"></datalist>
		</div>
	</div>
<?php// if(!isset($editar)): ?>
	<div class="separador">
		<h3>Datos tarjeta</h3>
		<label for="fecha_vencimiento">Valido hasta</label>
		<input id="fecha_vencimiento" type="date" name="fecha_vencimiento" value="<?= isset($editar)?$editar['fecha_vencimiento']:"" ?>"><br>
		<!--label for="fecha_renovacion">Fecha renovacion</label>
		<input id="fecha_renovacion" type="date" name="fecha_renovacion" value="<?= isset($editar)?$editar['fecha_renovacion']:"" ?>"-->
	</div>
	<div class="separador">
		<h3>Archivos</h3>
		<!--label style="font-size: 15px" class="pull-right label label-danger"><span id="precio" ></span>€</label-->
		<label for="archivos">Documentos</label>
		<input id="archivos" type="file" name="archivos[]" multiple="multiple">
		<br>
	</div>
<?php// endif; ?>
	
	<input type="hidden" name="id_cliente" id="id_cliente" value="<?= isset($editar)?$editar['id_cliente']:"" ?>">
	<input type="hidden" name="tiempo" value="<?= date('Y-m-d H:i:s') ?>">
	<input type="hidden" name="id" value="<?= isset($editar)?$editar['id']:"" ?>">
	<input class="btn btn-success" type='submit' tabindex="1" name='<?= isset($editar)?"editar":"enviar" ?>' value="<?= isset($editar)?"Modificar":"Crear" ?> Entrada" />
	<h2 style="color:red"><?= isset($error)?$error:"" ?></h2>
</form>

<script type="text/javascript" src="asset/js/nueva_entrada.js" async="async"></script>