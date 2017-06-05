<?php
namespace App\Controllers;

defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\User as Users,

\App\Models\Admin\User as UserAdmin,
\App\Models\PerfilM;

class Perfil{

	public function logout(){
		session_destroy();
		unset($_SESSION);
		View::render('home');
	}
	public function view(){
		//Si no hay una session usuario iniciada se reenvia al login
		if(!isset($_SESSION['usuario'])){
			View::render('login');
		}else{
			define('USUARIO',$_SESSION['usuario']->getNombre());
			View::render('perfil');
		}
	}
	// Usado para una llamada Post de ajax
	public function modificarPass(){
		extract($_POST);
		//en caso de enviar algun campo vacio
		if(empty($oldPass)||empty($newPass)){
			exit("faltan campos por rellenar");
		}
		//Se codifica la contraseña y se verifica que coincida con la actual
		$oldPass=md5($oldPass);
		echo $oldPass==$_SESSION['usuario']->getPass()?"":exit("Contraseña antigua incorrecta");
		//Validacion
		if(!preg_match("/(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/",$newPass)){
			exit("Requisitos Minimos:<br>1 Mayuscula<br>1 Minuscual<br>1 Digitio<br>6 Caracteres o mas");
		}
		if($newPass!=$cNewPass){
			exit("Contraseña de confirmación no valida");
		}

		$newPass=md5($newPass);

		if(UserAdmin::update("SET pass = '$newPass' WHERE id= $id AND pass = '$oldPass'")==true){
			echo "Contraseña modificada con exito";
			$_SESSION['usuario']->setPass($newPass);
		}
	}
	//Genera la vista de gestion de usuarios
	public function gestion(){
		if($_SESSION['usuario']->getAdmin()){
			define("ADMIN",1);
			$queryUsers=UserAdmin::getAll();
			$usuarios=array();
			//Se almacena cada usuario en la clase Perfil y todos en un array
			foreach ($queryUsers as $key => $value) {
				$usuarios[$key]=new PerfilM($value);
			}
			//se envian todos los usuarios con su corresponiente clase perfil
			View::set("usuarios",$usuarios);
			View::render("gestionUsuarios");
		}
		die("Acceso Denegado");
	}
	public function resetPass(){
		extract($_POST);
		UserAdmin::update("SET pass = '".md5("Portol1") . "' where id = $id");
	}
	public function delUser(){
		extract($_POST);
		UserAdmin::delete($id);
	}
}