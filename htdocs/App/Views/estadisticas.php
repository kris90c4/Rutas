<?php 

	//var_export($usuarioMails); 
	for ($i=0; $i < count($usuarioMails); $i++) { 
		$mails[$usuarioMails[$i]['nombre']]=$usuarioMails[$i]['mails'];
	}
	//var_export($usuarioTraspasos); 

	for ($i=0; $i < count($horas); $i++) { 
		$hora[]=$horas[$i]['hora'];
		$cantidad[]=$horas[$i]['cantidad'];
	}

?>
<div>
	<div id="estadisticas">

		<h1>Estadisticas</h1>
		<form action="" method="POST">
			
		</form>
		<select id="control">
			<option value="">Todos</option>
			<option value="cv">Compraventas</option>
			<option value="v">Particulares</option>
		</select>
		<table id="ajax1">
			<thead>
				<tr><th>Nombre</th><th>Nº Traspasos</th><th>Nº Mails</th><th>% Mails</th></tr>
			</thead>
			<tbody>


			</tbody>
		</table>


		<table>
			<thead>
				<tr><th>Nombre</th><th>Nº Traspasos</th><th>Nº Mails</th><th>% Mails</th></tr>
			</thead>
			<tbody>
		<?php for ($i=0; $i < count($usuarioTraspasos); $i++): ?>
			<tr>
				<td><?= $nombres[$i]=$usuarioTraspasos[$i]['nombre'] ?></td>
				<td><?= $traspasos[$i]=$usuarioTraspasos[$i]['traspasos'] ?></td>
				<td><?= $Mails[$i]=isset($mails[$usuarioTraspasos[$i]['nombre']])?$mails[$usuarioTraspasos[$i]['nombre']]:0 ?></td>
				<td><?= round($Mails[$i]/ $traspasos[$i]*100,2). " %" ?></td>
			</tr>
		<?php endfor; ?>
			<tr><th>Total</th><td><?= array_sum($traspasos) ?></td><td><?= array_sum($mails) ?></td></tr>
			</tbody>
		</table>
		<!--table>
			<thead><tr><th>datos</th><th>Traspasos</th></thead>
			<tbody><tr><td><?= $datos[0]['vehiculos'] ?></td><td><?= $datos[0]['traspasos'] ?></tr></tbody>
		</table-->
		<table>
			<tr>
				<th>Particulares</th><td><?= $datos[0]['particulares'] ?></td>
			</tr>
			<tr>
				<th>compraventas</th><td><?= $datos[0]['compraventas'] ?></td>
			</tr>
		</table>
		
		<table>
			<thead><tr><th>Tipo</th><th>total</th></tr></thead>
			<tbody>
			<?php for ($i=0; $i < count($tipos); $i++): ?>
				<tr><td><?= $tipos[$i]['tipo'] ?></td><td><?= $tipos[$i]['total'] ?></td></tr>
			<?php endfor; ?>
			</tbody>
		</table>
	</div>
	<div style="width:500px; ">
		<canvas id="myChart"></canvas>
	</div>
</div>
<div style="width:500px; ">
	<canvas id="horas"></canvas>
</div>
<!--button id="cristina">cristina</button>

<label for="">Registros: </label><span id="resultado"></span-->

<script>
	ajax1("");

	$('#control').on('change',function(){
		console.log($(this).val());
		ajax1($(this).val());
	})

	function ajax1(entrada){
		$.post("?controller=estadisticas&action=ajax1",{
			'vcv': entrada
		},function(data){
			console.log(data);
			info=JSON.parse(data);
			//console.log(info);
			tabla=$("#ajax1 tbody");
			console.log(info);
			tabla.html('');
			traspasos=0;
			mails=0;
			for (var i = 0; i < info.length; i++) {
				traspasos+=parseInt(info[i][1]);
				mails+=parseInt(info[i][2]);
				tabla.append(
					$('<tr>').append(
						$('<td>',{'html':info[i][0]}),
						$('<td>',{'html':info[i][1]}),
						$('<td>',{'html':info[i][2]}),
						$('<td>',{'html':Math.round(info[i][2]/info[i][1]*100)+"%"})

					)

				)
			}
			tabla.append(
				$('<tr>').append(
					$('<td>',{'html':'total'}),
					$('<td>',{'html':traspasos}),
					$('<td>',{'html':mails})
				)
			)
		})
	}

	$('#cristina').on('click',function(){
		//$.post('?controller')
	});
	datos=new Array;
	datos['nombres']=JSON.parse('<?= json_encode($nombres) ?>');
	datos['traspasos']=JSON.parse('<?= json_encode($traspasos) ?>');
	datos['mails']=JSON.parse('<?= json_encode($Mails) ?>');
	//console.log(datos);
	var ctx = $("#myChart");
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: datos['nombres'],
	        datasets: [{
	            label: 'Traspasos',
	            data: datos['traspasos'],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        },{
	        	 label: 'mails',
	        	 data: datos['mails'],
	        	 type: 'line'
	        }]
	    }
	});

	datos['hora']=JSON.parse('<?= json_encode($hora) ?>');
	datos['cantidad']=JSON.parse('<?= json_encode($cantidad) ?>');
	
	//console.log(datos['hora'])
	//console.log(datos['cantidad'])

	var ctx2 = $("#horas");
	var myLineChart = new Chart(ctx2, {
	    type: 'line',
	     data: {
	        labels: datos['hora'],
	        datasets: [{
	            label: 'Traspasos',
	            data: datos['cantidad'],
	           
            	borderColor: 'rgb(255, 99, 132)',
            	borderWidth: 1
	        }]
	    },
	    options: {}
	});


</script>