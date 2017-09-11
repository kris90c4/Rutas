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

		
		/*$mail = new PHPMailer();

		//Luego tenemos que iniciar la validación por SMTP:
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPDebug  = 2;
		$mail->Host = "smtp.gmail.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
		$mail->Username = "cristiandiazportero@gmail.com"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
		$mail->Password = PASS; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
		$mail->Port = 25; // Puerto de conexión al servidor de envio. 
		$mail->From = "cristiandiazportero@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
		$mail->FromName = ""; //A RELLENAR Nombre a mostrar del remitente. 
		$mail->AddAddress("cristiansmx2a@gmail.com"); // Esta es la dirección a donde enviamos 
		$mail->SMTPSecure = 'tls';
		$mail->IsHTML(true); // El correo se envía como HTML 
		$mail->Subject = "Titulo"; // Este es el titulo del email. 
		$body = "Hola mundo. Esta es la primer línea "; 
		$body .= "Aquí continuamos el mensaje"; 
		$mail->Body = $body; // Mensaje a enviar. 
		$exito = $mail->Send(); // Envía el correo.
		if($exito){ 
			echo "El correo fue enviado correctamente."; 
		}else{ 
			echo "Hubo un problema. Contacta a un administrador."; 
		} */

		/*//require_once('../class.phpmailer.php');
		$mail = new PHPMailer();
		//indico a la clase que use SMTP
		$mail->IsSMTP();
		//permite modo debug para ver mensajes de las cosas que van ocurriendo
		$mail->SMTPDebug = 2;
		//Debo de hacer autenticación SMTP
		$mail->SMTPAuth = true;
		$mail->SMTPAuth = false;
		$mail->SMTPSecure = false;
		//$mail->SMTPSecure = "ssl";
		//indico el servidor de Gmail para SMTP
		$mail->Host = "smtp.gmail.com";
		//indico el puerto que usa Gmail
		//$mail->Port = 465;
		$mail->Port = 587;
		//$mail->SMTPSecure = 'tls';
		//indico un usuario / clave de un usuario de gmail
		$mail->Username = "cristiandiazportero@gmail.com";
		$mail->Password = PASS;
		$mail->SetFrom('cristiandiazportero@gmail.com', 'Nombre completo');
		//$mail->AddReplyTo("cristiansmx2a@gmail.com","Nombre completo");
		$mail->Subject = "Envío de email usando SMTP de Gmail";
		$mail->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");
		//indico destinatario
		$address = "cristiansmx2a@gmail.com";
		$mail->AddAddress($address);
		if(!$mail->Send()) {
		echo "Error al enviar: " . $mail->ErrorInfo;
		} else {
		echo "Mensaje enviado!";
		}*/
		/*$para = "cristiansmx2a@gmail.com";
		$asunto = "Prueba de SMTP local";
		$mensaje = "Mensaje de prueba";
		$cabeceras = "From: cristiandiazportero@gmail.com" . "\r\n" .
		"Reply-To: cristiandiazportero@gmail.com" . "\r\n" .
		"X-Mailer: PHP/" . phpversion();

		if(mail($para, $asunto, $mensaje, $cabeceras)) {
			echo "Correo enviado correctamente";
		} else {
			echo "Error al enviar mensaje";
		}*/
	}

	//Pruebas para cargar dos vistas seguidas
	/*public function multiViews(){
		//Se envia un array con las vistas que se desean cargar
		View::set("vista", ["factu/matriculaciones","factu/traspasos"]);
		View::set("title", "Saludo");
		View::render("multiViews");
	}

	public function users(){
		$users = User::getAll();
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}

	public function usersAdmin(){
		$users = UserAdmin::getAll();
		View::set("users", $users);
		View::set("title", "Usuarios");
		View::render("users");
	}*/	
	//Lanza a la pagina de error404 al no encontrar el destino
	public function error404(){
		View::render("errors/404");
	}
	public function excel(){
		View::set('title','Importar desde excel');
		View::render('excel');
	}
}