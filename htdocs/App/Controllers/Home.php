<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");
 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin;
 
class Home{
	public function __construct(){
		View::set("name", $nombre);
		View::set("title", "Home");
		View::render("home");
	}
	public function saludo(){
		$nombre=func_get_args();
		View::set("name", $nombre);
		View::set("title", "Saludo");
		View::render("home");
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
}