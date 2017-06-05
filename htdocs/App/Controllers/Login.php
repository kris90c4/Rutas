<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Controllers\Home,
\App\Models\User,
\App\Models\PerfilM,
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
		if(strcmp($user['pass'],md5($pass))==0){
			//Se almacena en Sesion la clase Perfil
			$_SESSION['usuario']= new PerfilM($user);
			UserAdmin::update("SET fechaEntrada = CURRENT_TIMESTAMP WHERE id = " . $_SESSION['usuario']->getId());
			view::render('home');
		}else{
			view::set("title", "check");
			view::set("mail", $mail);
			view::set("ePass","true");
			view::render('login');
		}
	}
}