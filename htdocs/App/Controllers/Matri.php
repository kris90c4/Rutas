<?php
namespace App\Controllers;

use Core\View,
App\Models\Ajax;

class matri{
	function view() {
		View::set('title',"matriculaciones");
		View::render("factu/matri");
	}
	function create() {
		
	}
	function save() {
		
	}
	//Devuelve un objeto JSON con todas las provicias
	function provincias(){
		$provincias=ajax::select("provincias");
		echo $provincias;
	}
	//Devuelve un objeto JSON con todos los municipios de la provincia seleccionada
	function municipios(){
		$municipios=ajax::select("municipios where id_provincia = '". $_POST['id_provincia']."'");
		echo $municipios;
	}
}