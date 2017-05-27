<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;


class pruebas{
	function view() {
		View::set("var","fo");
		View::render("info");
	}

}