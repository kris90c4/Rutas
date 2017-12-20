<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';


use \Core\View,
\App\Models\Ajax,
\App\Models\Admin\Matri as MatriAdmin;


class Matri{
	//muestra el contenido de la tabla matriculaciones
	function view(){
		View::set("matriculaciones", MatriAdmin::getAll());
		View::set("vista","matriculaciones");
		View::set("title","Matriculaciones");
		View::render("factu/tablafactu");
	}
	//Muestra el formulario de nuevo registro de matriculaciones
	function create() {
		View::set('title',"matriculaciones");
		View::render("factu/matriculaciones");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	function save() {
		if($ok=MatriAdmin::insert($_POST)){//Si es correcto se reenvia a la tabla
			$this->view();
		}else{//si hay algun fallo se devuelve al formualrio y se muestra que ha habido un error
			View::set("error","Ha ocurrido un error.");
			View::set('title',"matriculaciones");
			View::render("factu/matriculaciones");
		}
	}
	// Actualiza la fecha de salida
	function updateSalida(){
		extract($_POST);
		$date=empty($date)?"null":"\"$date\"";
		$ok=MatriAdmin::update("SET salida=$date WHERE id=$id");
		//Si falla la actualizacion, se lanza el error de sql y se muestra tambien la sentencia sql enviada
		if(!$ok){
			echo "UPDATE matriculaciones SET salida=$date WHERE id=$id";
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