<?php
namespace App\Controllers;
require_once PROJECTPATH . '/vendor/autoload.php';
defined("APPPATH") OR die("Acceso denegado");
//defined("USUARIO") OR die("Acceso denegado");

use \Goutte\Client,
\App\Models\Cliente as ClienteM;

class ControllerBase{
	//Para la instancia del Curl para el servidor de ATIB
	private $client;
	private $form;
	private $i;

	//Tratamiento de caracteres
	public function tratamiento_datos_cliente(&$cliente){
		$cliente['nombre']=ucwords(strtolower($cliente['nombre'])," ");
		$cliente['mail']=strtolower($cliente['mail']);
	}
	//Si se pasa un 0 como telefono o un telefono que no existe, se crea un nuevo contacto, sino, se devuelve el id del contacto encontrado
	public function id_cliente($datos){
		//Si se envia un 0 se crea un contacto con el numero de telefono del siguiente id de contacto disponible.
		if($datos['telefono']==0){
			$datos['telefono']=ClienteM::getLastId();
		}
		//Si existe el contacto se devuelve su id, sino existe, se crea.
		if(empty($cliente=ClienteM::getByTlf($datos['telefono']))){
			return ClienteM::insert($datos);
		}else{
			return $cliente['id'];
		}
	}
	public function actualizar_cliente($datos){
		// Si el numero de telefono no existe, se actualiza id del cliente actual.
		if(empty($cliente=ClienteM::getByTlf($datos['telefono']))||$datos['telefono']==0){
			$cliente=ClienteM::getById($datos['id']);
			$sql="";
			$coma="";
			if($cliente['telefono']!=$datos['telefono']){
				$sql.="telefono = '" . $datos['telefono']."'";
				$coma=",";
			}
			if(strcmp($cliente['mail'],$datos['mail'])){
				$sql.="$coma mail = '" . $datos['mail']."'";
				$coma=",";
			}
			if(strcmp($cliente['nombre'],$datos['nombre'])){
				$sql.="$coma nombre = '" . $datos['nombre']."'";
			}
			if(!empty($sql)){
				$sql.= "where id = ". $datos['id'];
				if(ClienteM::updateManual("set $sql")){
					return $datos['id'];
				}
			}
		}else{
			//Si ya existe el numero del cliente, solo se devuelve su id. Se supone que si ya existe el numero, se ha actualizado mediante ajax desde javascript
			return $cliente['id'];
		}
	}

	//Guarda en la base de datos los datos introducidos en el formulario
	public function log($mensaje){
		$log=fopen("log.txt", "a");
		fwrite($log, date("d H:i:s")." --> ".$mensaje."\n");
	}
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
	public function dgt(){
		$client = new Client();
		/*$empieza= new \DateTime();*/
		// Login page
		/*$crawler = $client->request('GET', 'https://sedeclave.dgt.gob.es/WEB_INTV_INTER/xhtml/acciones/iniciarDatosVerificacion.jsf');

		// Select Login form
		//$form = $crawler->selectButton('btnFirmar')->form();

		//$post['id_owner']='43185091s';
		//$post['pin']='HddNoSsdSi90.';
		//$crawler = $client->submit($form, $post);
		$url="https://pasarela.clave.gob.es/Proxy/ServiceProvider";
 		$input1=$crawler->filterXPath("//*[@name='SAMLRequest']")->attr('value');
 		$input2=$crawler->filterXPath("//*[@name='idpList']")->attr('value');
 		$input3=$crawler->filterXPath("//*[@name='allowLegalPerson']")->attr('value');
 		$client2 = new Client();
 		$crawler2 = $client2->request('POST', $url,array("SAMLRequest"=>$input1,"idpList"=>$input2,"allowLegalPerson"=>$input3));

		$form=$crawler2->filter("form[name=ssRedirect] #indexparseScope_samlId")->parents()->eq(0)->form();
		$crawler2=$client2->submit($form);
		$url2=$crawler2->filter("iframe")->attr('src');
		
		$client3 = new Client();
		$crawler2 = $client2->request('GET', $url2);
		$form2=$crawler2->filter("#countrySelector")->form();
		$crawler2=$client3->submit($form2);

		//$link = $crawler->selectLink('Acceder  >')->link();
		//$crawler2 = $client2->click($link);
		//$crawler = $client->getCrawler();
		echo $html=$crawler2->html();*/
		//getInternalRequest()

		$crawler = $client->request('GET','https://clave-dninbrt.seg-social.gob.es/rss-gateway/AuthByLevelFormGateWayServlet?id_transaction=');
		echo $html=$crawler->html();
	}
	public function atib($matricula,$precio=0){

		$this->insta620();
		//DNI Comprador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$nifC']='43185091s';
		//Apellido Comrpador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$apenomC']="diaz";
		//Matricula
		$post['ctl00$ctl00$cph_main$cph_main$621_0$numMatricu2']=$matricula;
		//DNI Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnif']='43077529R';
		//Apellido Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnombre']='garcia';

		$post['ctl00$ctl00$cph_main$cph_main$621_0$valorDecla']=number_format($precio,2,",",".");

		// Submit form
		$crawler = $this->client->submit($this->form, $post);

		//Devuelve todo el contenido de la respuesta
		//echo $html=$crawler->html();
		/*$termina=new \DateTime();
		$interval=$empieza->diff($termina);
		echo "<br>".$interval->format("%ss");*/
		try{
			$values['cuota']= (int)str_replace(".","",$crawler->filterXPath("//*[@id='cph_main_cph_main_621_E_CuotaSola']")->attr('value'));
			$values['marca']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_marcaVeh']")->attr('value');
			$values['modelo']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_modeloVeh']")->attr('value');
			$values['bastidor']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_bastidorSV']")->attr('value');
			$values['cilindrada']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cilindrada']")->attr('value');
			$values['fechaMatri']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_fechaMatri']")->attr('value');
			$values['cvf']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cvf']")->attr('value');
		}catch(\Exception $e){
			$this->i++;
			$values['error'] = $crawler->filterXPath("//div[@class='alerta']/ul/li")->text();
		}
		try{
			$tag = $crawler->filterXPath("//div[@class='alerta']/ul/li")->text();
			$values['accion']="+";
			//echo "\nInferior";
		}catch(\Exception $e){
			$values['accion']="-";
			//echo "correcto";
		}
		return $values;
	}

	public function check620($matricula,$aprox=1000,$tick=500){
		//Contador de intentos tras errores del atib
		$this->i=0;
		$reduc=1;
		$sem=false;
		// cada vez que se reduce la cantidad a sumar o restar
		$i=0;
		$p=false;
		$values=array();
		$precioMuyAlto=false;
		session_write_close();
		while(true){
			$valuesanterior=$values;
			$values=$this->atib($matricula,$aprox);
			//Filtro para reintentar 10 veces el calculo, en caso de atib tener problemas.
			if(isset($values['error'])){
				if($this->i<8){
					continue;
				}else{
					break;
				}
			}
			//Si se cumple, el valor es inferior
			if($values['accion']=="+"){
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
					$values=$valuesanterior;
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
		}
		$values['precio']=$aprox;
		$values['i']=$this->i;
		session_start();
		return $values;
	}
	public function datosVehiculo($matricula){
		$empieza= new \DateTime();
		$this->insta620();
		//DNI Comprador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$nifC']='43185091s';
		//Apellido Comrpador
		$post['ctl00$ctl00$cph_main$cph_main$621_0$apenomC']="diaz";
		//Matricula
		$post['ctl00$ctl00$cph_main$cph_main$621_0$numMatricu2']=$matricula;
		//DNI Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnif']='43077529R';
		//Apellido Vendedor
		$post['ctl00$ctl00$cph_main$cph_main$621_0$txtnombre']='garcia';

		//Precio 0€
		$post['ctl00$ctl00$cph_main$cph_main$621_0$valorDecla']=number_format(0,2,",",".");

		// Submit form
		$crawler = $this->client->submit($this->form, $post);

		//Devuelve todo el contenido de la respuesta
		//echo $html=$crawler->html();

		/*$termina=new \DateTime();
		$interval=$empieza->diff($termina);
		echo "<br>".$interval->format("%ss");*/

		try{
			$values['cuota']= (int)str_replace(".","",$crawler->filterXPath("//*[@id='cph_main_cph_main_621_E_CuotaSola']")->attr('value'));
			$values['marca']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_marcaVeh']")->attr('value');
			$values['modelo']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_modeloVeh']")->attr('value');
			$values['bastidor']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_bastidorSV']")->attr('value');
			$values['cilindrada']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cilindrada']")->attr('value');
			$values['fechaMatri']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_fechaMatri']")->attr('value');
			$values['cvf']= $crawler->filterXPath("//*[@id='cph_main_cph_main_621_0_cvf']")->attr('value');
		}catch(\Exception $e){
			$values['error'] = $crawler->filterXPath("//div[@class='alerta']/ul/li")->text();
		}
		
		
		$termina=new \DateTime();
		$interval=$empieza->diff($termina);
		$values['time']=$interval->format("%i:%s");
		return $values;
	}
	public function error404(){
		View::render("errors/404");
	}
}

?>