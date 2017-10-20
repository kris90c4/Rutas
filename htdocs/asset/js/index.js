// VALIDACIONES Registrar

//Al perder el foco el correo, se valida si ya existe
$("#registrar input[name=mail]").blur(function(){
	// Se postea, si responde, existe el correo
	$.post("?controller=registrar&action=checkMail",{
		mail: $(this).val()
	},
	function(data){
		//Si existe el correo se le aplica foco de nuevo y se abre un dialogo
		if(data){
			$("#registrar input[name=mail]").focus();
			$("#validation").html(data).dialog();
		}
	})
});
// Validacion de confirmar contraseña
$("#registrar input[name=pass]").blur(function(){
	$("#registrar input[name=cpass]").attr("pattern",$(this).val());
});

// Gestion Usuarios

$("#gestionUsuarios .reset").click(function(){
	boton=$(this);
	$.post(
		"?controller=perfil&action=resetPass",
		{
			id: $(this).prev().val()
		},
		function(data){
			if(data){
				$('#errorGestion').html(data).dialog();
				boton.addClass("btn-danger");
			}else{
				boton.addClass("btn-success");
			}
		}
	);
});
$("#gestionUsuarios .del").click(function(){
	boton=$(this);
	$.post(
		"?controller=perfil&action=delUser",
		{
			id: $(this).prev().prev().val(),
			admin: $(this).parents("tr").find("td:nth-child(5)").html()
		},
		function(data){
			if(data=="No puedes eliminar un administrador"){
				boton.addClass("btn-danger");
				$('#errorGestion').html(data).dialog();
			}else if(data){    
				$('#errorGestion').html(data).dialog();
			}else{
				boton.parents("tr").remove();
			}
		}
	);
});

$("#gestionUsuarios").DataTable();

//Agenda

$("#agenda").DataTable();

//HOTFIX: Se posiciona el puntero al final del texto(ARREGLAR)
function aMays(e, elemento) {
	tecla=(document.all) ? e.keyCode : e.which;
	elemento.value = elemento.value.toUpperCase();
}

// Información nuevo compraventa
$('#info_gestion').on('click',function(){
	swal('Para calcular el precio de la gestión', 'Hay que restar 58€ al total del traspaso<br>Por ejemplo, Rollando paga 85€ por traspaso, al restarle 58€(Que son las tasas fijas), el coste de la gestión se queda en 27€','info');
});


function keyOff(){
	return false;
}






										//////////////// ENTRADAS \\\\\\\\\\\\\\\\\\

$('#entradas').ready(function() {

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

	//Envia un correo con todos los telefonos seleccionados a comercial@gestoriaportol.com
	$('#enviar').on('click',function(){
		$.post('?controller=entrada&action=enviar',{
			
		},function(data){
			if(data>0&&data<100){
				swal('Se ha enviado el correo correctamente con '+data+' telefonos, paciencia, el correo esta por llegar');
			}else if(data=="error"){
				swal('No se ha enviado el correo, contacta con el administrador');
				console.log(data);
			}else if(data==0){
				swal('No se ha seleccionado ningun registro');
			}else{
				swal(data);
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
		$.post('?controller=entrada&action=descargarsalida',{
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
				$.post('?controller=entrada&action=descargarsalida',{
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
	setTimeout(function(){
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
		/*$('.opciones button:nth-child(3)').on('click',function(){
			table2.reload();
		});*/
		
	},100);
});

							////////////////// FIN ENTRADAS \\\\\\\\\\\\\\\\\\\\





