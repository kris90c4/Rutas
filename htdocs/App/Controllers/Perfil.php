<?php
namespace App\Controllers;

defined("APPPATH") OR die("Acceso denegado");
//Solo usuarios registrados tienen acceso a esta clase
defined("USUARIO") OR die("Acceso denegado");

use \Core\View,
\App\Models\User as Users,

\App\Models\Admin\User as UserAdmin,
\App\Models\PerfilM;

class Perfil{
	// Elimina la sesión inciada
	public function logout(){
		session_destroy();
		unset($_SESSION);
		view::set("title","Home");
		View::render('home');
	}
	public function view(){
		//Si no hay una session usuario iniciada se reenvia al login
		// Doble comprobación
		if(!isset($_SESSION['usuario'])){
			view::set("title","Login");
			View::render('login');
		}else{
			view::set("title","Perfil");
			View::render('perfil');
		}
	}

	public function buzon(){
		
	}

	// Usado para una llamada Post de ajax
	// Valida que los campos enviados sean correctos antes de acceder a la base de datos
	public function modificarPass(){
		// Se convierten los indices en variables
		extract($_POST);

		//en caso de recibir algún campo vacio
		if(empty($oldPass)||empty($newPass)||empty($cNewPass)){
			exit("faltan campos por rellenar");
		}

		//Se codifica la contraseña y se verifica que coincida con la actual
		$oldPass=md5($oldPass);
		$oldPass==$_SESSION['usuario']->getPass()?:exit("Contraseña antigua incorrecta");
		
		//Validacion Contraseña por Expresion regular
		if(!preg_match("/(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/",$newPass)){
			exit("Requisitos Minimos:<br>1 Mayuscula<br>1 Minuscual<br>1 Digitio<br>6 Caracteres o mas");
		}
		//Si la contraseña de confirmación no coincide
		if($newPass!=$cNewPass){
			exit("Contraseña de confirmación no valida");
		}
		//Finalmente se codifica la contraseña
		$newPass=md5($newPass);

		//Se actualiza la contraseña en la base de datos y en la session en caso de que se actualice correctamente
		$ok=UserAdmin::update("SET pass = '$newPass' WHERE id= $id AND pass = '$oldPass'");
		if($ok==1){
			echo "Contraseña modificada con exito";
			$_SESSION['usuario']->setPass($newPass);
		}
	}
	//Genera la vista de gestion de usuarios
	public function gestion(){
		// Verifica que solo los administradores puedan entrar en esta vista
		if($_SESSION['usuario']->getAdmin()){
			//Constante para verificar que solo se pueda acceder a la vista desde aqui
			define("ADMIN",1);
			
			$queryUsers=UserAdmin::getAll();
			$usuarios=array();
			//Se almacena cada usuario en la clase Perfil y todos en un array
			foreach ($queryUsers as $key => $value) {
				$usuarios[$key]=new PerfilM($value);
			}
			//se envian todos los usuarios con su corresponiente clase perfil
			View::set("usuarios",$usuarios);
			view::set("title","Gestion usuarios");
			View::render("gestionUsuarios");
		}else{
			//Si un usuario no administrador intenta acceder
			die("Acceso Denegado");
		}
	}
	// al recibir una peticion via post de ajax de un administrador, resetea la contraseña a Portol1
	public function resetPass(){
		if($_SESSION['usuario']->getAdmin()){
			//Constante para verificar que solo se pueda acceder a la vista desde aqui
			extract($_POST);
			UserAdmin::update("SET pass = '".md5("Portol1") . "' where id = $id");
		}
	}
	// Se pasa via post la columna id y admin. Si se intenta eliminar un admin, lanza en mensaje de error
	public function delUser(){
		if($_SESSION['usuario']->getAdmin()){
			extract($_POST);
			if($admin==0){
				UserAdmin::delete($id);
			}else{
				echo "No puedes eliminar un administrador";
			}
		}
	}
}