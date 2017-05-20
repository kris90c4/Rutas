
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.17/angular.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/GeoAPI-es/geoapi.es-js/1.0.2/GeoAPI.js"></script>
<script>

	var app = angular.module('app', ['GeoAPI']);

	app.controller('MainCtrl', function($scope, $timeout, GeoAPI){

		// Configurar GeoAPI
		GeoAPI.setConfig("key", "c952f2da3b954d4eb3380c9cd9de11b5ef01f85f1060d80172a81862c84ca91f");
		GeoAPI.setConfig("type", "JSON");
		GeoAPI.setConfig("sandbox", 0);

		// Cargar las comunidades

		GeoAPI.comunidades({
			//
		}).then(function(respuesta) {
			s1=document.getElementById('s1');
			s1.innerHTML="<option>Comunidad Autonoma</option>";
		    for(var i=0;i<respuesta.data.length;i++){
			    option=document.createElement("option");
		    	t1=document.createTextNode(respuesta.data[i].COM);
		    	option.setAttribute("value",respuesta.data[i].CCOM)
		    	option.appendChild(t1);
		    	s1.appendChild(option);
		    }
			
		});
		// Cargar las Provincias
		s1.onchange=function(){
			vs1=s1.value;
			GeoAPI.provincias({"CCOM":vs1}).then(function(respuesta) {
				s2=document.getElementById('s2');
				s2.innerHTML="<option>Provincia</option>";
			    for(var i=0;i<respuesta.data.length;i++){
				    option=document.createElement("option");
			    	t1=document.createTextNode(respuesta.data[i].PRO);
			    	option.setAttribute("value",respuesta.data[i].CPRO)
			    	option.appendChild(t1);
			    	s2.appendChild(option);
			    }
				
			});
		}
		// Cargar los Municipios
		s2.onchange=function(){
			vs2=s2.value;
			GeoAPI.municipios({"CPRO":vs2}).then(function(respuesta) {
				s3=document.getElementById('s3');
				s3.innerHTML="<option>Municipio</option>";
			    for(var i=0;i<respuesta.data.length;i++){
				    option=document.createElement("option");
			    	t1=document.createTextNode(respuesta.data[i].DMUN50);
			    	option.setAttribute("value",respuesta.data[i].CMUM)
			    	option.appendChild(t1);
			    	s3.appendChild(option);
			    }
				
			});
		}
		// Cargar las Poblaciones
		s3.onchange=function(){
			vs3=s3.value;
			GeoAPI.poblaciones({"CPRO":vs2,"CMUM":vs3}).then(function(respuesta) {
				s4=document.getElementById('s4');
				s4.innerHTML="<option>Poblacion</option>";
			    for(var i=0;i<respuesta.data.length;i++){
				    option=document.createElement("option");
			    	t1=document.createTextNode(respuesta.data[i].NENTSI50);
			    	option.setAttribute("value",respuesta.data[i].CUN)
			    	option.appendChild(t1);
			    	s4.appendChild(option);
			    }
			});
		}
		// Cargar los CP
		s4.onchange=function(){
			console.log("CP");
			vs4=s4.value;
			console.log(vs2+"-"+vs3+"-"+vs4);
			GeoAPI.cps({"CPRO":vs2,"CMUM":vs3,"CUN":vs4}).then(function(respuesta) {
				 console.log(respuesta.data);
				s5=document.getElementById('s5');
				s5.innerHTML="<option>CODIGO POSTAL</option>";
			    for(var i=0;i<respuesta.data.length;i++){
				    console.log(respuesta.data[i]);
				    option=document.createElement("option");
				    t1=document.createTextNode(respuesta.data[i].CPOS);
			    	option.setAttribute("value",respuesta.data[i].CVIA)
			    	option.appendChild(t1);
			    	s5.appendChild(option);
			    }
			});
		}
		calles=document.getElementsByTagName('input')[0];
		
	});

</script>
<div ng-app="app">
	<div ng-controller="MainCtrl">
	<select id="s1"></select>
	<select id="s2"></select>
	<select id="s3"></select>
	<select id="s4"></select>
	<select id="s5"></select><br>
	<input type="text"/>
	</div> 
</div>