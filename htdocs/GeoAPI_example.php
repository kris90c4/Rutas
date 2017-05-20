<?php

require __DIR__ . '/vendor/autoload.php';

$geoapi = new GeoAPI();

$geoapi->setConfig("key", "8f338554e8b753ce72f9f23be3f7d04a28ed0785d522158a66576495e72c6855");
$geoapi->setConfig("type", "JSON");
$geoapi->setConfig("sandbox", 0);
var_dump($_SERVER);
$geoapi->comunidades(array(
	//Sin argumentos
))->then(function($v){
	echo print_r($v, true);
});

//Esperar 1 segundo para evitar el limite de la API en sandbox
sleep(1);

$geoapi->provincias(array(
	'CCOM' => '08' //Provincias de "Castilla y León"
))->then(function($v){
	echo print_r($v, true);
});

?>