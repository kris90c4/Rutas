<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Traspasos as TraspasosAdmin;

class Traspasos{
	//muestra el contenido de la tabla traspasos
	function view(){
		View::set("traspasos", TraspasosAdmin::getAll());
		View::set("vista","traspasos");
		View::render("factu/tablaFactu");
	}
	//Muestra el formulario de nuevo registro de traspasos
	function create() {
		View::set('title',"traspasos");
		View::render("factu/traspasos");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	function save() {
		if(TraspasosAdmin::insert($_POST)){
			$this->view();
		}else{
			View::render("errors/404");
		}
	}
	function updateSalida(){
		extract($_POST);
		$date=empty($date)?"null":"\"$date\"";
		$ok=TraspasosAdmin::update("UPDATE traspasos SET salida=$date WHERE id=$id");
		if(!$ok){
			var_export("UPDATE traspasos SET salida=$date WHERE id=$id");
		}
	}
	//Devuelve un objeto JSON con todos los tipos
	function tipos(){
		$provincias=ajax::select("tipos");
		echo $provincias;
	}
}