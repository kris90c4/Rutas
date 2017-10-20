<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="entradas">
	<div class="contenedorEntradas">
		<a class="btn btn-default" href="?controller=entrada&action=create">Nueva entrada</a>
		<button id="enviar" class="pull-right btn btn-default" title="Envia los telefonos seleccionados al correo comercial@gestoriaportol.com">
			<i style="margin-right: 4px" class="glyphicon glyphicon-send"></i>
			<span>Enviar</span>
		</button>
		<button id="confirmar" class="pull-right btn btn-default" title="Tras enviar los sms atraves del movil, se confirma que todos los sms han sido enviados correctamente">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Confirmar</span>
		</button>
		<button class="descargarTodasSalidas pull-right btn btn-default" title="Hay que filtrar solo las salidas deseadas, Solo funciona en ¡¡¡CHROME!!!!">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Descargar todas las salidas(Solo Compatible con CHROME)</span>
		</button>

	</div>
	
	
	<table id="entrada">
		<thead>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<!--th>Base imponible</th>
				<th>%</th>
				<th>cv/v</th>
				<th>Telefono</th>
				<th>Mail</th-->
				<th>Comprador</th>
				<th>cTelefono</th>
				<!--th>cMail</th>
				<th>Tipo</th>
				<th>Provision</th>
				<th>Cobrado</th-->
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
				<!--th>Base imponible</th>
				<th>%</th>
				<th>cv/v</th>
				<th>Telefono</th>
				<th>Mail</th-->
				<th>Comprador</th>
				<th>cTelefono</th>
				<!--th>cMail</th>
				<th>Tipo</th>
				<th>Provision</th>
				<th>Cobrado</th-->
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
				<!--td><?= $entrada['base_imponible'] ?></td>
				<td><?= $entrada['tipo_de_gravamen'] ?></td>
<?php //if($entrada['vendedor']==null): ?>
				<td class="cv"><?= $entrada['compraventa'] ?></td>
				<td class="cv"><?= $entrada['cvTelefono'] ?></td>
				<td class="cv"><?= $entrada['cvMail'] ?></td>
<?php //else: ?>
				<td><?= $entrada['vendedor'] ?></td>
				<td <? //$entrada['vId']==$entrada['vTelefono']?'style="color:red;"':"" . ">" .$entrada['vTelefono'] ?></td>
				<td><?= $entrada['vMail'] ?></td-->
<?php //endif; ?>
				<td><?= $entrada['comprador'] ?></td>
				<td><?= $entrada['cTelefono']?></td>
				<!--td><?= $entrada['cMail']?></td>
				<td><?= $entrada['tipo'] ?></td>
				<td><?= $entrada['provision'] ?></td>
				<td><?= $entrada['cobrado'] ?></td-->
				<td><?= date("d-m-Y H:i", strtotime($entrada['fecha_entrada'])) ?></td>
				<td><?= $entrada['fecha_salida']?date("d-m-Y H:i", strtotime($entrada['fecha_salida'])):"" ?></td>
				<td><?= $entrada['usuario'] ?></td>
				<td class="opciones" style="display:flex;">
					<button class="editar btn btn-success">Editar</button>
					<!--a class="btn btn-info" href="App\Controllers\Traspasos\<?= $entrada['matricula'] ?>.xlsx">Descargar</a-->
					<button class="descarga btn btn-info" >Descargar</button>
					<button  class="<?= empty($entrada['fecha_salida'])?"seleccionar":"descargarsalida" ?> btn btn-default" ><?= empty($entrada['fecha_salida'])?"Seleccionar":"Salida" ?></button>
					<a href="?controller=tramites&action=estado&parametros=<?= base64_encode($entrada['matricula']) ?>" >Estado</a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorCliente"></div>
</div>