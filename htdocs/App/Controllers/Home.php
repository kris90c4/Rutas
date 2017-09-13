<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
define("PASS", "Orionagb29...");
 
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
	public function mail(){

		$para = "cristiansmx2a@gmail.com";
		$asunto = "Prueba de SMTP local";
		$mensaje = "Mensaje de prueba";
		$cabeceras = "From: cristiandiazportero@gmail.com" /*. "\r\n" .
		"Reply-To: cristiandiazportero@gmail.com" . "\r\n" .
		"X-Mailer: PHP/" . phpversion()*/;

		if(mail($para, $asunto, $mensaje, $cabeceras)) {
			$error = "Correo enviado correctamente";
		} else {
			$error = "Error al enviar mensaje";
		}
		View::set('error',$error);
		View::render('home');

	}
	public function test(){
		phpinfo();
	}
	//Lanza a la pagina de error404 al no encontrar el destino
	public function error404(){
		View::render("errors/404");
	}
	public function excel(){
		View::set('title','Importar desde excel');
		View::render('excel');
	}
}