<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin;
 
class Error{
	public function error404(){
		View::render("errors/404");
	}
}