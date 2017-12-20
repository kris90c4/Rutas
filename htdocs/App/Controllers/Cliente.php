<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';
 
use \Core\View,
	\App\Models\Cliente as ClienteM;


class Cliente{
	//Carga la pagina principal de la aplicacion
	public function view(){
		View::set("title", "Clientes");
		View::set("clientes",ClienteM::getAll());
		View::render("clientes");
	}

	
	public function create($id=0){
		View::set('title',"Nuevo Cliente");
		if($id>0){
			view::set('cliente',ClienteM::getById($id));
		}
		View::render("nuevoCliente");
	}

	public function save() {
		if(isset($_POST['nuevo'])){
			if($id=ClienteM::insert($_POST)){//Si es correcto se reenvia a la tabla
				return $id;
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error
				View::set("error","Ha ocurrido un error.");
				View::set('title',"Nuevo Cliente");
				View::render("nuevoCliente");
			}
		}else{
			if($ok=ClienteM::update($_POST)){//Si es correcto se reenvia a la tabla
				$this->view();
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error

			}
		}
	}
	//funcion para ajax
	public function actualizar(){
		extract($_POST);
		$datos['telefono']=$telefono;
		$datos['mail']=$mail;
		$datos['nombre']=$nombre;
		if(ClienteM::update2($datos)){
			echo true;
		}else{
			echo false;
		}
	}

	/*public function usersAdmin(){
		$users = UserAdmin::getAll();
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}*/	
	//Lanza a la pagina de error404 al no encontrar el destino
	public function error404(){
		View::render("errors/404");
	}
	public function excel(){
		View::set('title','Importar desde excel');
		View::render('excel');
	}
}