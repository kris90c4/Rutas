<?php
namespace App\Controllers;

use Core\View;

class matri{
	function view() {
		View::set('title',"matriculaciones");
		View::render("factu/matri");
	}
	function consultaAjax($tabla) {
		$provincias= new ItemsModel();
		$provincias=$provincias->provincias();
	}
}