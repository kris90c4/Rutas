<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
//defined("USUARIO") OR die("Acceso denegado");


class ControllerBase{

	// Envia un mail con codificacion UTF-8
	function mandar_mail($hacia = 'cristiansmx2a@gmail.com', $subject = 'Mail de la página', $mensaje = 'Prueba', $fromaddress = '', $sIP = '') {

		$eol = PHP_EOL;
		if ($sIP == '') $sIP = md5($subject.date('dmY'));
		if ($fromaddress == '') $fromaddress = '"Página Web" <noreply@'.$_SERVER['SERVER_NAME'].'>';

		$headers = 'From: '.$fromaddress.$eol; // de ...
		$headers.= 'Reply-To: '.$fromaddress.$eol; // responder a...
		$headers.= 'Return-Receipt-To: '.$fromaddress.$eol; // responder a...
		$headers.= 'Return-Path: '.$fromaddress.$eol; // responder a...
		$headers.= 'Message-ID: <'.time().' no-reply@'.$_SERVER['SERVER_NAME'].'>'.$eol; // anti-spam
		$headers.= 'X-Mailer: MyMailer v0.001'.$eol;  // info
		$headers.= 'Content-Type: multipart/alternative; boundary="'.$sIP.'"'.$eol;  // anti-spam
		$headers.= "Subject: =?UTF-8?B?".base64_encode($subject)."?=".$eol.$eol;

		// En caso de que no podamos leer html \\

		$msg  = '--'.$sIP.$eol;
		$msg .= 'Content-Type: text/plain; charset=UTF-8'.$eol;
		$msg .= 'Content-Transfer-Encoding: 7bit'.$eol.$eol;
		$msg .= 'Este e-mail requiere que active HTML.'.$eol;
		$msg .= 'Si usted esta leyendo esto, por favor actualice su cliente de correo.'.$eol;
		$msg .= 'Acentos y tildes omitidos con intencion.'.$eol;
		$msg .= '------- Mensaje cortado -------'.$eol.$eol;

		// Lo "normal", que podamos leer html \\
		
		$msg .= '--'.$sIP.$eol;
		$msg .= 'Content-Type: text/html; charset=UTF-8'.$eol;
		$msg .= 'Content-Transfer-Encoding: 7bit'.$eol.$eol;
		$msg .= $mensaje.$eol.$eol;

		ini_set('sendmail_from',$fromaddress); // anti-spam

		if (mail($hacia, "", wordwrap($msg,70,$eol), $headers)) {
			ini_restore('sendmail_from');
			return TRUE;
		}else{
			ini_restore('sendmail_from');
			return FALSE;
		}

	}

	public function siga($sql = "SELECT VEHICULOS.Matricula, TRANS.NIF TRANSDNI, TRANS.Nombre TRANSNombre, TRANS.Apellido1RazonSocial TRANSApellido, TRANS.Telef TRANSTelf, ADQ.NIF ADQDNI, ADQ.Nombre ADQNombre, ADQ.Apellido1RazonSocial ADQApellido, ADQ.Telef ADQTelef FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo JOIN PERSONAS ADQ ON ADQ.CodigoPersona = TRANSMISIONES.ADQCodigoPersona JOIN PERSONAS TRANS ON TRANS.CodigoPersona = TRANSMISIONES.TRANSCodigoPersona ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC"){
		
		$sqlsrv = new \PDO("sqlsrv:Server=localhost ; Database=bdVersion5xp", "gestionTrafico", "gestionTrafico.1");
		$sqlsrv->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		//$sqlsrv->exec("SET CHARACTER SET utf8");
		try {
			//Se declara la instancia que se comunica con la base de datos
			
			// Se preapara la sentencia SQL
			$query = $sqlsrv->prepare($sql);
			//Se ejecuta la sentencia
			$query->execute();
			//se elige como se devolvera el resultado
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			//Se devuelven todos las filas dentro de un array
			$rows=$query->fetchAll();
			
			return $rows;
		}
		//En caso de error se imprime
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
}
?>