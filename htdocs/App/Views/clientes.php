<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<a href="?controller=cliente&action=create">Añadir cliente</a>
	<table id="clientes">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Mail</th>
				<th>Telefono</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clientes as  $cliente): ?>
			<tr>
				<td><?= $cliente['id'] ?></td>
				<td><?= $cliente['nombre'] ?></td>
				<td><?= $cliente['mail'] ?></td>
				<td><?= $cliente['telefono'] ?></td>
				<td>
					<a href="?controller=agenda&action=create&parametros=<?= $cliente['id'] ?>" class="btn btn-success" id="edit">Editar</a>
					<button class="del btn btn-danger">Eliminar</button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div style="display: none" id="dialog-confirm" title="Eliminar Compraventa?">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
			Este compraventa sera eliminado. Estas seguro?
		</p>
	</div>
	<div id="errorCliente"></div>
</div>
<script>
	$(document).ready(function() {
		// Setup - add a text input to each footer cell
		/*$('#clientes tfoot th').each( function () {
		    var title = $(this).text();
		    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		});*/

		// DataTable
		var table = $('#clientes').DataTable({
			//"pageLength": 50
		});

		// Apply the search
		/*table.columns().every( function () {
		    var that = this;

		    $( 'input', this.footer() ).on( 'keyup change', function () {
		        if ( that.search() !== this.value ) {
		            that
		                .search( this.value )
		                .draw();
		        }
		    });
		});*/
	});
</script>