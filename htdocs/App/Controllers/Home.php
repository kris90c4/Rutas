<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");

 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin,
	\PHPMailer\PHPMailer\PHPMailer;


class Home extends ControllerBase{
	//Carga la pagina principal de la aplicacion
	public function view(){
		View::set("title","Home");
		View::render('home');
	}
	public function mail(){

		$para = "cristiansmx2a@gmail.com, jesukris90@gmail.com";
		$asunto = "Envio masivo";
		$mensaje = "Mensaje de prueba";
		$cabeceras = "From: cristiandiazportero@gmail.com" /*. "\r\n" .
		"Reply-To: cristiandiazportero@gmail.com" . "\r\n" .
		"X-Mailer: PHP/" . phpversion()*/;

		if(mail($para, $asunto, $mensaje, $cabeceras)) {
			$error = "Correo masivo enviado correctamente";
		} else {
			$error = "Error al enviar mensaje";
		}
		View::set('error',$error);
		View::render('home');

	}
	public function test(){
		//phpinfo();
		$sqlsrv = new \PDO("sqlsrv:Server=localhost ; Database=bdVersion5xp", "gestionTrafico", "gestionTrafico.1");
		$sqlsrv->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		//$sqlsrv->exec("SET CHARACTER SET utf8");
		try {
			//Se declara la instancia que se comunica con la base de datos
			$sql = "SELECT VEHICULOS.Matricula, TRANS.NIF TRANSDNI, TRANS.Nombre TRANSNombre, TRANS.Apellido1RazonSocial TRANSApellido, TRANS.Telef TRANSTelf, ADQ.NIF ADQDNI, ADQ.Nombre ADQNombre, ADQ.Apellido1RazonSocial ADQApellido, ADQ.Telef ADQTelef FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo JOIN PERSONAS ADQ ON ADQ.CodigoPersona = TRANSMISIONES.ADQCodigoPersona JOIN PERSONAS TRANS ON TRANS.CodigoPersona = TRANSMISIONES.TRANSCodigoPersona ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC";
			// Se preapara la sentencia SQL
			$query = $sqlsrv->prepare($sql);
			//Se ejecuta la sentencia
			$query->execute();
			//se elige como se devolvera el resultado
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			//Se devuelven todos las filas dentro de un array
			$rows=$query->fetchAll();
			
			var_export($rows);
		}
		catch(\PDOException $e)
		{//En caso de error se imprime
			print "Error!: " . $e->getMessage();
		}

	}

	public function test2(){
		$para="cristiansmx2a@gmail.com";
		$para.=",myrna@gestoriaportol.com";
		if($this->mandar_mail($para,"Documentación de la matrícula 1111AAA tramitada",
			"Le informamos que la documentación referente al vehículo con matrícula 1111AAA ya está tramitada.<br>Podrá recogerla en Gestoría Pòrtol, C/ Gran Vía Asima, 15, 1º Izquierda.<br>Para cualquier consulta estamos disponibles en el siguiente teléfono 971908095.<br>Nuestro horario de atención al público es de 8:00 a 20:00 de lunes a viernes y de 9:00 a 13:00 los sabados.<br>Para la recogida de la documentación será necesario presentar el DNI para dejar constancia de quien la recoge","comercial@gestoriaportol.com")) {
			$error = "Correo masivo enviado correctamente";
		} else {
			$error = "Error al enviar mensaje";
		}
		View::set('error',$error);
		View::render('home');
		
	}
	public function novedades(){
		View::set('title','novedades');
		View::render('novedades');
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