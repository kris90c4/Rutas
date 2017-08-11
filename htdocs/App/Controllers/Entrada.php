<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Entrada as EntradaM;


class Entrada{
	public function view(){
		View::set("title","Entradas");
		View::set("entradas",EntradaM::getAll());
		View::render('Entradas');
	}
	public function create($id=0) {
		View::set('title',"Nueva entrada");
		if($id>0){
			view::set('compraventa',EntradaM::getById($id));
		}
		View::render("entrada");
	}
	//Guarda en la base de datos los datos introducidos en el formulario
	public function save() {
		if (isset($_POST['enviar'])){

			extract($_POST);

			/** Clases necesarias */

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
			$objPHPExcel->getActiveSheet()->SetCellValue('s13', $valor);
			$objPHPExcel->getActiveSheet()->SetCellValue('F14', $vendedor);
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

			var_export($fileName);
			// Guarda el archivo

			$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

			$objWriter->save(__DIR__.'\Traspasos\\'.$fileName);

			echo "<script> if (window.confirm('If you click \"ok\" you would be redirected . Cancel will load this website ')){

				window.location.href='App/Controllers/Traspasos/$fileName';
				window.location.href='?controller=entrada&action=view';

			};
			</script>";

		}else{//si por algo no cargo el archivo bak_
			echo "Rellena el formulario";
		}
		if($ok=EntradaM::insert($entrada)){//Si es correcto se reenvia a la tabla
			
			echo "<script> if (window.confirm('If you click \"ok\" you would be redirected . Cancel will load this website ')){
				window.location.href='?controller=entrada&action=view';
				window.location.href='App/Controllers/Traspasos/$fileName';
				

			};
			</script>";
		}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error
			View::set("error","Ha ocurrido un error.");
			View::set('title',"Nueva entrada");
			View::render("entrada");
		}
		/*}else{
			if($ok=EntradaM::update($_POST)){//Si es correcto se reenvia a la tabla
				$this->view();
			}else{//si hay algun fallo se devuelve al formulario y se muestra que ha habido un error

			}
		}*/
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