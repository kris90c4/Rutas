<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<a href="?controller=agenda&action=create">Añadir cliente</a>
	<table id="agenda">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Gestion</th>
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
				<td><?= $cliente['gestion']?>€</td>
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

    ////////////////////Nuevo, pendiente de probar

    $('#agenda .edit').on('click', function(){
    	id=this.parents('td').first().value
    })
    // Elimina un contacto de la agenda
    $('#agenda .del').on('click', function(){
    	boton=$(this);
    	$( "#dialog-confirm" ).dialog({
			resizable: false,
			height: "auto",
			width: 350,
			modal: true,
			buttons: {
				"Eliminar": function() {			    	
			    	$.post("?controller=agenda&action=del",{
						id: $(boton).parents("tr").find("td:nth-child(1)").html()
					},
					function(data){
						if(data=="eliminado"){
							boton.parents("tr").remove();
						}else{    
							$('#errorCliente').html(data).dialog();
						}
					});
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
    })
</script>