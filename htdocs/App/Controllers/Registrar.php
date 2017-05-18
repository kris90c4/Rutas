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
	public function save(){
		
		if(isset($_POST['registrar'])){
			echo extract($_POST);
			$usuarios=UserAdmin::getByMail($mail);
			if($usuarios){
				view::set("mail",$mail);
				view::set("nombre",$nombre);
				view::set("apellidos",$apellidos);
				view::set("eMail",true);
				View::render("registrar");
			}else{
				UserAdmin::insert($user)
			}
			
		}else{
			View::render("errors/404");
		}
	}
}