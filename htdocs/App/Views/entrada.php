<!-- http://ProgramarEnPHP.wordpress.com -->

<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<form id="plantilla" method="post" action="?controller=entrada2&action=<?= isset($editar)?"editado":"save" ?>">
	<div class="separador">
		<h3>Datos Traspaso</h3>
		<label>Solicitante</label><label style="float:right; color: lightblue;" id="info"></label>
		<select name="tipo" id="tipo" tabindex="1">
			<option value="part">Particular</option>
			<option value="cv" <?= isset($editar)&&$editar['tipo']=="cv"?"selected":"" ?> >CompraVenta</option>
		</select><br>
		<label>Tipo</label>
		<select name="tipo_traspaso" id="tipo_traspaso" tabindex="1">
			<option value="3" <?= isset($editar)&&$editar['id_tipo']==2?"selected":"" ?>>Traspaso</option>
			<option value="1" <?= isset($editar)&&$editar['id_tipo']==1?"selected":"" ?>>Caucional</option>
			<option value="2" <?= isset($editar)&&$editar['id_tipo']==2?"selected":"" ?>>Notificacion Venta</option>
			<option value="4" <?= isset($editar)&&$editar['id_tipo']==4?"selected":"" ?>>Notificacion Venta + Traspaso</option>
		</select>
	</div>
	<div class="separador">
		<h3>Datos Vehiculo</h3>
		<label for="matricula">Matricula <font color="red">*</font></label>
		<input id="matricula" type="text" name="matricula" tabindex="1" value="<?= isset($editar)?$editar['matricula']:"" ?>" required/>
		<br>
		<label for="base_imponible">Base imponible <font color="red">*</font></label>
		<input id="base_imponible" type="number" tabindex="1" name="base_imponible" value="<?= isset($editar)?$editar['base_imponible']:"" ?>" required />
		<br>
		<label for="tipo_de_gravamen">Tipo de gravamen</label>
		<select id="tipo_de_gravamen" name="tipo_de_gravamen" tabindex="1">
			<option value="4">4%</option>
			<option value="8">8%</option>
		</select>
	</div>
	<div class="separador">
		<h3 id="vcv">Vendedor</h3>
		<a id="nuevo" class="btn btn-default" style="padding: 3px; margin: 5px 0; display: none; " href="?controller=agenda&action=create">Nuevo Compraventa</a>
		<div class="wrap">
			<label for="vendedor">Nombre <font color="red">*</font></label>
			<input class="nombre" list="cv" id="vendedor" tabindex="1" type="text" name="vendedor" required  value="<?= isset($editar)?$editar['vendedor']:"" ?>" />
			<datalist id="cv"></datalist>
		</div>
		<label for="vTlf">Telefono <font color="red">*</font></label>
		<input class="tlf" id="vTlf" type="text" tabindex="1" name="vTlf" pattern="\d{9}|\d{1,4}" required  value="<?= isset($editar)?$editar['vTlf']:"" ?>" />
		<button id="vTND" title="No disponible" type="button" class="noTlf btn btn-warning">ND</button>
		<br>
		<div class="wrap">
			<label for="vMail">Mail <font color="red">*</font></label>
			<input class="mail" list="autoMail" tabindex="1" id="vMail" type="text" name="vMail" required  value="<?= isset($editar)?$editar['vMail']:"" ?>" />
			<button id="vMND" title="No disponible" type="button" class="default btn btn-warning">ND</button>
			<datalist id="autoMail"></datalist>
		</div>
	</div>
	<div class="separador">
		<h3>Comprador</h3>
		<label for="comprador">Nombre <font color="red">*</font></label>
		<input class="nombre" id="comprador" tabindex="1" type="text" name="comprador" required  value="<?= isset($editar)?$editar['comprador']:"" ?>" />
		<br>
		<label for="cTlf">Telefono <font color="red">*</font></label>
		<input class="tlf" id="cTlf" type="text" tabindex="1" name="cTlf" pattern="\d{9}|\d{1,4}" required value="<?= isset($editar)?$editar['cTlf']:"" ?>" />
		<button title="No disponible" type="button" class="noTlf btn btn-warning">ND</button>
		<br>
		<div class="wrap">
			<label for="cMail">Mail <font color="red">*</font></label>
			<input class="mail" list="autoMail2" id="cMail" type="text" tabindex="1" name="cMail" required  value="<?= isset($editar)?$editar['cMail']:"" ?>" />
			<button title="No disponible" type="button" class="default btn btn-warning">ND</button>
			<datalist id="autoMail2"></datalist>
		</div>
	</div>
<?php if(!isset($editar)): ?>
	<div class="separador">
		<h3>Cobro</h3>
		<label style="font-size: 15px" class="pull-right label label-danger"><span id="precio" ></span>€</label>
		<label for="provision">Provision</label>
		<select name="provision" id="provision" tabindex="1">
			<option value="visa">Visa</option>
			<option value="efectivo">Efectivo</option>
			
		</select>
		<br>
		<label for="pago">pagado hoy</font></label>
		<input id="pago" type="checkbox" tabindex="1" name="pago" <?= isset($editar)?"checked":"" ?> />
	</div>
<?php endif; ?>
	<input type="hidden" name="id_compraventa" id="id_compraventa" value="<?= isset($editar)?$editar['id_compraventa']:"" ?>">
	<input type="hidden" name="id_vendedor" id="id_vendedor" value="<?= isset($editar)?$editar['id_vendedor']:"" ?>">
	<input type="hidden" name="id_comprador" id="id_comprador" value="<?= isset($editar)?$editar['id_comprador']:"" ?>">

	<input type="hidden" name="gestion" id="gestion">
	<input type="hidden" name="id" value="<?= isset($editar)?$editar['id']:"" ?>">
	<input class="btn btn-success" type='submit' tabindex="1" name='<?= isset($editar)?"editar":"enviar" ?>' value="<?= isset($editar)?"Modificar":"Crear" ?> Entrada" />
	<h2 style="color:red"><?= isset($error)?$error:"" ?></h2>
</form>
<script>
	/*$(":submit").on("click",function(){
		submit=$(this);
		swal({
			title: 'Estan todos los datos correctos?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(function(){
			console.log("si");
			submit.click();
		},function(){
			console.log("no");
			return false;
		})
		return false;
		
	})*/
	// Maximo 9 digitos por telefono y solo numeros
	$('.tlf, #base_imponible').on('keypress',function(event){
		if(event.keyCode<48 || event.keyCode>57 || $(this).val().length>8){
			return false;
		}

	});

	$('#base_imponible, #tipo_de_gravamen').blur(function(){
		if($.isNumeric($(this).val())){
			gravamen=$('#tipo_de_gravamen').val();
			m620=$(this).val()*gravamen/100;
		}
	})

	gestion=63;
	m620=0;
	tipo=[]
	tipo[1]=58;
	tipo[2]=12.4;
	tipo[3]=58;
	tipo[4]=70.4;

	$('#precio').html(gestion+tipo[3]+m620);

	$(document).on('change',function(){
		setTimeout(function(){
			if($.isNumeric($('#base_imponible').val())){
				gravamen=$('#tipo_de_gravamen').val();
				m620=$('#base_imponible').val()*gravamen/100;
			}
			if($('#tipo').val()=='cv'){
				if($.isNumeric($('#gestion').val())){
					gestion=parseInt($('#gestion').val());
				}else{
					gestion=0;
				}
			}else{
				gestion=63
			}


			i=$('#tipo_traspaso').val();

			$('#precio').html(gestion+tipo[i]+m620);
			console.log(gestion,tipo[i],m620)
		},1000)
		
	});


	//Muestra un swal() en caso de devolver un error
	if("<?= isset($error)?$error:"" ?>"){
		swal('<?= isset($error)?$error:"" ?>');
	}

	// devuelve un swal() en caso de existir el numero, da la opcion de usar el actual o modificarlo
	$('.tlf').on('blur',function(){
		nombre=$(this).closest('div').find(".nombre");
		telefono=$(this);
		mail=$(this).siblings('.wrap').find('.mail');
		

		if($(this).val()!=""){
			$.post('?controller=entrada2&action=no_duplicar&parametros='+ $(this).val(),{

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
			$('#nuevo').css('display','inline-block');
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
								$('#info').html(content[i]['gestion']);
								$('#id_compraventa').val(content[i]['id']);
								$('#comprador').focus();
							}
						}
					});

				});
			});
		}else{
			$('#vTlf, #vMail').off('keypress',keyOff());
			$('#vcv').html('Vendedor');
			$('#nuevo').css('display','none');
			$('#vMND, #vTND').show();
		}
	}

	// Al seleccionar una opcion del primer select
	$(document).ready(function(){
		if($('#tipo').val()=='cv'){
			tlf=$('#vTlf').val();
			mail=$('#vMail').val();
			cv();
			$('#vTlf').val(tlf);
			$('#vMail').val(mail);
		}
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
</script>

<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

