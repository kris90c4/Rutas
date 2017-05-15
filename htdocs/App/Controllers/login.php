<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\User,
\App\Models\Admin\User as UserAdmin;

class Login{
	public function pintar_login(){
		
		View::set("title", "Login");
		View::render("login");
	}
}