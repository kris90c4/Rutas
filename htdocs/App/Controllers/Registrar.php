<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("INVITADO") OR die("Acceso denegado");

use \Core\View,
\App\Models\User,
\App\Models\PerfilM,
\App\Models\Admin\User as UserAdmin;

class Registrar{
	public function view(){
		View::set("title", "Registro");
		View::render("registrar");
	}
	
	//Recoge los datos del formulario de registro. 
	//Los valida y en caso necesario, usa el modelo admin/user para insertar un registro en la base de datos
	public function check(){
		////// Desabilitado registro ///////

		
		view::set("error","El sistema de registro esta desabilitado. Contacta con el administrador para cualquier duda");
		View::render("Home");
		exit();
		

		//Comprueba que se llege a este controlador solo al usar el formulario de registro
		if(isset($_POST['registrar'])){
			//Covierte los indices de $_POST en variables
			extract($_POST);
			$usuarios=UserAdmin::getByMail($mail);
			//Solo se contempla error de mail, falta feedback
			if($usuarios){
				view::set("mail",$mail);
				view::set("nombre",$nombre);
				view::set("apellidos",$apellidos);
				view::set("eMail",true);
				View::render("registrar");
			}else{
				$this->save();
			}
		}else{
			View::render("errors/404");
		}
	}
	// Una vez comprobado que se puede realizar el registro, se procede a insertar el registro en la base de datos
	private function save(){
		//Se codifica la contraseña a md5
		$_POST['pass']=md5($_POST['pass']);
		//Se comprueba que se inserte en la base de datos
		if(UserAdmin::insert($_POST)){
			//Se recupera el usuario registrado y se almacena una session.
			$user = User::getByMail($_POST['mail']);
			$_SESSION['usuario']= new PerfilM($user);
			view::set("saludo","Bienvenido ". $_SESSION['usuario']->getNombre());
			View::set("title","Home");
			View::render('home');
		}else{
			View::render("errors/404");
		}
	}
	// Se usa en el registro para validar via ajax que el correo no exista antes de enviar el formulario entero
	public function checkMail(){
		extract($_POST);
		$usuario=UserAdmin::getByMail($mail);
		if($usuario==true){
			echo "El correo ya existe";
		}
	}
}