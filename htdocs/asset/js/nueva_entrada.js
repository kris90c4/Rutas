$('#conf').on('click',function(e){
		console.log(e);
		$( "#modal620" ).css({"top":(e.clientY-50)+"px","left":(e.clientX+20)+"px"}).show();
	});
	$("#modal620 #close").on("click",function(){
		$( "#modal620" ).hide();
	})

	// calculo de precio base vehiculo
	$('#bt').on('click',function(){
		//$(this).html($('<img src="asset/gifs/ajax-loader (1).gif">'));
		if(typeof ajax1 !== 'undefined'){
			ajax1.abort();
		}
		crono(true);
		ajax1=$.post('?controller=entrada&action=find620',{
			"matricula": $('#matricula').val(),
			"precio": $('#inicial').val()
		},function(data){
			//console.log(data);
			info=JSON.parse(data);
			console.log(info);
			if(info['error']==""){
				swal(info['error']);
			}else{
				$('#base_imponible').val(info['precio']);
				swal({
					title: '<i>Datos</i>',
					html:
						'<label for="">Marca: </label><span>'+info['marca']+'</span><br>' +
						'<label for="">Modelo: </label><span>'+info['modelo']+'</span><br>' +
						'<label for="">Cilindrada: </label><span>'+info['cilindrada']+'</span><br>' +
						'<label for="">Bastidor: </label><span>'+info['bastidor']+'</span><br>' +
						'<label for="">Fecha matriculacion: </label><span>'+info['fechaMatri']+'</span><br>'+
						'<label for="">CVf: </label><span>'+info['cvf']+'</span><br><br>'+
						'<label for="">Base imponible: </label><span>'+info['precio']+'€</span><br>'+
						'<label for="">Cuota: </label><span>'+info['cuota']+'€</span><br>'+
						'<label for="">Tipo de gravamen: </label><span>'+(info['cuota']/info['precio']*100)+'%</span><hr>'+
						'<label for="">Precio del Traspaso: </label><span style="color:red">'+(info['cuota']+121)+'€</span><br>',
					customClass: 'datos'
				});
				$('#tipo_de_gravamen').val(info['cuota']/info['precio']*100);
				calculo();
			}
			//$('#bt').html('620');
			crono(false);
		})
	});

	function crono(estado){
		if(typeof crono2 !== 'undefined'){
			clearInterval(crono2);
		}
		if(estado==true){
			i=0;
			$('#bt').css('background','#ddd');
			crono2=setInterval(function(){
				$('#bt').text(i+'s');
				if(i==30){
					$('#bt').css('background','green');
				}else if(i==50){
					$('#bt').css('background','yellow');
				}else if(i==70){
					$('#bt').css('background','red');
				}
				i++;
				
			},1000)
		}else{
			clearInterval(crono2);
			//$('#bt').html('620');
		}
	}

	$('#datosVehiculo').on('click',function(){
		$.post('?controller=entrada&action=jsonDatosVehiculo',{
			'matricula': $('#matricula').val()
		},function(data){
			info=JSON.parse(data);
			console.log(info);
			swal({
				title: '<i>Datos</i>',
				html: 
					'<label for="">Marca: </label><span>'+info['marca']+'</span><br>' +
					'<label for="">Modelo: </label><span>'+info['modelo']+'</span><br>' +
					'<label for="">Cilindrada: </label><span>'+info['cilindrada']+'</span><br>' +
					'<label for="">Bastidor: </label><span>'+info['bastidor']+'</span><br>' +
					'<label for="">Fecha matriculacion: </label><span>'+info['fechaMatri']+'</span><br>'+
					'<label for="">CVf: </label><span>'+info['cvf']+'</span><br><br>',
				customClass: 'datos'
			});
		})
	})

	$('#nuevo').on('click',function(e){
		e.preventDefault();

		modal1=new modal();
		$.post("App\\Views\\nuevoCompraventa.php", function(htmlexterno){
			modal1.open({content: htmlexterno,class:"form"});
		});
	});

	$('#mismoCV').on('click',function(e){
		e.preventDefault();
		$('#comprador').val($('#vendedor').val());
		$('#cTlf').val($('#vTlf').val());
		$('#cMail').val($('#vMail').val());
	});

	// Maximo 9 digitos por telefono y solo numeros
	$('.tlf, #base_imponible').on('keypress',function(event){
		if(event.keyCode<48 || event.keyCode>57 || $(this).val().length>8){
			return false;
		}

	});

	//Calculo presupuesto dinamico
/*
	$('#base_imponible, #tipo_de_gravamen').blur(function(){
		if($.isNumeric($(this).val())){
			gravamen=$('#tipo_de_gravamen').val();
			m620=$('#base_imponible').val()*gravamen/100;
		}
	})*/



	gestion=63;
	m620=0;
	tipo=[];
	tipo[1]=58;
	tipo[2]=12.4;
	tipo[3]=58;
	tipo[4]=70.4;
	correo=15;

	$('#precio').html(gestion+tipo[3]+m620);

	function calculo(){
		setTimeout(function(){
			//Se mira
			if($.isNumeric($('#base_imponible').val()) && $('#base_imponible').val()>0){
				gravamen=$('#tipo_de_gravamen').val();
				console.log("Base imponible",$('#base_imponible').val())
				m620=$('#base_imponible').val()*gravamen/100;
			}
			if($('#tipo').val()=='cv'){
				if($.isNumeric($('#gestion').val())){
					gestion=parseInt($('#gestion').val());
				}else{
					gestion=0;
				}
			}else{
				gestion=63;
			}
			if($('#correo_ordinario').val()==1){
				gestion+=correo;
			}


			i=$('#tipo_traspaso').val();

			$('#precio').html(gestion+tipo[i]+m620);
			console.log(gestion,tipo[i],m620);
		},300)
	}

	$(document).on('change',function(){
		calculo();
	});


	//Muestra un swal() en caso de devolver un error
	/*if("<?= isset($error)?$error:"" ?>"){
		swal('<?= isset($error)?$error:"" ?>');
	}*/

	// devuelve un swal() en caso de existir el numero, da la opcion de usar el actual o modificarlo
	$('.tlf').on('blur',function(){
		nombre=$(this).closest('div').find(".nombre");
		telefono=$(this);
		mail=$(this).siblings('.wrap').find('.mail');
		

		if($(this).val()!=""){
			$.post('?controller=entrada&action=no_duplicar&parametros='+ $(this).val(),{

			},
			function(data){
				if(data){
				
					if(data = JSON.parse(data)){
						
						swal('El telefono ya existe',
							'Nombre: '+data['nombre']+'<br>Telefono: '+data['telefono']+'<br>Mail: '+ data['mail'],
							'info');
						swal({
							title: 'El telefono ya existe',
							type: 'info',
							html:
								"<div>"+
								'<b>Nombre: </b>'+data['nombre']+
								'<br><b>Telefono: </b>'+data['telefono']+
								'<br><b>Mail: </b>'+ data['mail']+
								"</div>",
							showCloseButton: true,
							showCancelButton: true,
							confirmButtonText:
								'Usar',
							cancelButtonText:
								'Actualizar'
						}).then(function () {
							nombre.val(data['nombre']);
							telefono.val(data['telefono']);
							mail.val(data['mail']);
							}, function (dismiss) {
								if (dismiss === 'cancel') {
								swal({
									title: 'Actualizar Cliente',
									html:
										'<label>Nombre</label><input id="swal-input1" class="swal2-input">' +
										'<label>Telefono</label><input readonly="readonly" id="swal-input2" class="swal2-input">' +
										'<label>Mail</label><input id="swal-input3" class="swal2-input">',
									showCloseButton: true,
									showCancelButton: true,
									confirmButtonText:
										'Actualizar',
									cancelButtonText:
										'cerrar',
									preConfirm: function () {
										return new Promise(function (resolve) {
											resolve([
												$('#swal-input1').val(),
												$('#swal-input2').val(),
												$('#swal-input3').val()
											])
										})
									},
									onOpen: function () {
										input=[];
										input['nombre']=$('#swal-input1').focus().val(data['nombre']);
										input['telefono']=$('#swal-input2').val(data['telefono']);
										input['mail']=$('#swal-input3').val(data['mail']);
									}
								}).then(function (result) {
									
									//swal(JSON.stringify(result));
									// En caso de actualizar el cliente
									$.post('?controller=cliente&action=actualizar',{
										'nombre': result[0],
										'telefono':result[1],
										'mail':result[2]
									},function(data){
										console.log(data);
										if(data==1){
											nombre.val(result[0]);
											telefono.val(result[1]);
											mail.val(result[2]);
										}else{
											
										}
									});
								},function(dismiss){

								}).catch(swal.noop)
							}
						});	
					}
				}
			});
		}
	});

	function cv(){
		// Se comprueba si se ha usado la opcion de compraventa,
		console.log($('#tipo').val());
		if($('#tipo').val()=="cv"){
			$('#vcv').html('Compraventa');
			$('.cvButton').css('display','block');
			$('#vTlf, #vMail').on('keydown',keyOff);
			$('#vTlf, #vMail').val("");
			$('#vMND, #vTND').hide();
			// Se crea un evento para mostrar los compraventas disponibles
			$('#vendedor').on('keyup',function(){
				//se realiza un post via ajax para consultar los resultados encontrados con las letras introducidas
				$.post("?controller=compraventa&action=find",{
					cv: $(this).val()
				},
				function(data){
					var content = JSON.parse(data);
					// se vacia datalist cada vez para evitar duplicidades
					$('#cv').empty();
					// se crean todas las opciones del datalist con un value y un id
					for (var i = 0; i < content.length; i++) {
						option= $('<option>',{
							value : content[i]['nombre'],
							id: content[i]['id']
						})
						$('#cv').append(option);
					}

					nombre=$("#vendedor");
					//se aplica un evento cuando se selecciona una opcion del datalist
					// La cual rellena automaticamente unos campos
					nombre.on("blur", function(){
						for (var i = 0; i < content.length; i++) {
							if(content[i]['nombre'].toLowerCase() === nombre.val().toLowerCase()){
								$('#vMail').val(content[i]['mail']);
								$('#vTlf').val(content[i]['telefono']);
								$('#gestion').val(content[i]['gestion']);
								$('#nv').val(content[i]['nv']);
								$('#info').html(content[i]['gestion']);
								$('#id_compraventa').val(content[i]['id']);
								$('#comprador').focus();
							}
						}
					});

				});
			});
		}else{
			$('#vTlf, #vMail').off('keydown',keyOff);
			$('#vcv').html('Vendedor');
			$('.cvButton').hide();
			$('#vMND, #vTND').show();
		}
	}

	// Al seleccionar una opcion del primer select
	$('#entrada').ready(function(){
		if($('#tipo').val()=='cv'){
			tlf=$('#vTlf').val();
			mail=$('#vMail').val();
			cv();
			$('#vTlf').val(tlf);
			$('#vMail').val(mail);
		}
		console.log("eventCv");
		$('#tipo').on('change',cv);
	});
	var options=['@gmail.com','@gmail.es','@hotmail.com','@hotmail.es'];
	$('#vMail').on('keyup',function(){
		$('#autoMail').empty();
		for (var i = 0; i < options.length; i++) {
			option = $('<option>',{
				value : $(this).val()+options[i],
			})
			$('#autoMail').append(option);
		}
	});
	$('#cMail').on('keyup',function(){
		$('#autoMail2').empty();
		for (var i = 0; i < options.length; i++) {
			option = $('<option>',{
				value : $(this).val()+options[i],
			})
			$('#autoMail2').append(option);
		}
	});
	$('.default').on('click',function(){
		$(this).prev().val('No disponible');
	});
	$('.noTlf').on('click',function(){
		$(this).prev().val('0');
	});