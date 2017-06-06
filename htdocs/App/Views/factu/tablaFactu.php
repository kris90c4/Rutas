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
            //al hacer doble click sobre alguna fecha de salida
            api.$('.salida').dblclick( function () {
            	actual=this.innerHTML;
                $(this).html("<input type='date' name='salida' value='<?= date("Y-m-d") ?>'/> ");
                $("input[type=date]").focus();
                //Al perder el foco
                $("td input").blur(function(){
                	//al perder el foco se preguna si se esta seguro de querer modificar la fecha
                	ok=confirm("Estas seguro que quieres modificar la fecha de salida por \n"+$(this).val()+"?");
                	if(ok){
                		controlador="<?= $vista ?>";
                		controlador=controlador=="matriculaciones"?"matri":controlador;
	                	//Se envia un POST via ajax
						respuesta = $.post("?controller="+controlador+"&action=updateSalida",
						//Con el id y la fecha nueva
						{
							id: $(this).closest("tr").find("input[type=hidden]")[0].value,
							date : $(this).val()
						},
						function(data,status){
							if(data){
								alert(data+"\n"+status);
							}
							
						});
						//Se remplaza el input por la fecha seleccionada
						$(this).replaceWith($(this).val());
					}else{
						//Se deja la fecha que habia
						$(this).replaceWith(actual);
					}
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
} );
</script>
<div class="btn-group">
	<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exportar datos</button>
	<ul class="dropdown-menu " role="menu">
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/json.png" width="24px"> JSON</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/json.png" width="24px"> JSON (ignoreColumn)</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'json',escape:'true'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/json.png" width="24px"> JSON (with Escape)</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'xml',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/xml.png" width="24px"> XML</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'sql'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/sql.png" width="24px"> SQL</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'csv',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/csv.png" width="24px"> CSV</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'txt',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/txt.png" width="24px"> TXT</a></li>
		<li class="divider"></li>
		
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'excel',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/xls.png" width="24px"> XLS</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'doc',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/word.png" width="24px"> Word</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'powerpoint',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/ppt.png" width="24px"> PowerPoint</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'png',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/png.png" width="24px"> PNG</a></li>
		<li><a href="#" onclick="$('#<?=$vista?>').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src="/<?= $_SERVER['HTTP_HOST'] ?>/../../asset/icons/pdf.png" width="24px"> PDF</a></li>
		
		
	</ul>
</div>
<div id="factu">
	<!-- Se aplica el id de la vista de facturacion seleccionada -->
	<table id="<?= $vista ?>" class="display" >
	<!-- Se comprueba que existan registros antes de imprimir todos los datos -->
	<?php if (!empty($$vista)): ?>
		<thead>
			<tr>
				<?php $tem=$$vista ?>
				<!-- Se recorren todos los indices y se crea una columna por cada indice -->
				<?php foreach (array_keys($tem[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<!-- Lo mismo pero para el footer, que sera el encargado de buscar por columna -->
				<?php foreach (array_keys($tem[0])as $value): ?>
					<?="<th>".ucfirst ($value)."</th>"?>
				<?php endforeach;?>
			</tr>
		</tfoot>
		<!-- Se imprimen todos los datos de la base de datos y se almacena en un input hidden el id para poder identificar cada fila a la hora de atacar a la base de datos -->
		<?php foreach ($$vista as  $value): ?>
			<tr>
				<input type="hidden" name="id" value="<?= $value['id']; ?>">
				<?php foreach ($value as $key => $value):?>
					<td <?= $key=="salida"?"class='salida'":"" ?>><?= $value ?></td>
				<?php endforeach;?>
			</tr>
		<?php endforeach;?>
	<?php endif;?>
	</table>
</div>

<!-- Se crea un boton para abrir el formulario de nuevo registro -->
<div class="btn btn-default">
	<a href="?controller=<?= $vista=="matriculaciones"?"matri":$vista ?>&action=create">Nuevo Registro</a>
</div>
