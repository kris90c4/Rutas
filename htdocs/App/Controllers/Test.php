<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';
 
use \Core\View,
	\App\Models\User,
	\App\Models\Admin\User as UserAdmin,
	\PHPMailer\PHPMailer\PHPMailer;


class Test{
	public function galeria(){
		View::render('galeria');
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
	public function test($matri){
		//phpinfo();
		$sqlsrv = new \PDO("sqlsrv:Server=localhost ; Database=bdVersion5xp", "gestionTrafico", "gestionTrafico.1");
		$sqlsrv->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		//$sqlsrv->exec("SET CHARACTER SET utf8");
		try {
			//Se declara la instancia que se comunica con la base de datos
			$sql = "SELECT VEHICULOS.Matricula, TRANS.NIF TRANSDNI, TRANS.Nombre TRANSNombre, TRANS.Apellido1RazonSocial TRANSApellido, TRANS.Telef TRANSTelf, ADQ.NIF ADQDNI, ADQ.Nombre ADQNombre, ADQ.Apellido1RazonSocial ADQApellido, ADQ.Telef ADQTelef, TRANSMISIONES.Anotaciones FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo JOIN PERSONAS ADQ ON ADQ.CodigoPersona = TRANSMISIONES.ADQCodigoPersona JOIN PERSONAS TRANS ON TRANS.CodigoPersona = TRANSMISIONES.TRANSCodigoPersona WHERE  VEHICULOS.Matricula LIKE '%".$matri."%' ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC";
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
	public function test3(){
		//$this->siga("UPDATE TRANSMISIONES SET Anotaciones = CONCAT(Anotaciones, '\nSALIDA ".date('d/m/Y')."') WHERE CODIGOTRANSMISION = (SELECT TOP 1 TRANSMISIONES.CODIGOTRANSMISION FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo AND VEHICULOS.Matricula = '0273DXX' ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC)");
		$this->sigaUpdate("UPDATE TRANSMISIONES SET Anotaciones = CONCAT(Anotaciones, '\nSALIDA ".date('d/m/Y')."') WHERE CODIGOTRANSMISION = 26422");
		//$this->siga("SELECT Procedencia, Anotaciones FROM TRANSMISIONES WHERE CODIGOTRANSMISION = 26422");
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
	public function pdf(){
		/**
		 * PHPExcel
		 *
		 * Copyright (C) 2006 - 2011 PHPExcel
		 *
		 * This library is free software; you can redistribute it and/or
		 * modify it under the terms of the GNU Lesser General Public
		 * License as published by the Free Software Foundation; either
		 * version 2.1 of the License, or (at your option) any later version.
		 *
		 * This library is distributed in the hope that it will be useful,
		 * but WITHOUT ANY WARRANTY; without even the implied warranty of
		 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
		 * Lesser General Public License for more details.
		 *
		 * You should have received a copy of the GNU Lesser General Public
		 * License along with this library; if not, write to the Free Software
		 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
		 *
		 * @category   PHPExcel
		 * @package    PHPExcel
		 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
		 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
		 * @version    ##VERSION##, ##DATE##
		 */
		/** Error reporting */
		error_reporting(E_ALL);
		date_default_timezone_set('Europe/London');
		/** PHPExcel */
		require_once 'Classes/PHPExcel.php';
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PDF Test Document")
									 ->setSubject("PDF Test Document")
									 ->setDescription("Test document for PDF, generated using PHP classes.")
									 ->setKeywords("pdf php")
									 ->setCategory("Test result file");
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Hello')
		            ->setCellValue('B2', 'world!')
		            ->setCellValue('C1', 'Hello')
		            ->setCellValue('D2', 'world!');
		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename="01simple.pdf"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$objWriter->save('php://output');
		exit;

	}
}