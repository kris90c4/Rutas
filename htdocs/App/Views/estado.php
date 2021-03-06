<?php
//var_export($id);
if(!empty($id)):
	$fecha2= new DateTime($id[0]['FPRESENTACION']);
	for ($i=0; $i < 4; $i++) { 
		if($fecha2->format('N')==6){
			$fecha2->add(new DateInterval('P2D'));
		}else if($fecha2->format('N')==5){
			$fecha2->add(new DateInterval('P3D'));
		}else{
			$fecha2->add(new DateInterval('P1D'));
		}
	}
	?>
	<br>
	<div id="estado">
		<h1>Estado de la tramitación</h1>
		<label for="">Fecha presentación:</label><span><?= date("d/m/Y",strtotime($id[0]['FPRESENTACION'])) ?></span><br>
		<label for="">Matrícula:</label><span><?= $id[0]['Matricula'] ?></span><br>
		<label for="">Nuevo títular:</label><span><?= $id[0]['Nombre'] .' '. $id[0]['Apellido'] ?></span><br>
		<label for="">Estado:</label><span><?= $id[0]['Anotaciones']==null?"El tramite esta en marcha":$id[0]['Anotaciones'] ?></span><br>
		<label for="">Fecha estimada:</label><span><?= $fecha2->format("d/m/Y") ?></span><br>
		<label for="">Anotaciones:</label><span><?= $id[0]['Anotaciones'] ?></span><br>
		<button onclick="localhost()" class="btn btn-info">Nueva Consulta</button>
	</div>
<?php elseif(count($_GET)>0): ?>
	<div id="estado">
		<h1>No existe la matricula en la base de datos de SIGA</h1>
		<p>Es posible que aun no se hayan introducido los datos en el programa de trafico</p>
	</div>
<?php else: ?>
	<div id="estado">
		<div id="plantilla" class="no">
			<form action="" method="GET">
				<div class="separador">
					<h2>Seguimiento del estado del tramite</h2>
					<input type="text" class="form-control" name="url" placeholder="CODIGO">
				</div>
				<input type="submit" class="btn" name="">
			</form>
		</div>
	</div>
<?php endif; ?>
<script type="text/javascript">
	function localhost(){
		location.href="http://portol.ddns.net";
	}
</script>