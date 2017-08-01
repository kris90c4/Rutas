<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<a href="controller">Añadir cliente</a>
	<table id="agenda">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>DNI</th>
				<th>Correo</th>
				<th>Tlf</th>
				<th>Tlf 2</th>
				<th>Operación</th>
				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clientes as  $cliente): ?>
			<tr>
				<td><?= $cliente['id'] ?></td>
				<td><?= $cliente['nombre'] ?></td>
				<td><?= $cliente['apellidos']?></td>
				<td><?= $cliente['dni'] ?></td>
				<td><?= $cliente['correo'] ?></td>
				<td><?= $cliente['telefono'] ?></td>
				<td><?= $cliente['telefono2'] ?></td>
				<td><?= $cliente['Operacion'] ?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorCliente"></div>
</div>

<script>
	// Aplica la api de DataTable a la tabla con Id $vista
    var table = $('#agenda').DataTable();

    // Aplica el buscador
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
</script>