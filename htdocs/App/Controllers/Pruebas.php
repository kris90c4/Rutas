<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
	\App\Models\Ajax;


class pruebas{
	function view() {
		$_SERVER['HTTP_X_REAL_IP']="77.229.168.94";
		$geoapi = new \GeoAPI();
		$geoapi->setConfig("key", "c952f2da3b954d4eb3380c9cd9de11b5ef01f85f1060d80172a81862c84ca91f");
		$geoapi->setConfig("type", "JSON");
		$geoapi->setConfig("sandbox", 0);
		$com=$geoapi->comunidades(array());
		
		View::set("var", $com);
		View::render("info");
	}

}