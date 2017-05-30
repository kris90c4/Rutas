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
			
			resultado="<option>Seleccionar uno</option>";
			myObj = JSON.parse(xmlhttp.responseText);
			
			for(i=0;i<myObj.length;i++){

				resultado+="<option value='"+myObj[i].id+"'>"+myObj[i].nombre+"</option>";

			}

			//Devolvemos todos los datos almacenados al idElement introducido.
	    document.getElementById(idElement).innerHTML = resultado;
			
	    }
	});
}
window.onload=function(){
	
}
