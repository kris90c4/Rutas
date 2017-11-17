<?php 

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
				<label for="">Usuario: </label>
				<select id="usuarios"></select>
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
	
	// Se consultan todos los datos
	filtro("");
	// Se envia una peticion ajax con los datos de los filtros y se procesan los datos devueltos
	$('#filtrar').on('click',function(){
		//Se prepara un objeto con los datos de cada filtro.
		datos={'entrada':$('input[name=control]:checked').val(),'desde':$('#desde').val(),'hasta':$('#hasta').val(),'usuario':$('#usuarios').val()};
		console.log("Datos enviados para filtrar: ",datos);
		//Se procesan los datos devueltos
		filtro(datos);
	})

	//Se cargan los datos de las estadisticas
	function filtro(datos){
		//Se realiza una consulta ajax con los datos de los filtros
		$.post("?controller=estadisticas&action=filtro",{
			'vcv': datos['entrada'],
			'desde': datos['desde'],
			'hasta': datos['hasta'],
			'usuario': datos['usuario']
		},function(data){
			console.log(data);
			// Se obtiene un objeto el cual almacena un objeto por cada grafica.
			info=JSON.parse(data);
			//console.log(info);

			/////////////////////////////  GRAFICA USUARIOS //////////////////////////////////////
			tabla=$("#ajax1 tbody");
			tabla.html('');
			if(contador==0){
				selectUsuarios=$('#usuarios');
				selectUsuarios.html('').append(
					$('<option>',{'value':'','html':'Todos'})
				);
			}
			usuarios={"nombre":[],"traspasos":[],"mails":[],"totalTraspasos":0,"totalMails":0};
			//Se extrae el contenido
			for (var i = 0; i < info['usuarios'].length; i++) {
				usuarios['nombre'][i]=info['usuarios'][i]['nombre'];
				usuarios['traspasos'][i]=info['usuarios'][i]['traspasos'];
				usuarios['mails'][i]=info['usuarios'][i]['mails'];
				usuarios['totalTraspasos']+=parseInt(info['usuarios'][i]['traspasos']);
				usuarios['totalMails']+=parseInt(info['usuarios'][i]['mails']);
				if(contador==0){
					selectUsuarios.append(
						$('<option>',{'value':usuarios['nombre'][i],'html':usuarios['nombre'][i]})
					);
				}
				tabla.append(
					$('<tr>').append(
						$('<td>',{'html':usuarios['nombre'][i]}),
						$('<td>',{'html':usuarios['traspasos'][i]}),
						$('<td>',{'html':usuarios['mails'][i]}),
						$('<td>',{'html':Math.round(usuarios['mails'][i]/usuarios['traspasos'][i]*100)+"%"})
					)
				)
			}
			tabla.append(
				$('<tr>').append(
					$('<td>',{'html':'total'}),
					$('<td>',{'html':usuarios['totalTraspasos']}),
					$('<td>',{'html':usuarios['totalMails']})
				)
			)
			// Traspasos por usuarios
			var ctx = $("#myChart");
			datosGrafica1={
		        labels: usuarios['nombre'],
		        datasets: [{
		            label: 'Traspasos',
		            data: usuarios['traspasos'],
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
		        	 data: usuarios['mails'],
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
						},
						scales:{
							yAxes:[{
								ticks:{
									//max: 120
								}
							}]
						}
					}
				});
			}
			//////////////////////////////// FIN GRAFICA USUARIO ////////////////////////////////////

			////////////////////////////// GRAFICA DIARIA //////////////////////////////////
			diaria={'fecha':[],'traspasos':[],'mails':[],'dayofweek':[],'dayofweek2':[]};
			
			for (var i = 0; i < info['diaria'].length; i++) {
				diaria['fecha'][i]=info['diaria'][i]['fecha'];
				diaria['traspasos'][i]=info['diaria'][i]['traspasos'];
				diaria['mails'][i]=info['diaria'][i]['mails'];
				c=info['diaria'][i]['dayofweek']*35;
				diaria['dayofweek'][i]='rgb('+c+','+c+','+c+')';
				diaria['dayofweek2'][i]=info['diaria'][i]['dayofweek'];
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
						pointRadius: diaria['dayofweek2'],
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
			//////////////////////////////// FIN GRAFICA DIARIA ///////////////////////////


			//////////////////////////////// GRAFICA HORAS ///////////////////////////////
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
			///////////////////////////// FIN GRAFICA HORAS //////////////////////////////
			contador++;
		})
	}



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
			if(data['datasets'][i]['pointRadius']){
				dataset.pointRadius=data['datasets'][i]['pointRadius'];
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