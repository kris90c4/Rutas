<?php
namespace App\Controllers;

defined("APPPATH") OR die("Access denied");

use \Core\View,
\App\Models\User as Users,
\App\Models\Admin\User as UserAdmin,
\App\Models\Perfil as PerfilModel;

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
			define('USUARIO',$_SESSION['usuario']['id']);
			View::set('usuario', $_SESSION['usuario']);
			View::render('perfil');
		}
	}
	public function modificarPass(){
		extract($_POST);
		if(empty($oldPass)||empty($newPass)){
			exit("faltan campos por rellenar");
		}
		$oldPass=md5($oldPass);
		echo $oldPass==$_SESSION['usuario']['contraseña']?"":exit("Contraseña antigua incorrecta");
		$newPass=md5($newPass);
		
		if(UserAdmin::update("SET contraseña = '$newPass' WHERE id= $id AND contraseña = '$oldPass'")==true){
			echo "Contraseña modificada con exito";
			$_SESSION['usuario']['contraseña']=$newPass;
		}
	}
	public function gestion(){
		$usuarios=UserAdmin::getAll();
		View::set("usuarios",$usuarios);
		VIEW::render("gestionUsuarios");
	}
}