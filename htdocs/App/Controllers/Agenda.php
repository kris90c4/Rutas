<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Agenda as AgendaM;


class Agenda{
	public function view(){
		View::set("title","Agenda");
		View::set("clientes",AgendaM::getAll());
		View::render('agenda');
	}
	public function create($id=0) {
		View::set('title',"Nuevo Cliente");
		if($id>0){
			view::set('compraventa',AgendaM::getById($id));
		}
		View::render("nuevoCliente");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	public function save() {
		if(isset($_POST['nuevo'])){
			if($ok=AgendaM::insert($_POST)){//Si es correcto se reenvia a la tabla
				$this->view();
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error
				View::set("error","Ha ocurrido un error.");
				View::set('title',"Nuevo Cliente");
				View::render("nuevoCliente");
			}
		}else{
			if($ok=AgendaM::update($_POST)){//Si es correcto se reenvia a la tabla
				$this->view();
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error

			}
		}
	}

	public function error404(){
		View::render("errors/404");
	}
	
	public function del(){
		extract($_POST);
		if($resultado=AgendaM::delete($id)){
			echo "eliminado";
		}else{
			echo $resultado;
		}
	}
	public function find(){
		extract($_POST);
		$resultados=json_encode(AgendaM::getByName($cv));
		echo $resultados;
	}
}
?>