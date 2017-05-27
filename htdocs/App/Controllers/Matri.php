<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Matri as MatriAdmin;


class Matri{
	//muestra el contenido de la tabla matriculaciones
	function view(){
		View::set("matriculaciones", MatriAdmin::getAll());
		View::render("factu/tablaMatri");
	}
	//Muestra el formulario de nuevo registro de matriculaciones
	function create() {
		View::set('title',"matriculaciones");
		View::render("factu/matri");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	function save() {
		if(MatriAdmin::insert($_POST)){
			$this->view();
		}else{
			View::render("errors/404");
		}
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