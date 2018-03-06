<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';
 
use \Core\View,
	\App\Models\Entrada as EntradaM,
	\App\Models\Compraventa as CompraventaM,
	\App\Models\User as UserM,
	\App\Models\Enviado as EnviadoM,
	\App\Models\Ajax,
	\App\Models\Cliente as ClienteM;




class Entrada extends ControllerBase{
	public function view(){
		View::set("title","Entradas");
		$entradas=EntradaM::getView();
		
		View::set("entradas",$entradas);
		View::render('entradas');
	}
	public function create($id=0,$editar=array()) {
		View::set('title',"Nueva entrada");
		if($id>0){
			view::set('editar',$editar);
			view::set('id',"plantilla");
		}
		View::render("entrada");
	}

	public function modalCreate(){
		echo file_get_contents(__DIR__."/App/Views/entrada.php");
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
	public function save() {
		try{
			if (isset($_POST['enviar'])){

				extract($_POST);

				$this->log("Creando entrada... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());

				//Se recopilan todos los datos necesarios para almacenarlos en la base de datos
				$datosVendedor=array('nombre'=> $vendedor, 'mail'=> $vMail, 'telefono'=> $vTlf);
				$datosComprador=array('nombre'=> $comprador, 'mail'=> $cMail, 'telefono'=> $cTlf);
				$this->tratamiento_datos_cliente($datosVendedor);
				$this->tratamiento_datos_cliente($datosComprador);
				$datos=$_POST;
				$datos['matricula']=strtoupper($matricula);
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

				//Medicion del tiempo desde que se crea el formulario hasta que se envia.
				$a=new \DateTime();
				$antes=$a->createFromFormat('Y-m-d H:i:s',$tiempo);
				$ahora=new \DateTime();
				$dif=$ahora->diff($antes);
				$datos['tiempo']=$dif->format("%H:%I");


				$datos['id_tipo']=$tipo_traspaso;
				$datos['provision']=$provision;
				$datos['cobrado']=isset($pago)?date('Y-m-d'):NULL;
				$datos['id_usuario']=$_SESSION['usuario']->getId();
				$datos['correo_ordinario']=isset($correo_ordinario)?$correo_ordinario:0;


				$resultado=EntradaM::insert($datos);

				//Se almacena en una variable, los datos introducidos en el formulario para mostrarlos en caso de
				ob_start();
				print "Formulario: \n";
				var_export($datos);
				$error= ob_get_contents();
				ob_end_clean();

				if(substr($resultado, 0, 5) == "Error"){
					$this->log("Entrada: $resultado\n$error");

					View::set("error","Ha ocurrido un error. $error $resultado");
					View::set('title',"Error");
					View::render("entrada");
				}else{
					$this->log("entrada OK");

					/*if(strpos($datosComprador['mail'],"@")){
						
					}*/
					header('location: ?controller=Entrada&action=view');
				}
			}
		}catch(Exception $e){
			$this->log("Error:" . $e->getMessage());
		}
	}

	public function descargar(){

		$entrada = EntradaM::getById($_POST['id']);
		extract($entrada);
		require_once('Classes/PHPExcel.php');
		require_once('Classes/PHPExcel/Reader/Excel2007.php');
		require_once ('Classes/PHPExcel/IOFactory.php');
		include_once ('Classes/PHPExcel/Writer/Excel2007.php');
		include_once ('Classes/PHPExcel/Writer/PDF.php');

		$objReader = new \PHPExcel_Reader_Excel2007();

		if($id_vendedor){
			$datosVendedor=ClienteM::getById($entrada['id_vendedor']);
			$objPHPExcel = $objReader->load(__DIR__."/HojaEntradaParticulares2017.xlsx");
		}else{
			$datoscompraventa=CompraventaM::getById($entrada['id_compraventa']);
			$objPHPExcel = $objReader->load(__DIR__."/HojaEntradaCompraventas2017.xlsx");
		}

		$datosComprador=ClienteM::getById($entrada['id_comprador']);

		$objFecha = new \PHPExcel_Shared_Date();

		// Asignar hoja de excel activa
		$objPHPExcel->setActiveSheetIndex(0);

		//conectamos con la base de datos
		$usuario= UserM::getById($entrada['id_usuario']);
		
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
			if($correo_ordinario==1){
				$objPHPExcel->getActiveSheet()->SetCellValue('S22', "Correos");
				$objPHPExcel->getActiveSheet()->SetCellValue('Y22', 15);
				$objPHPExcel->getActiveSheet()->SetCellValue('Z22', "€");
			}
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('G14', $datoscompraventa['nombre']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D16', $datoscompraventa['telefono']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D18', $datoscompraventa['mail']);
			//Gestiones Compraventas
			if($id_tipo==2){
				$objPHPExcel->getActiveSheet()->SetCellValue('Y18', $datoscompraventa['nv']);
			}else if($id_tipo==4){
				$objPHPExcel->getActiveSheet()->SetCellValue('Y18', $datoscompraventa['gestion']+$datoscompraventa['nv']);
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('Y18', $datoscompraventa['gestion']);
			}
			if($correo_ordinario==1){
				$objPHPExcel->getActiveSheet()->SetCellValue('S22', "Correos");
				$objPHPExcel->getActiveSheet()->SetCellValue('Y22', 15);
				$objPHPExcel->getActiveSheet()->SetCellValue('Z22', "€");
			}
		}
		if($correo_ordinario==2){
			$objPHPExcel->getActiveSheet()->SetCellValue('C39', "Correos Contrarembolso");
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

	public function descargar_salida(){

		require_once('Classes/PHPExcel.php');
		require_once('Classes/PHPExcel/Reader/Excel2007.php');
		require_once('Classes/PHPExcel/Writer/Excel2007.php');
		require_once('Classes/PHPExcel/Writer/PDF.php');
		
		$entrada = EntradaM::getById($_POST['id']);

		// Cargando la hoja de cálculo
		$objReader = new \PHPExcel_Reader_Excel2007();

		// Aplicando plantilla
		$objPHPExcel = $objReader->load(__DIR__."/HojaSalida.xlsx");

		// Clases necesarias
		$objFecha = new \PHPExcel_Shared_Date();

		// Asignar hoja de excel activa
		$objPHPExcel->setActiveSheetIndex(0);

		// Llenamos el arreglo con los datos  del archivo xlsx
		$objPHPExcel->getActiveSheet()->SetCellValue('G23', $entrada['matricula']);
		$objPHPExcel->getActiveSheet()->SetCellValue('G38', date("d-m-Y", strtotime($entrada['fecha_salida'])));
		$_SESSION['error']=$entrada;
		if($entrada['correo_ordinario']==1){
			$objPHPExcel->getActiveSheet()->SetCellValue('B2', "Enviar por correo ordinario");
		}
		if($entrada['id_compraventa']!=null){
			$compraventa=CompraventaM::getById($entrada['id_compraventa']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F2', $compraventa['nombre']);
		}

		// Nombre archivo
		$fileName="Salida-".$entrada['matricula'].".xlsx";

		// Guarda el archivo
		$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save(__DIR__.'/Traspasos/Salidas/'.$fileName);

		echo "App/Controllers/Traspasos/Salidas/$fileName";

	}

	//Al recargar la pagina de entradas, se vuelven a seleccionar los traspasos marcados
	// Ajax
	public function check(){
		$enviados=EnviadoM::getAll();
		for ($i=0; $i < count($enviados); $i++) { 
			$enviados[$i]=$enviados[$i]['id_entrada'];
		}
		$myJSON = json_encode($enviados);
		echo $myJSON;
	}
	// Ajax
	public function seleccionar(){
		EnviadoM::insert($_POST);
	}

	// Ajax
	public function deseleccionar(){
		EnviadoM::delete($_POST['id']);
	}

	// Ajax
	// Devuelve un array via Json
	// Envia un correo con todos los telefonos seleccionados o un sms
	// Si se le pasa un $_POST['sms'] se envia una peticion de envio por sms, sino, se envia por mail.
	public function enviar2(){
		//Devuelve los telefonos de las entradas que coincidan con las entradas en la tabla enviado.
		$sql="SELECT c.telefono comprador, cv.telefono compraventa, v.telefono vendedor FROM Entrada left JOIN compraventa cv on cv.id = Entrada.id_compraventa JOIN enviado ON Entrada.id = enviado.id_entrada left JOIN cliente c ON c.id = Entrada.id_comprador left JOIN cliente v ON v.id = Entrada.id_vendedor";

		$telefonos=Ajax::sql($sql);

		
		//Se elimina el array intermedio
		for ($i=0; $i < count($telefonos); $i++) { 
			//Si encuentra un telefono de comprador menor a 6 digitos, busca el del vendedor o el del compraventa
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
		$value['error']="";
		$texto="";
		if(count($telefonos)==0){
			$value['count']=count($telefonos);
		}else{
			if(isset($_POST['sms'])){
				$ok=true;
				$texto="por sms ";
			}else{
				//Se envia el correo
				$ok=mail("comercial@gestoriaportol.com","Enviar sms a los ".count($telefonos)." telefonos seleccionados ",implode(",", $telefonos),"From: cristiandiazportero@gmail.com");
			}
			if($ok){
				$this->log($_SESSION['usuario']->getNombre() . " ha enviado los siguientes telefonos $texto" . implode(", ", $telefonos));
				$value['count']= count($telefonos);
				$value['sms']=implode(",", $telefonos);
			}else{
				$value['error']= "error";
			}
		}
		echo json_encode($value);
	}

	//Ajax
	//Se actualiza la fecha de salida en la tabla Entrada.
	//Se actualiza las anotaciones de siga de cada traspaso.
	//Se elimina los registros de la tabla enviado.
	//Manda un mail si el cliente lo tiene.
	public function confirmar(){

		$sql="SELECT Entrada.matricula, c.telefono comprador, c.mail cMail, cv.telefono compraventa, cv.mail cvMail, v.telefono vendedor, v.mail vMail FROM Entrada left JOIN compraventa cv on cv.id = Entrada.id_compraventa JOIN enviado ON Entrada.id = enviado.id_entrada left JOIN cliente c ON c.id = Entrada.id_comprador left JOIN cliente v ON v.id = Entrada.id_vendedor";

		$salida=Ajax::sql($sql);

		//Se elimina el array intermedio
		for ($i=0; $i < count($salida); $i++) {

			//$filaSiga=$this->siga("SELECT TOP 1 TRANSMISIONES.CODIGOTRANSMISION FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo AND VEHICULOS.Matricula = '". $matri."' ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC");

			$this->sigaUpdate("UPDATE TRANSMISIONES SET Anotaciones = CONCAT(Anotaciones, '\nSALIDA ".date('d/m/Y')."') WHERE CODIGOTRANSMISION = (SELECT TOP 1 TRANSMISIONES.CODIGOTRANSMISION FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo AND VEHICULOS.Matricula = '". $salida[$i]['matricula']."' ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC)");

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
		$sql="SELECT cliente.telefono, cliente.mail, entrada.matricula FROM entrada JOIN cliente ON entrada.id_comprador = cliente.id JOIN enviado ON entrada.id = enviado.id_entrada";

		$telefonos=Ajax::sql($sql);*/
		if(count($salida)==0){
			exit(count($salida));
		}
		EntradaM::updateSalida();
		EnviadoM::deleteAll();
		echo "ok";
	}

	// Al pulsar el boton editar, se recogen los datos y se envian para mostrarlos
	public function editar($id) {

		$datos=EntradaM::getById($id);

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

	// Una vez editados, se tratan y se actualizan
	public function editado(){
		if (isset($_POST['editar'])){

			extract($_POST);

			$this->log("Editando entrada... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());
			
			//Se recopilan todos los datos necesarios para almacenarlos en la base de datos
			$datosVendedor=array('id'=>$id_vendedor,'nombre'=> $vendedor, 'mail'=> $vMail, 'telefono'=> $vTlf);
			$datosComprador=array('id'=>$id_comprador,'nombre'=> $comprador, 'mail'=> $cMail, 'telefono'=> $cTlf);
			$this->tratamiento_datos_cliente($datosVendedor);
			$this->tratamiento_datos_cliente($datosComprador);

			$datos['correo_ordinario']=isset($correo_ordinario)?$correo_ordinario:0;
			$datos['matricula']=strtoupper($matricula);
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

			$resultado=EntradaM::update($datos);

			if($resultado==1){
				$this->log("entrada OK");
				$this->view();
			}else{
				$this->log("Error: ".$resultado);
			}
		}
	}
	
	//Pendiente
	public function del($id){
		$resultado=Entrada::delete($id);
	}
	public function find620(){
		$empieza= new \DateTime(); 		
		extract($_POST);
		if(isset($matricula)&&!empty($matricula)){
			$json=$this->check620($matricula,empty($precio)?1000:$precio,empty($tick)?500:$tick);
			$termina=new \DateTime();
			$interval=$empieza->diff($termina);
			$json['time']=$interval->format("%i:%s");

			//echo json_encode($json);
		}else{
			$json['error']="Escribe una matricula";
		}
		echo $_SESSION['ultimo_resultado'] = json_encode($json);
	}
	public function ultimoResultado(){
		if(isset($_SESSION['ultimo_resultado'])){
			echo $_SESSION['ultimo_resultado'];
		}else{
			echo 'false';
		}
	}
	// recibe una matricula por POST
	public function jsonDatosVehiculo(){
		extract($_POST);
		$json=$this->datosVehiculo($matricula);
		echo json_encode($json);
	}
}
?>