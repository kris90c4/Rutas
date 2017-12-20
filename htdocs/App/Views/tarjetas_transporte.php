<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="entradas">
	<div class="contenedorEntradas">
		<button id="nuevaEntrada" class="btn btn-default">Nueva entrada</button>
		<button id="enviar" class="pull-right btn btn-default" title="Envia los telefonos seleccionados al correo comercial@gestoriaportol.com">
			<i style="margin-right: 4px" class="glyphicon glyphicon-send"></i>
			<span>Enviar</span>
		</button>
		<button id="sms" class="pull-right btn btn-default" title="Desde el movil, se abre un nuevo mensaje con todos los contactos seleccionados">SMS</button>
		<button id="confirmar" class="pull-right btn btn-default" title="Tras enviar los sms atraves del movil, se confirma que todos los sms han sido enviados correctamente">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Confirmar</span>
		</button>
		<!--button class="descargarTodasSalidas pull-right btn btn-default" title="Hay que filtrar solo las salidas deseadas, Solo funciona en ¡¡¡CHROME!!!!">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Descargar todas las salidas(Solo Compatible con CHROME)</span>
		</button-->

	</div>
	
	
	<table id="entrada">
		<thead>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Comprador</th>
				<th>cTelefono</th>
				<th>Fecha_entrada</th>
				<th>Fecha_salida</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Comprador</th>
				<th>cTelefono</th>
				<th>Fecha_entrada</th>
				<th>Fecha_salida</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($entradas as  $entrada): ?>
			<tr <?= $entrada['vendedor']==null?"class=\"cv\"":"" ?>>
				<td><?= $entrada['id'] ?></td>
				<td><?= strtoupper($entrada['matricula']) ?></td>
				<td><?= $entrada['comprador'] ?></td>
				<td><?= $entrada['cTelefono']<100000000?"No Disponible":$entrada['cTelefono'] ?></td>
				<td><?= date("d-m-Y H:i", strtotime($entrada['fecha_entrada'])) ?></td>
				<td><?= $entrada['fecha_salida']?date("d-m-Y H:i", strtotime($entrada['fecha_salida'])):"" ?></td>
				<td><?= $entrada['usuario'] ?></td>
				<td class="opciones" style="display:flex;">
					<button class="editar btn btn-success">Editar</button>
					<!--a class="btn btn-info" href="App\Controllers\Traspasos\<?= $entrada['matricula'] ?>.xlsx">Descargar</a-->
					<button class="descarga btn btn-info" >Descargar</button>
					<button  class="<?= empty($entrada['fecha_salida'])?"seleccionar":"descargarsalida" ?> btn btn-default" ><?= empty($entrada['fecha_salida'])?"Seleccionar":"Salida" ?></button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="filtros">
		<button id="selec" class="pull-right btn btn-default">Seleccionados</button>
		<button id="hoy" class="pull-right btn btn-default">Salida hoy</button>
		<button id="delFiltros" class="pull-right btn btn-info">Quitar filtros</button>
		<span class="pull-right">Filtros:</span>
	</div>
	<div id="errorCliente"></div>
</div>
<script>

</script>