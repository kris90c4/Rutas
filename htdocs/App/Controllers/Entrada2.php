<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Entrada as EntradaM,
	\App\Models\Entrada2 as Entrada2M,
	\App\Models\Compraventa as CompraventaM,
	\App\Models\User as UserM,
	\App\Models\Enviado as EnviadoM,
	\App\Models\Ajax,
	\App\Models\Cliente as ClienteM;


class Entrada2 extends ControllerBase{
	public function view(){
		View::set("title","Entradas");
		$entradas=Entrada2M::getView();
		for ($i=0; $i < count($entradas); $i++) { 
			$cliente=ClienteM::getByTlf($entradas[$i]['vTelefono']);
			if(!empty($cliente))
				$entradas[$i]['vId']=$cliente['id'];
		}
		
		View::set("entradas",$entradas);
		View::render('entradas2');
	}
	public function create($id=0,$editar=array()) {
		View::set('title',"Nueva entrada");
		if($id>0){
			view::set('editar',$editar);
		}
		View::render("entrada");
	}

	public function getPrecio($tipo){
		return Ajax::sql("SELECT precio FROM tipos where id = $tipo");
	}
	
	public function id_cliente($datos){
		if($datos['telefono']==0){
			$datos['telefono']=ClienteM::getLastId();
		}

		if(empty($cliente=ClienteM::getByTlf($datos['telefono']))){
			return ClienteM::insert($datos);
		}else{
			return $cliente['id'];
		}
	}
	//funcion para ajax
	public function no_duplicar($tlf){
		

			if(empty($cliente=ClienteM::getByTlf($tlf))){
				echo false;
			}else{
				$resultados=json_encode($cliente);
				echo $resultados;
			}
		
	}

	//Guarda en la base de datos los datos introducidos en el formulario
	public function log($mensaje){
		$log=fopen("log.txt", "a");
		fwrite($log, date("d H:i:s")." --> ".$mensaje."\n");
	}
	public function save() {
		try{
			if (isset($_POST['enviar'])){

				extract($_POST);


				$matricula=strtoupper($matricula);
				$vendedor=strtoupper($vendedor);
				$comprador=strtoupper($comprador);
				//$vMail=strtolower($vMail);
				//$cMail=strtolower($cMail);

				$this->log("Creando entrada... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());

				//Se recopilan todos los datos necesarios para almacenarlos en la base de datos

				$datosVendedor=array('nombre'=> $vendedor, 'mail'=> $vMail, 'telefono'=> $vTlf);
				$datosComprador=array('nombre'=> $comprador, 'mail'=> $cMail, 'telefono'=> $cTlf);
				$datos=$_POST;
				$datos['matricula']=$matricula;
				$datos['base_imponible']=$base_imponible;
				$datos['tipo_de_gravamen']=$tipo_de_gravamen;
				if($tipo=="part"){
					$datos['id_vendedor']=$this->id_cliente($datosVendedor);
					//Para aplicar null en la base de datos
					$datos['id_compraventa']=null;
				}else{
					$datos['id_compraventa']=$id_compraventa;
					if($id_compraventa==""){
						view::set('error','No se ha introducido correctamente el compraventa');
						view::render('entrada');
						$this->log("Compraventa mal introducido");
						exit();
					}
					//Para aplicar null en la base de datos
					$datos['id_vendedor']=null;
				}
				$datos['id_comprador']=$this->id_cliente($datosComprador);
				
				$datos['id_tipo']=$tipo_traspaso;
				$datos['provision']=$provision;
				$datos['cobrado']=isset($pago)?date('Y-m-d'):NULL;
				$datos['id_usuario']=$_SESSION['usuario']->getId();

/*
				// Clases necesarias 

				require_once('Classes/PHPExcel.php');

				require_once('Classes/PHPExcel/Reader/Excel2007.php');

				require_once('Classes/PHPExcel/Writer/Excel2007.php');
				
				// Cargando la hoja de cálculo

				$objReader = new \PHPExcel_Reader_Excel2007();

				if($tipo=="part")
					$objPHPExcel = $objReader->load(__DIR__."\HojaEntradaParticulares2017.xlsx");
				else{
					$objPHPExcel = $objReader->load(__DIR__."\HojaEntradaCompraventas2017.xlsx");
				}

				$objFecha = new \PHPExcel_Shared_Date();

				// Asignar hoja de excel activa

				$objPHPExcel->setActiveSheetIndex(0);


				//conectamos con la base de datos

				///////////////////////////////////////////////////////////


				///////////////////////////////////////////////////////////


				// Llenamos el arreglo con los datos  del archivo xlsx

				$objPHPExcel->getActiveSheet()->SetCellValue('X2', $matricula);
				$objPHPExcel->getActiveSheet()->SetCellValue('X4', date('d-m-Y'));
				$objPHPExcel->getActiveSheet()->SetCellValue('X6', $_SESSION['usuario']->getNombre());
				$objPHPExcel->getActiveSheet()->SetCellValue('X8', isset($pago)?$provision:"");
				$objPHPExcel->getActiveSheet()->SetCellValue('X9', isset($pago)?date('d-m-Y'):"Pendiente");
				
				$objPHPExcel->getActiveSheet()->SetCellValue('S13', $base_imponible);
				$objPHPExcel->getActiveSheet()->SetCellValue('V13', $tipo_de_gravamen);
				if($tipo=="cv"){
					$objPHPExcel->getActiveSheet()->SetCellValue('G14', $vendedor);
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('F14', $vendedor);
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('D16', $vTlf);
				$objPHPExcel->getActiveSheet()->SetCellValue('D18', $vMail);
				$objPHPExcel->getActiveSheet()->SetCellValue('F21', $comprador);
				$objPHPExcel->getActiveSheet()->SetCellValue('D23', $cTlf);
				$objPHPExcel->getActiveSheet()->SetCellValue('D25', $cMail);
				if($tipo=="cv")
					$objPHPExcel->getActiveSheet()->SetCellValue('Y18', $gestion);
				$presupuesto = $objPHPExcel->getActiveSheet()->getCell('X33')->getFormattedValue();
				// Importar a base de datos, tabla entrada

				$entrada=$_POST;
				$entrada['total']=$presupuesto;



				// Nombre archivo

				$fileName=$matricula.".xlsx";

				// Guarda el archivo

				$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

				$objWriter->save(__DIR__.'\Traspasos\\'.$fileName);
*/

				$e2=Entrada2M::insert($datos);

				ob_start();
				print "Formulario: \n";
				var_export($datos);
				$error= ob_get_contents();
				ob_end_clean();
				ob_start();

				if(substr($e2, 0, 5) == "Error"){
					$this->log("Entrada2: $e2\n$error");

					View::set("error","Ha ocurrido un error.");
					View::set('title',"Nueva entrada");
					View::render("entrada");
				}else{
					$ok=EntradaM::insert($datos);
					if(substr($ok, 0, 5) == "Error"){
						$this->log("Entrada: $ok\n$error");
						View::set("error","Ha ocurrido un error.");
						View::set('title',"Nueva entrada");
						View::render("entrada");
					}else{
						$this->log("entrada OK");
						echo "<script>
						window.location.href='?controller=entrada2&action=view';
						</script>";
					}
				}
				

			}
		}catch(Exception $e){
			$this->log("Error:" . $e->getMessage());
		}
	}

	public function descargar(){

		$entrada = Entrada2M::getById($_POST['id']);
		
		extract($entrada);
		
		require_once('Classes/PHPExcel.php');

		require_once('Classes/PHPExcel/Reader/Excel2007.php');

		require_once ('Classes/PHPExcel/IOFactory.php');

		include_once ('Classes/PHPExcel/Writer/Excel2007.php');

		include_once ('Classes/PHPExcel/Writer/PDF.php');

		
		//$rendererName = \PHPExcel_Settings::PDF_RENDERER_TCPDF;

		// tcpdf folder
		
		//$rendererLibraryPath = dirname(__FILE__).'\Classes\PHPExcel\Writer\PDF'; 

		//include_once ('Classes/PHPExcel/Writer/PDF/tcPDF.php');
		
		// Cargando la hoja de cálculo

		$objReader = new \PHPExcel_Reader_Excel2007();

		//exit(__DIR__."/HojaEntradaParticulares2017.xlsx");

		if($id_vendedor){
			$datosVendedor=ClienteM::getById($entrada['id_vendedor']);
			$objPHPExcel = $objReader->load(__DIR__."/HojaEntradaParticulares2017.xlsx");
		}else{
			$datoscompraventa=CompraventaM::getById($entrada['id_compraventa']);
			$objPHPExcel = $objReader->load(__DIR__."/HojaEntradaCompraventas2017.xlsx");
		}
		$datosComprador=ClienteM::getById($entrada['id_comprador']);

		/** Clases necesarias */



		$objFecha = new \PHPExcel_Shared_Date();

		// Asignar hoja de excel activa

		$objPHPExcel->setActiveSheetIndex(0);


		//conectamos con la base de datos

		///////////////////////////////////////////////////////////

		$usuario= UserM::getById($entrada['id_usuario']);
		///////////////////////////////////////////////////////////


		// Llenamos el arreglo con los datos  del archivo xlsx

		$objPHPExcel->getActiveSheet()->SetCellValue('X2', $matricula);
		$objPHPExcel->getActiveSheet()->SetCellValue('X4', date("d-m-Y", strtotime($fecha_entrada)));
		$objPHPExcel->getActiveSheet()->SetCellValue('X6', $usuario['nombre']);
		$objPHPExcel->getActiveSheet()->SetCellValue('X8', $provision);
		$objPHPExcel->getActiveSheet()->SetCellValue('X9', $cobrado);


		
		$objPHPExcel->getActiveSheet()->SetCellValue('S13', $base_imponible);
		$objPHPExcel->getActiveSheet()->SetCellValue('V13', $tipo_de_gravamen);

		$resultado=$this->getPrecio($id_tipo);
		$precio=$resultado[0]['precio'];
		$objPHPExcel->getActiveSheet()->SetCellValue('Y16', $precio);
		
		if($id_vendedor){
			$objPHPExcel->getActiveSheet()->SetCellValue('F14', $datosVendedor['nombre']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D16', $datosVendedor['telefono']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D18', $datosVendedor['mail']);
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('G14', $datoscompraventa['nombre']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D16', $datoscompraventa['telefono']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D18', $datoscompraventa['mail']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y18', $datoscompraventa['gestion']);
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('F21', $datosComprador['nombre']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D23', $datosComprador['telefono']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D25', $datosComprador['mail']);

		$presupuesto = $objPHPExcel->getActiveSheet()->getCell('X33')->getFormattedValue();
		// Importar a base de datos, tabla entrada

		// Nombre archivo

		$fileName=$matricula.".xlsx";

		// Guarda el archivo

		//\PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

		$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
		//$objWriter = new \PHPExcel_Writer_PDF($objPHPExcel);
		//$objWriter->writeAllSheets();

		// Redirect output to a client’s web browser (Excel2007)

		header('Content-Type: application/Excel');

		header("Content-Disposition: attachment;filename=\"$fileName\"");

		header('Cache-Control: max-age=0');

		//$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');

		$objWriter->save(__DIR__.'/Traspasos/'.$fileName);

		echo "App/Controllers/Traspasos/$fileName";
		

	}

	public function descargarsalida(){

		$entrada = Entrada2M::getById($_POST['id']);
		
		require_once('Classes/PHPExcel.php');

		require_once('Classes/PHPExcel/Reader/Excel2007.php');

		require_once('Classes/PHPExcel/Writer/Excel2007.php');

		require_once('Classes/PHPExcel/Writer/PDF.php');
		
		// Cargando la hoja de cálculo

		$objReader = new \PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load(__DIR__."/HojaSalida.xlsx");

		/** Clases necesarias */

		$objFecha = new \PHPExcel_Shared_Date();

		// Asignar hoja de excel activa

		$objPHPExcel->setActiveSheetIndex(0);



		// Llenamos el arreglo con los datos  del archivo xlsx

		$objPHPExcel->getActiveSheet()->SetCellValue('G23', $entrada['matricula']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G38', date("d-m-Y", strtotime($entrada['fecha_salida'])));

		
		// Importar a base de datos, tabla entrada

		// Nombre archivo

		$fileName="Salida-".$entrada['matricula'].".xlsx";

		// Guarda el archivo

		$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

		$objWriter->save(__DIR__.'/Traspasos/Salidas/'.$fileName);

		echo "App/Controllers/Traspasos/Salidas/$fileName";
		

	}

	//Al recargar la pagina de entradas, se vuelven a seleccionar los traspasos marcados
	public function check(){
		$enviados=EnviadoM::getAll();
		for ($i=0; $i < count($enviados); $i++) { 
			$enviados[$i]=$enviados[$i]['id_entrada'];
		}
		$myJSON = json_encode($enviados);
		echo $myJSON;
	}

	public function seleccionar(){
		EnviadoM::insert($_POST);
	}
	public function deseleccionar(){
		EnviadoM::delete($_POST['id']);
	}

	//Ajax
	//Return "ok" Todo bien
	//Return "error" No se ha enviado
	public function enviar(){

		//Devuelve los telefonos de las entradas que coincidan con las entradas en la tabla enviado.
		$sql="SELECT c.telefono comprador, cv.telefono compraventa, v.telefono vendedor FROM entrada2 left JOIN compraventa cv on cv.id = entrada2.id_compraventa JOIN enviado ON entrada2.id = enviado.id_entrada left JOIN cliente c ON c.id = entrada2.id_comprador left JOIN cliente v ON v.id = entrada2.id_vendedor";

		$telefonos=Ajax::sql($sql);

		
		//Se elimina el array intermedio
		for ($i=0; $i < count($telefonos); $i++) { 


			//Si encuentra un telefono de comprador menor a 6 digitos, busca el del vendedor o el del comrpaventa
			if(strlen($telefonos[$i]['comprador'])>6){
				$telefonos[$i]=$telefonos[$i]['comprador'];
			}else{
				if($telefonos[$i]['vendedor']==null){
					$telefonos[$i]=$telefonos[$i]['compraventa'];
				}else{
					$telefonos[$i]=$telefonos[$i]['vendedor'];
				}
			}

		}

		if(count($telefonos)==0){
			exit(count($telefonos));
		}
		
		//Se envia el correo
		$ok=mail("comercial@gestoriaportol.com","Enviar sms a los ".count($telefonos)." telefonos seleccionados",implode(",", $telefonos),"From: cristiandiazportero@gmail.com");

		if($ok){
			$this->log($_SESSION['usuario']->getNombre() . " ha enviado los siguientes telefonos " . implode(", ", $telefonos));
			echo count($telefonos);
		}else{
			echo "error";
		}
		

	}

	//Ajax
	//Se actualiza la fecha de salida en la tabla entrada2
	//Se elimina los registros de la tabla enviado
	public function confirmar(){

		$sql="SELECT entrada2.matricula, c.telefono comprador, c.mail cMail, cv.telefono compraventa, cv.mail cvMail, v.telefono vendedor, v.mail vMail FROM entrada2 left JOIN compraventa cv on cv.id = entrada2.id_compraventa JOIN enviado ON entrada2.id = enviado.id_entrada left JOIN cliente c ON c.id = entrada2.id_comprador left JOIN cliente v ON v.id = entrada2.id_vendedor";

		$salida=Ajax::sql($sql);

		
		//Se elimina el array intermedio
		for ($i=0; $i < count($salida); $i++) { 


			//Si encuentra un telefono de comprador menor a 6 digitos, busca el del vendedor o el del comrpaventa
			if(strlen($salida[$i]['comprador'])>6){
				$mail=$salida[$i]['cMail'];
			}else{
				if($salida[$i]['vendedor']==null){
					$mail=$salida[$i]['cvMail'];
				}else{
					$mail=$salida[$i]['vMail'];
				}
			}
			if(strpos($mail,"@")){
				//Tiene correo
				if($this->mandar_mail($mail,"Documentación de la matrícula ".$salida[$i]['matricula']." tramitada","Le informamos que la documentación referente al vehículo con matrícula ".$salida[$i]['matricula']." ya está tramitada.<br>Podrá recogerla en Gestoría Pòrtol, C/ Gran Vía Asima, 15, 1º Izquierda.<br>Para cualquier consulta estamos disponibles en el siguiente teléfono 971908095.<br>Nuestro horario de atención al público es de 8:00 a 20:00 de lunes a viernes y de 9:00 a 13:00 los sabados.<br>Para la recogida de la documentación será necesario presentar el DNI para dejar constancia de quien la recoge","comercial@gestoriaportol.com")) {
				}
			}

		}

		/*
		// Se identifican los clientes que tengan pendiente el envio de SMS
		$sql="SELECT cliente.telefono, cliente.mail, entrada2.matricula FROM entrada2 JOIN cliente ON entrada2.id_comprador = cliente.id JOIN enviado ON entrada2.id = enviado.id_entrada";

		$telefonos=Ajax::sql($sql);*/
		if(count($salida)==0){
			exit(count($salida));
		}



		Entrada2M::updateSalida();
		EnviadoM::deleteAll();
		echo "ok";
	}

	public function editar($id) {

		$datos=Entrada2M::getById($id);

		if($datos['id_vendedor']){
			$datos['tipo']="p";
			$vendedor=ClienteM::getById($datos['id_vendedor']);
			$datos['vendedor']=$vendedor['nombre'];
			$datos['vMail']=$vendedor['mail'];
			$datos['vTlf']=$vendedor['telefono'];
		}else{
			$datos['tipo']="cv";
			$compraventa=CompraventaM::getById($datos['id_compraventa']);
			$datos['vendedor']=$compraventa['nombre'];
			$datos['vMail']=$compraventa['mail'];
			$datos['vTlf']=$compraventa['telefono'];
		}

		$comprador=ClienteM::getById($datos['id_comprador']);
		$datos['comprador']=$comprador['nombre'];
		$datos['cMail']=$comprador['mail'];
		$datos['cTlf']=$comprador['telefono'];
		
		$this->create($datos['id'],$datos);

	}

	public function editado(){
		if (isset($_POST['editar'])){

			extract($_POST);

			$matricula=strtoupper($matricula);
			$vendedor=strtoupper($vendedor);
			$comprador=strtoupper($comprador);
			//$vMail=strtolower($vMail);
			//$cMail=strtolower($cMail);

			$this->log("Editando entrada... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());
			
			//Se recopilan todos los datos necesarios para almacenarlos en la base de datos

			$datosVendedor=array('id'=>$id_vendedor,'nombre'=> $vendedor, 'mail'=> $vMail, 'telefono'=> $vTlf);
			$datosComprador=array('id'=>$id_comprador,'nombre'=> $comprador, 'mail'=> $cMail, 'telefono'=> $cTlf);

			$datos['matricula']=$matricula;
			$datos['base_imponible']=$base_imponible;
			$datos['tipo_de_gravamen']=$tipo_de_gravamen;
			if($tipo=="part"){
				$datos['id_vendedor']=$this->actualizar_cliente($datosVendedor);
			}else{
				/////////////Pendiente, no funciona la colocacion de informacion en el formulario///////////////
				$datos['id_compraventa']=$id_compraventa;
			}
			$datos['id_comprador']=$this->actualizar_cliente($datosComprador);
			
			$datos['id_tipo']=$tipo_traspaso;
			//$datos['provision']=$provision;
			//$datos['cobrado']=isset($pago)?date('Y-m-d'):NULL;
			$datos['id_usuario']=$_SESSION['usuario']->getId();
			$datos['id']=$id;

			$e2=Entrada2M::update($datos);

			if($e2==1){
				$this->log("entrada2 OK");
				$this->view();
			}else{
				$this->log("Error: ".$e2);
			}
		}
	}
	public function actualizar_cliente($datos){
		// Si el numero de telefono no existe, se actualiza id del cliente actual.
		if(empty($cliente=ClienteM::getByTlf($datos['telefono']))){
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
			//Si ya existe el numero del cliente, solo se devuelve su id
			return $cliente['id'];
		}
	}

	public function error404(){
		View::render("errors/404");
	}
	//Pendiente
	public function del($id){
		$resultado=Entrada::delete($id);
	}
}
?>