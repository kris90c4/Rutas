<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';

use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Traspasos as TraspasosAdmin;

class Traspasos{
	//muestra el contenido de la tabla traspasos
	function view(){
		View::set("traspasos", TraspasosAdmin::getAll());
		View::set("vista","traspasos");
		view::set("title","Traspasos");
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
	//Permite atraves de una llamada ajax de JQuery, modificar la fecha de salida
	function updateSalida(){
		extract($_POST);
		$date=empty($date)?"null":"\"$date\"";
		$ok=TraspasosAdmin::update("SET salida=$date WHERE id=$id");
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