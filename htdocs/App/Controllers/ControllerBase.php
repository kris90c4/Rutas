<?php
namespace App\Controllers;
require_once PROJECTPATH . '/vendor/autoload.php';
defined("APPPATH") OR die("Acceso denegado");
//defined("USUARIO") OR die("Acceso denegado");

use \Goutte\Client;

class ControllerBase{

	private $client;
	private $form;

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
	public function sigaUpdate($sql){
		
		$sqlsrv = new \PDO("sqlsrv:Server=localhost ; Database=bdVersion5xp", "gestionTrafico", "gestionTrafico.1");
		$sqlsrv->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		//$sqlsrv->exec("SET CHARACTER SET utf8");
		try{
			//Se declara la instancia que se comunica con la base de datos
			
			// Se preapara la sentencia SQL
			$query = $sqlsrv->prepare($sql);
			//Se ejecuta la sentencia
			$query->execute();
			//se elige como se devolvera el resultado
		}
		//En caso de error se imprime
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
	public function insta620(){
		if(!isset($this->client)){
			$this->client = new Client();
			/*$empieza= new \DateTime();*/
			// Login page
			$crawler = $this->client->request('GET', 'https://www.atib.es/TA/modelos/Modelo.aspx?m=621');
			 
			// Select Login form
			$this->form = $crawler->selectButton('ctl00$ctl00$cph_main$cph_main$621_0$lnkBuscarTrafico')->form();
		}
	}
	public function atib($matricula,$precio){

		$this->insta620();
		//DNI Comprador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$nifC']='43185091s';
		//Apellido Comrpador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$apenomC']="diaz";
		//Matricula
		$post['ctl00$ctl00$cph_main$cph_main$621_0$numMatricu2']=$matricula;
		//DNI Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnif']='43185089j';
		//Apellido Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnombre']='diaz';

		$post['ctl00$ctl00$cph_main$cph_main$621_0$valorDecla']=number_format($precio,2,",",".");

		// Submit form
		$crawler = $this->client->submit($this->form, $post);

		//Devuelve todo el contenido de la respuesta
		//echo $html=$crawler->html();

		/*$termina=new \DateTime();
		$interval=$empieza->diff($termina);
		echo "<br>".$interval->format("%ss");*/

		$res['cuota']= (int)str_replace(".","",$crawler->filterXPath("//*[@id='cph_main_cph_main_621_E_CuotaSola']")->attr('value'));
		$res['marca']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_marcaVeh']")->attr('value');
		$res['modelo']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_modeloVeh']")->attr('value');
		$res['bastidor']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_bastidorSV']")->attr('value');
		$res['cilindrada']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cilindrada']")->attr('value');
		$res['fechaMatri']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_fechaMatri']")->attr('value');
		$res['cvf']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cvf']")->attr('value');
		

		if($res['cuota']){

		}
		try{
			$tag = $crawler->filterXPath("//div[@class='alerta']/ul/li")->text();
			//echo "\nInferior";
		}catch(\Exception $e){
			return $res;
			//echo "correcto";
		}
		return false;
	}


	public function check620($matricula,$aprox=1000,$tick=500){
		$reduc=1;
		$sem=false;
		// cada vez que se reduce la cantidad a sumar o restar
		$i=0;
		$p=false;
		$resultado=array();
		$precioMuyAlto=false;
		while(true){
			$resultadoanterior=$resultado;
			$resultado=$this->atib($matricula,$aprox);
			//Si se cumple, el valor es inferior
			if(!$resultado){
				//Si el precio se ha reducido una vez y no se ha puesto muy alto
				if($i==1 && $precioMuyAlto==false){
					$reduc=0.2;
					$i++;
				}else if($precioMuyAlto==true){//Si el precio es muy alto
					$reduc=0.2;
					$i++;
					$precioMuyAlto=false;
				}

				if($reduc==0.1){
					$aprox=round($aprox+($tick*$reduc));
					//echo "\nvalor->". $aprox;
					$resultado=$resultadoanterior;
					break;
				}
				//echo "\nvalor->". $aprox;
				$aprox=round($aprox+($tick*$reduc));
				$p=true;
			}else{// el valor no es inferior)
				//TRUE atib
				//echo "\nvalor->". $aprox;
				if($reduc==0.1){
					break;
				}
				//Si han puesto un precio muy alto, que se pueda ir bajando el precio
				if($p==false){
					$precioMuyAlto=true;
				}else if($i==0){
					$reduc=0.8;
				}else{
					$reduc=0.1;
				}
				$aprox=round($aprox-($tick*$reduc));
				$i++;
			}
			//echo "<br>".$aprox;
		}
		$resultado['precio']=$aprox;
		return $resultado;
	}
}
?>