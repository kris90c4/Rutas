<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\User,
\App\Models\Admin\User as UserAdmin;

class Registrar{
	public function view(){
		View::set("title", "Registro");
		View::render("registrar");
	}
	
	//Recoge los datos del formulario de registro. 
	//Los valida y en caso necesario, usa el modelo admin/user para insertar un registro en la base de datos
	public function check(){
		//Comprueba que se llege a este controlador solo al usar el formulario de registro
		if(isset($_POST['registrar'])){
			//Covierte los indices de $_POST en variables
			extract($_POST);
			$usuarios=UserAdmin::getByMail($mail);
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
	public function save(){
		//Se codifica la contraseña a md5
		$_POST['pass']=md5($_POST['pass']);
		//Se comprueba que se inserte en la base de datos
		if(UserAdmin::insert($_POST)){
			$index=new Home();
			//Se recupera el usuario registrado y se almacena una session.
			$user = User::getByMail($_POST['mail']);
			$_SESSION['usuario']=$user;
			$index->view();
		}else{
			View::render("errors/404");
		}
	}
}