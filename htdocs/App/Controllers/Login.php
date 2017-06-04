<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Controllers\Home,
\App\Models\User,
\App\Models\Admin\User as UserAdmin;

class Login{
	//Se muestra el formulario para logear
	public function view(){
		
		View::set("title", "Login");
		View::render("login");
	}

	//al clicar a logear, se validan los datos
	public function validate(){
		extract($_POST);
		$user = User::getByMail($mail);
		//Validacion de contraseña
		if(strcmp($user['contraseña'],md5($pass))==0){
			$_SESSION['usuario']=$user;
			$home=new home();
			$home->view();
			exit();
		}else{
			view::set("title", "check");
			view::set("mail", $mail);
			view::set("ePass","false");
			view::render('login');
			exit();
		}
		$users[0]=$user;
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}
}