<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\User,
\App\Models\Admin\User as UserAdmin;

class Login{
	public function view(){
		
		View::set("title", "Login");
		View::render("login");
	}
}