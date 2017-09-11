<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<a class="btn btn-default" href="?controller=entrada&action=create">Nueva entrada</a>
	<table id="entrada">
		<thead>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Nombre</th>
				<th>Mail</th>
				<th>Telefono</th>
				<th>Nombre2</th>
				<th>Mail2</th>
				<th>Telefono2</th>
				<th>Entrada</th>
				<th>Salida</th>
				<th>Operacion</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Matricula</th>
				<th>Nombre</th>
				<th>Mail</th>
				<th>Telefono</th>
				<th>Nombre2</th>
				<th>Mail2</th>
				<th>Telefono2</th>
				<th>Entrada</th>
				<th>Salida</th>
				<th>Operacion</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($entradas as  $entrada): ?>
			<tr>
				<td><?= $entrada['id'] ?></td>
				<td><?= strtoupper($entrada['matricula']) ?></td>
				<td><?= $entrada['nombre']?></td>
				<td><?= $entrada['mail'] ?></td>
				<td><?= $entrada['telefono'] ?></td>
				<td><?= $entrada['nombre2']?></td>
				<td><?= $entrada['mail2'] ?></td>
				<td><?= $entrada['telefono2'] ?></td>
				<td><?= $entrada['entrada'] ?></td>
				<td><?= $entrada['salida'] ?></td>
				<td>
					<button class="btn btn-success" id="editar">Editar</button>
					<a class="btn btn-info" href="App\Controllers\Traspasos\<?= $entrada['matricula'] ?>.xlsx">Descargar</a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorCliente"></div>
</div>

<script>

    ////////////////////Nuevo, pendiente de probar

    $('#edit').on('click', function(){
    	id=this.parents('td').first().value
    });

    $('#editar').on('click', function(){
    	id=$(this).parents("tr").find("td:nth-child(1)").html();
    	matricula=$(this).parents("tr").find("td:nth-child(2)").html();
    	$.post('?controller=entrada&action=editar',{
    		"matricula": matricula,
    		"id": id
    	}, 
    	function(data){
    		edit=JSON.parse(data);
    		console.log(edit);
    	});

    })


	// Aplica la api de DataTable a la tabla con Id $vista
    var table = $('#entrada').DataTable({
        "order": [[ 0, "desc" ]],

    });

    $('#entrada tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );

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