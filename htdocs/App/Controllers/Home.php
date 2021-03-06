<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");

 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin,
	\PHPMailer\PHPMailer\PHPMailer;


class Home{
	//Carga la pagina principal de la aplicacion
	public function view(){
		View::set("title","Home");
		View::render('home');
	}
	public function error404(){
		View::render("errors/404");
	}
	public function sms(){
		View::set("title","SMS");
		View::set("sms","sms");
		View::render('home');
	}
	public function cache(){
		echo session_cache_expire();
	}
}