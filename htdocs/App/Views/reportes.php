<div class="reportes">
	<h2>Reportes</h2>
	<ul>
		<?php if(!empty($reportes)):?>

			<?php /* Cada Reporte */ foreach ($reportes as $key => $value): ?>
				<li>
					<div class="meta">
						<h4>Fecha:</h4>
						<p><?= $value['fecha'] ?></p>
						<h4>Estado:</h4><font style="background: red"><?php echo $value['hecho']?"Resuelto":"Pendiente"; ?></font>
						
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