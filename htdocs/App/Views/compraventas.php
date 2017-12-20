<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<button class="btn btn-success" id="nuevo">Nuevo Compraventa</button>
	<table id="compraventa">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Gestion</th>
				<th>Nv</th>
				<th>Mail</th>
				<th>Telefono</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Gestion</th>
				<th>Nv</th>
				<th>Mail</th>
				<th>Telefono</th>
				<th>Opciones</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($clientes as $cliente): ?>
			<tr>
				<td><?= $cliente['id'] ?></td>
				<td><?= $cliente['nombre'] ?></td>
				<td><?= $cliente['gestion']?>€</td>
				<td><?= $cliente['nv']?>€</td>
				<td><?= $cliente['mail'] ?></td>
				<td><?= $cliente['telefono'] ?></td>
				<td>
					<a href="?controller=compraventa&action=create&parametros=<?= $cliente['id'] ?>" class="btn btn-success" id="edit">Editar</a>
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

	////////////////////Nuevo, pendiente de probar

	$('#compraventa .edit').on('click', function(){
		id=this.parents('td').first().value
	})
	// Elimina un contacto de la agenda
	$('#compraventa .del').on('click', function(){
		console.log("asd");
		boton=$(this);
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height: "auto",
			width: 350,
			modal: true,
			buttons: {
				"Eliminar": function() {
			    	$.post("?controller=compraventa&action=del",{
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


	$(document).ready(function() {
		// Setup - add a text input to each footer cell
		$('#compraventa tfoot th').each( function () {
		    var title = $(this).text();
		    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		} );

		// DataTable
		var table = $('#compraventa').DataTable({
			//"pageLength": 50
		});

		// Apply the search
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
	} );
	$('#nuevo').on('click',function(e){
		e.preventDefault();
		modal1=new modal();
		$.post("App\\Views\\nuevoCompraventa.php", function(htmlexterno){
			modal1.open({content: htmlexterno,class:"form"});
		});
	});
</script>