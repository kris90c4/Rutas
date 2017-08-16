<!-- http://ProgramarEnPHP.wordpress.com -->

<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<form id="plantilla" method="post" action="?controller=entrada&action=save">
	<label>Solicitante</label><label style="float:right; color: lightblue;" id="info"></label>
	<select name="tipo" id="tipo">
		<option value="part">Particular</option>
		<option value="cv">CompraVenta</option>
	</select>

	<br><br>
	<h3>Datos Traspaso</h3><br>
	<label>Tipo</label>
	<select name="tipo_traspaso" id="tipo_traspaso">
		<option value="3">Traspaso</option>
		<option value="1">Caucional</option>
		<option value="2">Notificacion Venta</option>
		<option value="4">Notificacion Venta + Traspaso</option>
	</select>
	<br><br>
	<h3>Datos Vehiculo</h3><br>
	<label for="matricula">Matricula <font color="red">*</font></label>
	<input id="matricula" type="text" name="matricula" value="<?= isset($editar)?$editar['matricula']:"" ?>" />
	<br>
	<label for="base_imponible">Base imponible <font color="red">*</font></label>
	<input id="base_imponible" type="text" name="base_imponible" value="<?= isset($editar)?$editar['base_imponible']:"" ?>" />
	<br>
	<label for="tipo_de_gravamen">Tipo de gravamen</label>
	<select id="tipo_de_gravamen" name="tipo_de_gravamen">
		<option value="4">4%</option>
		<option value="8">8%</option>
	</select>
	<br><br>
	<h3>Vendedor/Compraventa</h3><br>
	<a id="nuevo" class="btn btn-default" style="padding: 3px; margin: 5px 0; display: none; " href="?controller=agenda&action=create">Nuevo Compraventa</a>
	<div class="wrap">
		<label for="vendedor">Nombre <font color="red">*</font></label>
		<input list="cv" id="vendedor" type="text" name="vendedor" required  value="<?= isset($editar)?$editar['vendedor']:"" ?>" />
		<datalist id="cv"></datalist>
	</div>
	<div class="wrap">
		<label for="vMail">Mail <font color="red">*</font></label>
		<input list="autoMail" id="vMail" type="text" name="vMail" required  value="<?= isset($editar)?$editar['vmail']:"" ?>" />
		<datalist id="autoMail"></datalist>
	</div>
	<label for="vTlf">Telefono <font color="red">*</font></label>
	<input id="vTlf" type="number" name="vTlf" required  value="<?= isset($editar)?$editar['vTlf']:"" ?>" />
	<br><br>
	<h3>Comprador</h3><br>
	<label for="comprador">Nombre <font color="red">*</font></label>
	<input id="comprador" type="text" name="comprador" required  value="<?= isset($editar)?$editar['comprador']:"" ?>" />
	<br>
	<div class="wrap">
		<label for="cMail">Mail <font color="red">*</font></label>
		<input list="autoMail2" id="cMail" type="text" name="cMail" required  value="<?= isset($editar)?$editar['cMail']:"" ?>" />
		<datalist id="autoMail2"></datalist>
	</div>
	<label for="cTlf">Telefono <font color="red">*</font></label>
	<input id="cTlf" type="number" name="cTlf" required value="<?= isset($editar)?$editar['cTlf']:"" ?>" />
	<br><br>
	<h3>Cobro</h3>
	<br>
	<label for="provision">Provision</label>
	<select name="provision" id="provision">
		<option value="visa">Visa</option>
		<option value="efectivo">Efectivo</option>
		
	</select>
	<br>
	<label for="pago">pagado hoy</font></label>
	<input id="pago" type="checkbox" name="pago" value="<?= isset($editar)?$editar['pago']:"" ?>" />
	<br><br>
	<input type="hidden" name="gestion" id="gestion">
	<input class="btn btn-success" type='submit' name='<?= isset($editar)?"editar":"enviar" ?>'  value="<?= isset($editar)?"Modificar":"Crear" ?> Entrada" />
</form>

<script>
	// Al seleccionar una opcion del primer select
	$('#tipo').on('change',function(){
		// Se comprueba si se ha usado la opcion de compraventa,
		if($('#tipo').val()=="cv"){
			$('#nuevo').css('display','inline-block');
			// Se crea un evento para mostrar los compraventas disponibles
			$('#vendedor').on('keyup',function(){
				//se realiza un post via ajax para consultar los resultados encontrados con las letras introducidas
				$.post("?controller=agenda&action=find",{
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
							}
						}
					});

				});
			});
		}else{
			$('#nuevo').css('display','none');
		}
	})
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

</script>

<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

