<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
//Solo se permite el acceso si se ha inicializado la constante INVITADO
defined("INVITADO") OR die("Acceso denegado");

use \Core\View,
\App\Controllers\Home,
\App\Models\User,
\App\Models\PerfilM,
\App\Controllers\Matri,
\App\Models\Admin\User as UserAdmin;

class Login{
	//Se muestra el formulario para logear
	public function view(){
		View::set("title", "Login");
		View::render("login");
	}

	//al clicar a logear, se validan los datos
	public function validate(){
		// Solo se valida si se envia un post con mail
		if(isset($_POST['mail'])){
			extract($_POST);
			$user = User::getByMail($mail);
			//Validacion de contraseña
			if(strcmp($user['pass'],md5($pass))==0){
				//Se almacena en Sesion la clase Perfil
				$_SESSION['usuario']= new PerfilM($user);
				//Se actualiza el campo fechaEntrada de la base de datos con la hora del acceso
				UserAdmin::update("SET fechaEntrada = CURRENT_TIMESTAMP WHERE id = " . $_SESSION['usuario']->getId());
				// Si logea un administrador se rediridige a la pagina de gestion
				if($_SESSION['usuario']->getAdmin()){
					
					if($_SESSION['usuario']->getNombre()=="Myrna"){
						header("location: ?controller=estadisticas&action=view");
					}else{
						header("location: ?controller=perfil&action=gestion");
					}
				}else{//Si es un usuario normal, se muestra la vista con las matriculaciones
					header("location: ?controller=entrada&action=view");
				}
			}else{
				// si la contraseña es incorrecta
				view::set("title", "check");
				view::set("mail", $mail);
				view::set("ePass","true");
				view::render('login');
			}

		}else{// Si no llega un post con mail se deniega el acceso
			die("Acceso Denegado");
		}
	}
}