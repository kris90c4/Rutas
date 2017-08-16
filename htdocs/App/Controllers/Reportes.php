<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Reportes as ReportesM;


class Reportes{
	public function view(){
		View::set("title","Reportes");
		View::set("reportes",ReportesM::getAll());
		View::render('reportes');
	}
	public function create() {
		View::set('title',"Reportar");
		View::render("reportar");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	public function save() {
		if($ok=ReportesM::insert($_POST)){//Si es correcto se reenvia a la tabla
			$this->create();
		}else{//si hay algun fallo se devuelve al formualrio y se muestra que ha habido un error
			View::set("error","Ha ocurrido un error.");
			View::set('title',"Reportes");
			View::render("reporte");
		}
	}

	public function error404(){
		View::render("errors/404");
	}
}