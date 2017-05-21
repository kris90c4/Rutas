<script>

//SIN HACER; HAY QUE MODIFICAR TODO
var rutaRaiz="?controller="

//Se vuelcan todos los paises en el select con id S1
loadDataDoc(rutaRaiz+'/DWEC_P13_04.php',"",'s1');

select=document.getElementsByTagName('select');
//se captura el select de los paises
paises=select[0];
regiones=select[1];
//Se ejecuta la funcion que carga los datos de las regiones al seleccionar un nuevo pais.
paises.onchange=function(){
	loadDataDoc(rutaRaiz+'/DWEC_P13_03_2.php',"l="+paises.value,'s2');
}

//Se encarga de generar el objeto XMLHttpRequest
function newXMLHTTP(){
	var myxmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		myxmlhttp = new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		myxmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return myxmlhttp;
}

//Se encarga de enviar la peticion al servidor
function sendRequest(objxmlhttp, url,post, func) {
	objxmlhttp.onreadystatechange = func;
	objxmlhttp.open("POST",url,true);
	objxmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	objxmlhttp.send(post);
}
//Se encarga de recueperar los datos deseados del archivo seleccionado del servidor y enviarlos a la etiqueta que deseamos que contengas estos datos.
function loadDataDoc(url,post,idElement){
	var xmlhttp = newXMLHTTP();


	sendRequest(xmlhttp,url,post,function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			
			console.log(xmlhttp);
			resultado="";

			myObj = JSON.parse(xmlhttp.responseText);

			for(i=0;i<myObj.length;i++){
				resultado+="<option value='"+myObj[i].id+"'>"+myObj[i].nombre+"</option>";
			}

			//Devolvemos todos los datos almacenados al idElement introducido.
	    document.getElementById(idElement).innerHTML = resultado;
			
	    }
	});
}
</script>
<div>
	<form action="?controller=matri&action=save" method="POST">
		<label class="left">Entrada</label>
		<input type="date" name="entrada"/>
		<label>Entrada</label>
		<input type="text" name="bastidor" placeholder="bastidor"/>
		<input type="text" name="matricula" placeholder="matricula"/>
		<input type="text" name="cliente" placeholder="cliente"/>
		<input type="number" name="alta" placeholder="precio alta"/>
		<select id="provincia"name="provincia"></select>
		<select id="municipio"name="municipio"></select>
		<input type="date" name="salida"/>
	</form>
</div>
<?php
