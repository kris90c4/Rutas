<?php

require __DIR__ . '/vendor/autoload.php';

$geoapi = new GeoAPI();

$geoapi->setConfig("key", "c952f2da3b954d4eb3380c9cd9de11b5ef01f85f1060d80172a81862c84ca91f");
$geoapi->setConfig("type", "JSON");
$geoapi->setConfig("sandbox", 0);

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