<script type="text/javascript">
$(document).ready(function() {
    // Añade placeholder en los imputs
    $('#traspasos tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );
    //Busca el campo seleccionado
    $('#traspasos').DataTable( {
        "initComplete": function () {
            var api = this.api();
            api.$('td').click( function () {
                api.search( this.innerHTML ).draw();
            } );
        }
    } );
 
    // Aplica la api de DataTable a la tabla con Id traspasos
    var table = $('#traspasos').DataTable();
 
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
} );
</script>
<div>
	<table id="traspasos" class="display">
	<?php if (!empty($traspasos)): ?>
		<thead>
			<tr>
				<?php foreach (array_keys($traspasos[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<?php foreach (array_keys($traspasos[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</tfoot>
		<?php 	foreach ($traspasos as  $value): ?>
			<tr>
			<?php foreach ($value as $key => $value):?>
				<td><?= $value ?></td>
			<?php endforeach;?>
			</tr>
		<?php endforeach;?>
	<?php endif;?>
	</table>
</div>
<div class="btn-redireccion">
	<a href="?controller=traspasos&action=create">Nuevo Registro</a>
</div>