<script type="text/javascript">
$(document).ready(function() {
    // Añade placeholder en los imputs
    $('#<?=$vista?> tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    } );
    //Busca el campo seleccionado
    $('#<?=$vista?>').DataTable( {
        "initComplete": function () {
            var api = this.api();
            api.$('td').dblclick( function () {
                input=$(this).html("<input type='date' name='salida'/> ");
                $("input").blur(function(){
                	console.log($(this));
					console.log("blur");
					$.post("?controller=<?= $vista ?>&action=updateSalida",
					{
						id: input.value
						
					},
					function(data,status){
						alert("Data: " + data + "\nStatus: " + status);
					});
			    });
            } );

        }
    } );
    

    // Aplica la api de DataTable a la tabla con Id $vista
    var table = $('#<?=$vista?>').DataTable();

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
    $('button').click( function() {
        var data = table.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n"+
            data.substr( 0, 120 )+'...'
        );
        return false;
    } );
} );
</script>
<div class="btn-group">
	<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
	<ul class="dropdown-menu " role="menu">
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/json.png" width="24px"> JSON</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/json.png" width="24px"> JSON (ignoreColumn)</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'true'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/json.png" width="24px"> JSON (with Escape)</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'xml',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/xml.png" width="24px"> XML</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'sql'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/sql.png" width="24px"> SQL</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'csv',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/csv.png" width="24px"> CSV</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'txt',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/txt.png" width="24px"> TXT</a></li>
		<li class="divider"></li>
		
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'excel',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/xls.png" width="24px"> XLS</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'doc',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/word.png" width="24px"> Word</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'powerpoint',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/ppt.png" width="24px"> PowerPoint</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'png',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/png.png" width="24px"> PNG</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../media/icons/pdf.png" width="24px"> PDF</a></li>
		
		
	</ul>
</div>
<div>
	<button type="submit">Enviar formulario</button>
	<table id="<?= $vista ?>" class="display" >
	<?php if (!empty($$vista)): ?>
		<thead>
			<tr>
				<?php $tem=$$vista ?>
				<?php foreach (array_keys($tem[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<?php foreach (array_keys($tem[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</tfoot>
		<?php 	foreach ($$vista as  $value): ?>
			<tr>
			<input type="hidden" name="id" value="<?= $value['id']; ?>">
			<?php foreach ($value as $key => $value):?>
				<td><?= $value ?></td>
			<?php endforeach;?>
			</tr>
		<?php endforeach;?>
	<?php endif;?>
	</table>
</div>
<div class="btn btn-default">
	<a href="?controller=<?= $vista ?>&action=create">Nuevo Registro</a>
</div>
