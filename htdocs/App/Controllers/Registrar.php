<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;

class Registrar{
	public function view(){
		View::set("title", "Registro");
		View::render("registrar");
	}
}