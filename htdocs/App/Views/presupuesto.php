<style>
	#presupuesto{
		width: 400px;
		position: absolute;
	}
	#presupuesto div#img{
		background: url('../images/logo-gestoria-portol2.png') no-repeat !important;
		background-size: 100% !important;
		opacity: 0.1 !important;
		position:absolute;
		left:0;
		top:20%;
		right:0;
		bottom:20%;
		z-index: -1;
	}

	#presupuesto label+* {
		position: absolute;
		right: 0;
	}
	#presupuesto hr{
		border-top:1px solid black;
	}
	#presupuesto #nuevo{
		visibility: hidden;
	}
</style>
<div style="width: 400px;
	position: absolute;" id="presupuesto">
	<div id="img"></div>
	<!--<div>
		<h4>Datos del interesado</h4>
		<label for="">Nombre:</label><input type="text"><br>
		<label for="">Telefono:</label><input type="text"><br>
		<label for="">Mail:</label><input type="text"><br>
	</div>-->
	<button style="position:absolute;top:0px;left:150px;" title="Se rescata el ultimo presupuesto. Sea desde esta pagina o desde Nueva entrada" class="btn btn-info" id="nuevo">Nuevo</button>
	<button style="position:absolute;top:0px;right:20px;" title="Se rescata el ultimo presupuesto. Sea desde esta pagina o desde Nueva entrada" class="btn btn-info" id="last">Ultima busqueda</button>
	<div>
		<h4>Datos vehículo</h4>
		<label for="">Matricula:</label><input id="matricula" type="text"><button id="coche" class="btn btn-mini btn-default"><img style="margin-top: -6px;" height="" src="https://icon-icons.com/icons2/235/PNG/32/Car_Left_Red_26351.png"/></button><button  id="moto" class="btn btn-mini btn-default"><img style="margin-top: -6px;" height="" src="https://icon-icons.com/icons2/517/PNG/32/1452632162_inspiration-34_icon-icons.com_51105.png"/></button><span id="crono" ></span><br>
		<label for="marca">Marca: </label><span id="marca"></span><br>
		<label for="modelo">Modelo: </label><span id="modelo"></span><br>
		<label for="cilindrada">Cilindrada: </label><span id="cilindrada"></span><br>
		<label for="bastidor">Bastidor: </label><span id="bastidor"></span><br>
		<label for="fechaMatri">Fecha matriculacion: </label><span id="fechaMatri"></span><br>
		<label for="cvf">CVf: </label><span id="cvf"></span>
	</div>
	<hr>
	<div>
		<h4>Valoración</h4>
		<label for="base_imponible">Base imponible: </label> <span id="base_imponible"></span><br>
		<label for="tipo">Tipo de gravamen: </label> <span id="tipo"></span>
	</div>
	<hr>
	<div>
		<h4>Presupuesto</h4>
		<label for="cuota">Cuota(Modelo 620): </label> <span id="cuota"></span><br>
		<label for="trafico">Tasa Tráfico: </label> <span id="trafico"></span><br>
		<label for="gestion">Gestión: <font size="2" style="color:grey !important">(IVA incluido)</font></label><span id="gestion"></span><br>
		<label for="otros">Impresos y fotocópias: </label> <span id="otros"></span><hr>
		<label for="total">Precio del Traspaso: </label> <span id="total" style="color:red"></span>
	</div>
	<button id="correo">test</button>
</div>