//////////////// ENTRADAS \\\\\\\\\\\\\\\\\\

$(document).ready(function() {

	//Se añade el evento del boton Nueva Entrada. Se abre un modal
	$('#nuevaEntrada').on('click',function(e){
		e.preventDefault();
		modal2=new modal();
		$.post("App\\Views\\entrada.php", function(htmlexterno){
			modal2.open({content: htmlexterno,id:'plantilla'});
		});
	});

	// Al recargar la pagina, se vuelven a seleccionar los registros seleccionados previamente
	$.post("?controller=entrada&action=check",{

	},function(data){
		if(data){
			check =jQuery.parseJSON(data);
			if(check.length>0){
				$('.opciones button:nth-child(3)').each(function(index){
					id=$(this).closest('tr').find('td:nth-child(1)').html();
					if(jQuery.inArray(id,check)>=0){
						$(this).toggleClass('seleccionar btn-default').html('Seleccionado');
						$(this).toggleClass('deseleccionar btn-danger');
					}
				});
			}else{
				console.log('No hay resultados');
			}
		}else{
			console.log('Error al ver la tabla enviados. Revisar controlador entrada y funcion check');
		}
	});
	
	////////////////////Nuevo, pendiente de probar

	$('#edit').on('click', function(){
		id=this.parents('td').first().value
	});

	$('.editar').on('click', function(){
		console.log("Editando");
		id=$(this).parents("tr").find("td:nth-child(1)").html();
		window.location.href='?controller=entrada&action=editar&parametros='+id;
	})

	//Añadir a lista para enviar telefonos por correo
	$('.seleccionar, .seleccionado').on('click',function(){
		boton=$(this);
		id=$(this).closest('tr').find('td:nth-child(1)').html();
		console.log($(this).hasClass('seleccionar'))
		if($(this).hasClass('seleccionar')){
			$.post("?controller=entrada&action=seleccionar",{
				'id_entrada' : id
			},function(data){
				if(data){//En caso de error
					console.log(data);
				}else{//Todo correcto
					console.log("seleccionado correctamente");
					$(boton).toggleClass('seleccionar btn-default').html('Seleccionado');
					$(boton).toggleClass('deseleccionar btn-danger');
				}
			});
		}else{
			$.post("?controller=entrada&action=deseleccionar",{
				'id' : id
			},function(data){
				if(data){//En caso de error
					console.log(data);
				}else{//Todo correcto
					console.log("deseleccionado correctamente");
					$(boton).toggleClass('seleccionar btn-default').html('Seleccionar');
					$(boton).toggleClass('deseleccionar btn-danger');
				}
			});
		}
	});

	//Confirma las entradas seleccionadas y graba la fecha de salida de todas ellas
	$('#confirmar').on('click',function(){
		$.post('?controller=entrada&action=confirmar',{
			
		},function(data){
			if(data=="ok"){
				swal('Se han grabado las fechas de salida correctamente');
			}else if(data==0){
				swal('No se ha seleccionado ningun registro');
			}else{
				swal('Ha habido algun problema, contacta con el administrador para reportar el problema');
				console.log(data);
			}
		})
	})

	//Desde el movil se abre un nuevo SMS con los contactos seleccionados
	$('#sms').on('click',function(e){
		$.post('?controller=entrada&action=enviar2',{
			'sms':1
		},function(data){
			info =jQuery.parseJSON(data);
			if(info['count']>0&&info['count']<100){
				window.location="sms:"+info['sms']+"?body=Gestoria Pòrtol, c/ Gran Via Asima, 15 1 izq, telf. 971908095. Le informamos de que su documentacion esta tramitada. Gracias.";
			}else if(info['count']==0){
				swal('No se ha seleccionado ningun registro');
			}else{
				swal(data);
				console.log(data);
			}
		})
		
	})


	$('#enviar').on('click',function(){
		$.post('?controller=entrada&action=enviar2',{
			
		},function(data){
			info =jQuery.parseJSON(data);
			if(info['error']=="error"){
				swal('No se ha enviado el correo, contacta con el administrador');
				console.log(data);
			}else{
				if(info['count']>0&&info['count']<100){
					swal('Se ha enviado el correo correctamente con '+info['count']+' telefonos, paciencia, el correo esta por llegar');
				}else if(info['count']==0){
					swal('No se ha seleccionado ningun registro');
				}else{
					swal(data);
				}
			}
		})
	})

	// Se descarga la plantilla de entrada
	$('.descarga').on('click',function(){
		id=$(this).closest('tr').find('td:nth-child(1)').html();
		$.post('?controller=entrada&action=descargar',{
			'id' : id
		},function(data){
			console.log(data);
			window.location.href=data;
		})
	});

	//Se descarga la plantilla de salida
	$('.descargarsalida').on('click',function(){
		id=$(this).closest('tr').find('td:nth-child(1)').html();
		$.post('?controller=entrada&action=descargar_salida',{
			'id' : id
		},function(data){
			window.location.href=data;
		})
	});

	//Entra en cada enlace
	$('.descargarTodasSalidas').on('click',function(){
		i=1;
		$('tbody tr').each(function(){
			
				id=$(this).find('td:nth-child(1)').html();
				$.post('?controller=entrada&action=descargar_salida',{
					'id' : id
				},function(data){
					//setTimeout(function(){
					window.location.href=data;
					//},i*500);
				})
				i++;
			
		});
	});

	$('#entrada tfoot th').each( function () {
		var title = $(this).text();
		$(this).html( '<input type="text" placeholder="'+title+'" />' );
	} );
	// Aplica la api de DataTable a la tabla con Id $vista
	//se aplica un retardo para asugurar la aplicacion del seleccionado
	function a1(){
		var table2 = $('#entrada').DataTable({
			"order": [[ 0, "desc" ]],
		});

		// Aplica el buscador
		table2.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			});
		});
		//$('.opciones button:nth-child(3)').on('click',function(){
		//	table2.reload();
		//});
		
	};
	requestAnimationFrame(a1);
});

							////////////////// FIN ENTRADAS \\\\\\\\\\\\\\\\\\\\




							