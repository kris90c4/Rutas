<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Matri as MatriAdmin;


class Matri{
	function view() {
		View::set('title',"matriculaciones");
		View::render("factu/matri");
	}
	function create() {
		if(MatriAdmin::insert($_POST)){
			View::render("factu/matri");
		}
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