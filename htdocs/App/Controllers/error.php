<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
 
use \Core\View;
 
class Error{
	public function error404(){
		View::render("errors/404");
	}
}