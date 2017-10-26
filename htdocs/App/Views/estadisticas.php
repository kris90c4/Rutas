<?php 


	//var_export($diaria); 

	for ($i=0; $i < count($horas); $i++) { 
		$hora[]=$horas[$i]['hora'];
		$cantidad[]=$horas[$i]['cantidad'];
	}
	for ($i=0; $i < count($diaria); $i++) { 
		$fecha[]=$diaria[$i]['fecha'];
		$traspasos[]=$diaria[$i]['traspasos'];
		$mails[]=$diaria[$i]['mails'];
		$c=$diaria[$i]['dayofweek']*35;
		$dayofweek[]="rgb($c,$c,$c)";
	}

?>

<div id="estadisticas">
	<div>
		<h1>Estadisticas</h1>
		<ul>
			<li>
				<label for="">Todos</label><input type="radio" name="control" value="" checked>
			</li>
			<li>
				<label for="">Compraventas</label><input type="radio" name="control" value="cv">
			</li>
			<li>
				<label for="">Particulares</label><input type="radio" name="control" value="v">
			</li>
			<li>
				<label for="">Desde</label>
				<input id="desde" type="date">
			</li>
			<li>
				<label for="">Hasta</label>
				<input id="hasta" type="date" value="<?= date("Y-m-d") ?>">
			</li>
			<li>
				<button id="filtrar">Filtrar</button>
			</li>
		</ul>
		<table id="ajax1">
			<thead>
				<tr><th>Nombre</th><th>Nº Traspasos</th><th>Nº Mails</th><th>% Mails</th></tr>
			</thead>
			<tbody>
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

	<div style="width:500px; ">
		<canvas id="horas"></canvas>
	</div>
	<div style="width:1000px; ">
		<canvas id="diaria"></canvas>
	</div>
</div>

<script>
	var contador=0;
	
	ajax1("");
	$('#filtrar').on('click',function(){
		datos={'entrada':$('input[name=control]:checked').val(),'desde':$('#desde').val(),'hasta':$('#hasta').val()};
		console.log("Datos enviados para filtrar: ",datos);
		ajax1(datos);
	})

	//Se cargan los datos de las estadisticas
	function ajax1(datos){
		//Se realiza una consulta ajax con los datos de los filtros
		$.post("?controller=estadisticas&action=ajax1",{
			'vcv': datos['entrada'],
			'desde': datos['desde'],
			'hasta': datos['hasta']
		},function(data){
			//console.log(data);
			info=JSON.parse(data);
			console.log(info);
			//Se almacenarán los resultados de los usuarios
			tabla=$("#ajax1 tbody");
			tabla.html('');
			traspasos=0;
			mails=0;
			n= new Array();
			t= new Array();
			m= new Array();
			for (var i = 0; i < info['usuarios'].length; i++) {
				n[i]=info['usuarios'][i]['nombre'];
				t[i]=info['usuarios'][i]['traspasos'];
				m[i]=info['usuarios'][i]['mails'];
				traspasos+=parseInt(info['usuarios'][i]['traspasos']);
				mails+=parseInt(info['usuarios'][i]['mails']);
				tabla.append(
					$('<tr>').append(
						$('<td>',{'html':info['usuarios'][i]['nombre']}),
						$('<td>',{'html':info['usuarios'][i]['traspasos']}),
						$('<td>',{'html':info['usuarios'][i]['mails']}),
						$('<td>',{'html':Math.round(info['usuarios'][i]['mails']/info['usuarios'][i]['traspasos']*100)+"%"})
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
			// Traspasos por usuarios
			var ctx = $("#myChart");
			datosGrafica1={
		        labels: n,
		        datasets: [{
		            label: 'Traspasos',
		            data: t,
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
		        	 data: m,
		        	 type: 'line'
		        }]
		    }
			
			if(0<contador){
				update2(myChart,datosGrafica1);
			}else{
				myChart = new Chart(ctx, {
					type: 'bar',
					data: datosGrafica1,
					options: {
						title: {
							display: true,
							text: 'Usuarios'
						}
					}
				});
			}
			//
			diaria={'fecha':[],'traspasos':[],'mails':[],'dayofweek':[]};
			
			for (var i = 0; i < info['diaria'].length; i++) {
				diaria['fecha'][i]=info['diaria'][i]['fecha'];
				diaria['traspasos'][i]=info['diaria'][i]['traspasos'];
				diaria['mails'][i]=info['diaria'][i]['mails'];
				c=info['diaria'][i]['dayofweek']*35;
				diaria['dayofweek'][i]='rgb('+c+','+c+','+c+')';
			}
			// Traspasos y mails de cada dia
			ctx3 = $("#diaria");
			datosGrafica2={
					labels: diaria['fecha'],
					datasets: [{
						label: 'Traspasos',
						data: diaria['traspasos'],
						pointBackgroundColor: diaria['dayofweek'],
						pointBorderColor: diaria['dayofweek'],
						borderColor: 'rgb(25, 250, 25)',
						backgroundColor: 'rgba(25, 250, 25,0.5)',
						borderWidth: 1
					},{
						label: 'mails',
						data: diaria['mails'],
						borderColor: 'rgb(25, 25, 25)',
						backgroundColor: 'rgba(25, 25, 25,0.5)',
						type: 'line'
					}]
				};
				//console.log(datosGrafica2);
			if(0<contador){
				update2(myLineChart3,datosGrafica2);
			}else{
				myLineChart3 = new Chart(ctx3, {
					type: 'line',
					data: datosGrafica2,
					options: {
						title: {
							display: true,
							text: 'Diaria'
						}
					}
				});
			}
			//Se crea un objeto con dos arrays
			horas={'hora':[],'cantidad':[]};
			
			console.log(info['horas']);
			for (var i = 0; i < info['horas'].length; i++) {
				horas['hora'][i]=info['horas'][i]['hora'];
				horas['cantidad'][i]=info['horas'][i]['cantidad'];
			}
			ctx3 = $("#horas");
			datosGrafica3={
				labels: horas['hora'],
				datasets: [{
					label: 'Traspasos',
					data: horas['cantidad'],
					borderColor: 'rgb(255, 99, 132)',
					borderWidth: 1
				}]
			}
			if(0<contador){
				update2(myLineChart4,datosGrafica3);
			}else{
				myLineChart4 = new Chart(ctx3, {
					type: 'line',
					data: datosGrafica3,
					options: {
						title: {
							display: true,
							text: 'Media por hora'
						}
					}
				});
			}
			contador++;
		})
	}

	datos=new Array;
	/*
	datos['hora']=JSON.parse('<?= json_encode($hora) ?>');
	datos['cantidad']=JSON.parse('<?= json_encode($cantidad) ?>');

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
	});*/

	function addData(chart, label, data) {
		i=0;
	    chart.data.labels=label;
	    chart.data.datasets.forEach((dataset) => {
	        dataset.data=data[i];
	        i++;
	    });
	    chart.update();
	}

	function update2(chart, data) {
		//console.log(data);
		i=0;
		chart.data.labels=data['labels'];
		chart.data.datasets.forEach((dataset) => {
			dataset.data=data['datasets'][i]['data'];
			if(data['datasets'][i]['pointBackgroundColor']){
				dataset.pointBackgroundColor=data['datasets'][i]['pointBackgroundColor'];
			}
			if(data['datasets'][i]['pointBorderColor']){
				dataset.pointBorderColor=data['datasets'][i]['pointBorderColor'];
			}
			i++;
	    });
	    chart.update();
	}
	function update(chart, datos) {
	    chart.data=datos;
	    chart.update();
	}



	function removeData(chart) {
	    chart.data.labels.pop();
	    chart.data.datasets.forEach((dataset) => {
	        dataset.data.pop();
	    });
	    chart.update();
	}

/*
	diaria=new Array();
	diaria['fecha']=JSON.parse('<?= json_encode($fecha) ?>');
	diaria['traspasos']=JSON.parse('<?= json_encode($traspasos) ?>');
	diaria['mails']=JSON.parse('<?= json_encode($mails) ?>');
	diaria['dayofweek']=JSON.parse('<?= json_encode($dayofweek) ?>');


	var ctx3 = $("#diaria");
	var myLineChart = new Chart(ctx3, {
		type: 'line',
		data: {
			labels: diaria['fecha'],
			datasets: [{
				label: 'Traspasos',
				data: diaria['traspasos'],
				pointBackgroundColor: diaria['dayofweek'],
				pointBorderColor: diaria['dayofweek'],
				borderColor: 'rgb(25, 250, 25)',
				borderWidth: 1
			},{
				 label: 'mails',
				 data: diaria['mails'],
				 type: 'line'
			}]
		},
		options: {}
	});
*/

</script>