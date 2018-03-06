<form id="<?= isset($id)?$id:"" ?>" method="post" action="?controller=entrada&action=<?= isset($editar)?"editado":"save" ?>">
	<div class="separador">
		<h3>Datos Traspaso</h3>
		<label>Solicitante</label>
		<select name="tipo" id="tipo" tabindex="1">
			<option value="part">Particular</option>
			<option value="cv" <?= isset($editar)&&$editar['tipo']=="cv"?"selected":"" ?> >CompraVenta</option>
		</select><br>
		<label>Tipo</label>
		<select name="tipo_traspaso" id="tipo_traspaso" tabindex="1">
			<option value="3" <?= isset($editar)&&$editar['id_tipo']==2?"selected":"" ?>>Traspaso</option>
			<option value="1" <?= isset($editar)&&$editar['id_tipo']==1?"selected":"" ?>>Caucional</option>
			<option value="2" <?= isset($editar)&&$editar['id_tipo']==2?"selected":"" ?>>Notificacion Venta</option>
			<option value="4" <?= isset($editar)&&$editar['id_tipo']==4?"selected":"" ?>>Notificacion Venta + Traspaso</option>
		</select><br>
	</div>
	<div class="separador">
		<h3>Datos Vehiculo</h3>
		<label for="matricula">Matricula <font color="red">*</font></label>
		<input id="matricula" type="text" name="matricula" tabindex="1" value="<?= isset($editar)?$editar['matricula']:"" ?>" required/><i style="padding: 1px 5px;" title="Calculo del Traspaso" class="btn btn-default" id="bt">620</i><i title="Precio incial de busqueda" id="conf" class="glyphicon glyphicon-wrench btn btn-success"></i><i title="Datos del Vehiculo" id="datosVehiculo" class="glyphicon glyphicon-list-alt btn btn-info"></i>
		<div id="modal620"><label for="">Precio Inicial: </label><br><input name="inicial" id="inicial" type="number" value="1000"><i id="close" class="glyphicon glyphicon-remove-circle"></i><!--label for="">Tick: </label><input id="tick" name="tick" type="number"--></div>
		<br>
		<label for="base_imponible">Base imponible <font color="red">*</font></label>
		<input id="base_imponible" type="number" tabindex="1" name="base_imponible" value="<?= isset($editar)?$editar['base_imponible']:"" ?>" required />
		<br>
		<label for="tipo_de_gravamen">Tipo de gravamen</label>
		<select id="tipo_de_gravamen" name="tipo_de_gravamen" tabindex="1">
			<option value="4">4%</option>
			<option value="8">8%</option>
		</select>
	</div>
	<div class="separador">
		<h3 id="vcv">Vendedor</h3>
		<button class="cvButton btn btn-default" id="nuevo">Nuevo Compraventa</button>
		<!--button id="nuevo" class="cvButton btn btn-default" >Nuevo Compraventa</button-->
		<div class="wrap">
			<label for="vendedor">Nombre <font color="red">*</font></label>
			<input class="nombre" list="cv" id="vendedor" tabindex="1" type="text" name="vendedor" required  value="<?= isset($editar)?$editar['vendedor']:"" ?>" />
			<datalist id="cv"></datalist>
		</div>
		<label for="vTlf">Telefono <font color="red">*</font></label>
		<input class="tlf" id="vTlf" type="text" tabindex="1" name="vTlf" pattern="\d{9}|\d{1,4}" required  value="<?= isset($editar)?$editar['vTlf']:"" ?>" />
		<button id="vTND" title="No disponible" type="button" class="noTlf btn btn-warning">ND</button>
		<br>
		<div class="wrap">
			<label for="vMail">Mail <font color="red">*</font></label>
			<input class="mail" list="autoMail" tabindex="1" id="vMail" type="text" name="vMail" required  value="<?= isset($editar)?$editar['vMail']:"" ?>" />
			<button id="vMND" title="No disponible" type="button" class="default btn btn-warning">ND</button>
			<datalist id="autoMail"></datalist>
		</div>
	</div>
	<div class="separador">
		<h3>Comprador</h3>
		<button id="mismoCV" class="cvButton btn btn-default">Mismo Compraventa</button>
		<label for="comprador">Nombre <font color="red">*</font></label>
		<input class="nombre" id="comprador" tabindex="1" type="text" name="comprador" required  value="<?= isset($editar)?$editar['comprador']:"" ?>" />
		<br>
		<label for="cTlf">Telefono <font color="red">*</font></label>
		<input class="tlf" id="cTlf" type="text" tabindex="1" name="cTlf" pattern="\d{9}|\d{1,4}" required value="<?= isset($editar)?$editar['cTlf']:"" ?>" />
		<button title="No disponible" type="button" class="noTlf btn btn-warning">ND</button>
		<br>
		<div class="wrap">
			<label for="cMail">Mail <font color="red">*</font></label>
			<input class="mail" list="autoMail2" id="cMail" type="text" tabindex="1" name="cMail" required  value="<?= isset($editar)?$editar['cMail']:"" ?>" />
			<button title="No disponible" type="button" class="default btn btn-warning">ND</button>
			<datalist id="autoMail2"></datalist>
		</div>
	</div>
<?php if(!isset($editar)): ?>
	<div class="separador">
		<h3>Cobro</h3>
		<label for="provision">Provision</label>
		<select name="provision" id="provision" tabindex="1">
			<option value="visa">Visa</option>
			<option value="efectivo">Efectivo</option>
			
		</select>
		<br>
		<label for="pago">pagado hoy</font></label>
		<input id="pago" type="checkbox" tabindex="1" name="pago" <?= isset($editar)?"checked":"" ?> /><br>
		<label style="font-size: 15px" class="pull-right label label-danger"><span id="precio" ></span>€</label>
	</div>
<?php endif; ?>
	<div class="separador">
		<label for="">Correo Ordinario</label>
		<select name="correo_ordinario" id="correo_ordinario">
			<option value="0">No</option>
			<option <?= isset($editar)&&$editar['correo_ordinario']==1?"selected":"" ?> value="1">Normal(+15€)</option>
			<option <?= isset($editar)&&$editar['correo_ordinario']==2?"selected":"" ?> value="2">Contrarembolso</option>
		</select>
	</div>
	<input type="hidden" name="id_compraventa" id="id_compraventa" value="<?= isset($editar)?$editar['id_compraventa']:"" ?>">
	<input type="hidden" name="id_vendedor" id="id_vendedor" value="<?= isset($editar)?$editar['id_vendedor']:"" ?>">
	<input type="hidden" name="id_comprador" id="id_comprador" value="<?= isset($editar)?$editar['id_comprador']:"" ?>">
	<input type="hidden" name="tiempo" value="<?= date('Y-m-d H:i:s') ?>">
	<input type="hidden" name="gestion" id="gestion">
	<input type="hidden" name="nv" id="nv">
	<input type="hidden" name="id" value="<?= isset($editar)?$editar['id']:"" ?>">
	<input class="btn btn-success" type='submit' tabindex="1" name='<?= isset($editar)?"editar":"enviar" ?>' value="<?= isset($editar)?"Modificar":"Crear" ?> Entrada" />
	<h2 style="color:red"><?= isset($error)?$error:"" ?></h2>
</form>

<script type="text/javascript" src="asset/js/nueva_entrada.js" async="async"></script>