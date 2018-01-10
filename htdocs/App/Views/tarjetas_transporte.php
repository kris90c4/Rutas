<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div id="registros">
	<div class="contenedorEntradas">
		<button id="nuevaTarjeta" class="btn btn-default">Nueva registro</button>
		<!--button id="enviar" class="pull-right btn btn-default" title="Envia los telefonos seleccionados al correo comercial@gestoriaportol.com">
			<i style="margin-right: 4px" class="glyphicon glyphicon-send"></i>
			<span>Enviar</span>
		</button>
		<button id="sms" class="pull-right btn btn-default" title="Desde el movil, se abre un nuevo mensaje con todos los contactos seleccionados">SMS</button>
		<button id="confirmar" class="pull-right btn btn-default" title="Tras enviar los sms atraves del movil, se confirma que todos los sms han sido enviados correctamente">
			<i  class="glyphicon glyphicon-saved"></i>
			<span>Confirmar</span>
		</button-->
	</div>
	
	
	<table id="registro">
		<thead>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Cliente</th>
				<th>Telefono</th>
				<th>Valido Hasta</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Cliente</th>
				<th>Telefono</th>
				<th>Valido Hasta</th>
				<th>Usuario</th>
				<th>Opciones</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($registros as  $registro): ?>
			<tr>
				<td><?= $registro['id'] ?></td>
				<td><?= strtoupper($registro['matricula']) ?></td>
				<td><?= $registro['cliente'] ?></td>
				<td><?= $registro['telefono'] ?></td>
				<!--td><?= empty($registro['fecha_renovacion'])?"Pendiente":date("d-m-Y", strtotime($registro['fecha_renovacion'])) ?></td-->
				<td><?= empty($registro['fecha_vencimiento'])?"Pendiente":date("d-m-Y", strtotime($registro['fecha_vencimiento'])) ?></td>
				<td><?= $registro['usuario'] ?></td>
				<td class="opciones" style="display:flex;">
					<button class="edit btn btn-success">Editar</button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorCliente"></div>
</div>