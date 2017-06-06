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
		if(isset($_POST['mail'])){
			extract($_POST);
			$user = User::getByMail($mail);
			//Validacion de contraseña
			if(strcmp($user['pass'],md5($pass))==0){
				//Se almacena en Sesion la clase Perfil
				$_SESSION['usuario']= new PerfilM($user);
				//Se actualiza el campo fechaEntrada de la base de datos con la hora del acceso
				UserAdmin::update("SET fechaEntrada = CURRENT_TIMESTAMP WHERE id = " . $_SESSION['usuario']->getId());
				view::set("saludo","Bienvenido ". $_SESSION['usuario']->getNombre());
				view::set("title","Home");
				view::render('home');
			}else{
				// si la contraseña es incorrecta
				view::set("title", "check");
				view::set("mail", $mail);
				view::set("ePass","true");
				view::render('login');
			}
		}else{
			die("Acceso Denegado");
		}
	}
}