<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';
 
use \Core\View,
	\App\Models\Compraventa as CompraventaM;


class Compraventa extends ControllerBase{
	public function view(){
		View::set("title","Compraventas");
		View::set("clientes",CompraventaM::getAll());
		View::render('compraventas');
	}
	public function create($id=0) {
		View::set('title',"Nuevo Compraventa");
		$this->log($id);
		if($id>0){
			view::set('compraventa',CompraventaM::getById($id));
			$this->log($id);
		}
		View::render("nuevoCompraventa",false);
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	public function save() {
		if(isset($_POST['nuevo'])){
			if($ok=CompraventaM::insert($_POST)){//Si es correcto se reenvia a la tabla
				$this->view();
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error
				View::set("error","Ha ocurrido un error.");
				View::set('title',"Nuevo Compraventa");
				View::render("nuevoCompraventa");
			}
		}else{
			if($ok=CompraventaM::update($_POST)){//Si es correcto se reenvia a la tabla
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
		if($resultado=CompraventaM::delete($id)){
			echo "eliminado";
		}else{
			echo $resultado;
		}
	}
	public function find(){
		extract($_POST);
		$resultados=json_encode(CompraventaM::getByName($cv));
		echo $resultados;
	}
}
?>