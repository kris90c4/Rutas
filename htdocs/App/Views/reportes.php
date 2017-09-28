<div class="reportes">
	<h2>Reportes</h2>
	<select name="estado" id="estado">
		<option value="todos">todos</option>
		<option value="pendientes">Pendientes</option>
		<option value="hechos">Hechos</option>
	</select>
	<ul>
		<?php if(!empty($reportes)):?>

			<?php /* Cada Reporte */ foreach ($reportes as $key => $value): ?>
				<li class="<?= $value['hecho']?"hecho":"pendiente"; ?>">
					<div class="meta">
						<h4>Fecha:</h4>
						<p><?= $value['fecha'] ?></p>
						<h4 style="display: inline-block;">Estado:</h4><font class=<?= $value['hecho']?"\"label label-success\">Resuelto":"\"label label-danger\" >Pendiente" ; ?></font>
						<br><button class="cerrar btn btn-default" data="<?= $value['id'] ?>">Cerrar</button>
						
					</div>
					<div class="titulo">
						<h3><?= $value['titulo'] ?></h3>
					</div>
					<div class="contenido">
						<p><?= $value['descripcion'] ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>
				<p>No Hay reportes</p>
			</li>
		<?php endif; ?>
	</ul>
</div>
<script>

	//Filtro 
	$('#estado').on('change',function(){
		if($(this).val()=='todos'){
			$('li').show();
		}else if($(this).val()=='pendientes'){
			$('.pendiente').show();
			$('.hecho').hide();
		}else{
			$('.pendiente').hide();
			$('.hecho').show();
		}
	});


	//Se pone el estado como hecho
	$('.cerrar').on('click',function(){
		cerrar=$(this);
		id=$(this).attr('data');
		$.post('?controller=reportes&action=ready',{
			'id' : id
		},function(data){
			console.log(data);
		})
	});

</script>