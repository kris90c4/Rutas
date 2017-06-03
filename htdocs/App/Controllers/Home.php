<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");
 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin;
 
class Home{
	public function view(){
		View::set("title","Home");
		View::render('home');
	}

	//Pruebas para cargar dos vistas seguidas
	public function multiViews(){

		//Se envia un array con las vistas que se desean cargar
		View::set("vista", ["factu/matriculaciones","factu/traspasos"]);
		View::set("title", "Saludo");
		View::render("multiViews");
		
	}

	public function users(){
		$users = User::getAll();
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}

	public function usersAdmin(){
		$users = UserAdmin::getAll();
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}	
	public function error404(){
		View::render("errors/404");
	}	
}