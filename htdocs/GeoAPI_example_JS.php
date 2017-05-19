<html>
	<head>
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
				    for(var i=0;i<respuesta.data.length;i++){
				    	console.log(respuesta.data[i].COM);
				    }
					
				});

			});

		</script>
		<style>
			pre {
				background-color: ghostwhite;
				border: 1px solid silver;
				padding: 10px 20px;
				margin: 20px; 
			}
		</style>
	</head>
	<body ng-app="app">
		<pre>
			<div ng-controller="MainCtrl">
			{{ comunidades | json }}
			</div>
		</pre>
	</body>
</html>