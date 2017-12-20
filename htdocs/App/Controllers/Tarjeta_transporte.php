<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");

 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin,
	\PHPMailer\PHPMailer\PHPMailer;


class Tarjeta_transporte{
	//Carga la pagina principal de la aplicacion
	public function view(){
		View::set("title","Tarjetas de transporte");
		View::render('Tarjeta_transporte');
	}
	
}