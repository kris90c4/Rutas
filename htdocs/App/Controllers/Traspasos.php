<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Traspasos as TraspasosAdmin;


class Matri{
	//muestra el contenido de la tabla traspasos
	function view(){
		View::set("traspasos", TraspasosAdmin::getAll());
		View::render("factu/tablaTraspasos");
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
	//Devuelve un objeto JSON con todos los tipos
	function tipos(){
		$provincias=ajax::select("tipos");
		echo $provincias;
	}
	
	
}