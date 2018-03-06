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
					<button class="descarga btn btn-info" >Descargar</button>
					<button  class="<?= empty($entrada['fecha_salida'])?"seleccionar":"descargarsalida" ?> btn btn-default" ><?= empty($entrada['fecha_salida'])?"Seleccionar":"Salida" ?></button>
					<a href="?controller=tramites&action=estado&parametros=<?= base64_encode($entrada['matricula']) ?>" >Estado</a>
					<?php
						if(strlen($entrada['cTelefono'])>6){
							$telefono=$entrada['cTelefono'];
						}else{
							if($entrada['vendedor']==null){
								$telefono=$entrada['cvTelefono'];
							}else{
								$telefono=$entrada['vTelefono'];
							}
						}
					?>
					<a class="btn btn-success" target="blank" href="https://api.whatsapp.com/send?phone=34<?= $telefono ?>&text=Le%20informamos%20que%20la%20documentaci%C3%B3n%20referente%20al%20veh%C3%ADculo%20con%20matr%C3%ADcula%20<?= strtoupper($entrada['matricula']) ?>%20ya%20est%C3%A1%20tramitada.%0APodr%C3%A1%20recogerla%20en%20Gestor%C3%ADa%20P%C3%B2rtol%2C%20C%2F%20Gran%20V%C3%ADa%20Asima%2C%2015%2C%201%C2%BA%20Izquierda.%0APara%20cualquier%20consulta%20estamos%20disponibles%20en%20el%20siguiente%20tel%C3%A9fono%20971908095.%0ANuestro%20horario%20de%20atenci%C3%B3n%20al%20p%C3%BAblico%20es%20de%208%3A00%20a%2020%3A00%20de%20lunes%20a%20viernes%20y%20de%209%3A00%20a%2013%3A00%20los%20sabados.%0APara%20la%20recogida%20de%20la%20documentaci%C3%B3n%20ser%C3%A1%20necesario%20presentar%20el%20DNI%20para%20dejar%20constancia%20de%20quien%20la%20recoge." >WhatsApp</a>
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
	//Añade un filtro en la columnas Opciones para visualizar solo las entradas seleccionadas
	$('#selec').on('click',function(){
		selec=$('#entrada tfoot input[placeholder=Opciones]');
		selec.val('seleccionado');
		selec.trigger('keyup');
	});
	//Filtro por fecha de salida
	$('#hoy').on('click',function(){
		fSalida=$('#entrada tfoot input[placeholder=Fecha_salida]');
		fSalida.val('<?= date('d-m-Y')?>');
		fSalida.trigger('keyup');
	});
	//Elimina todos los filtros
	$('#delFiltros').on('click',function(){
		$('input').val("");
		$('input').trigger('keyup');
		
	});
	//Centrado de filtros
	$(window).ready(function(){
		//$('#filtros').css('left',window.innerWidth/2-$('#filtros').outerWidth()/2+"px");
	})
	$(window).on('resize',function(){
		//$('#filtros').css('left',window.innerWidth/2-$('#filtros').outerWidth()/2+"px");
	})
	
</script>