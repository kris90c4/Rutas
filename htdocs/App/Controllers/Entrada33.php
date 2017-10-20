<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Entrada as EntradaM,
	\App\models\Cliente as ClienteM;


class Entrada33{
	public function view(){
		View::set("title","Entradas");
		View::set("entradas",EntradaM::getAll());
		View::render('Entradas');
	}
	public function create($id=0,$edit=array()) {
		View::set('title',"Nueva entrada");
		if($id>0){
			$edit['id']=$id;
			view::set('edit',$edit);
			//Enviar los indices que toca
		}
		View::render("entrada");
	}
	
	public function id_cliente($datos){
		if(empty($cliente=ClienteM::getByTlf($datos['telefono']))){
			return ClienteM::insert($datos);
		}else{
			return $cliente['id'];
		}
	}

	//Guarda en la base de datos los datos introducidos en el formulario
	public function save() {
		if (isset($_POST['enviar'])){

			extract($_POST);

			$matricula=strtoupper($matricula);
			$vendedor=strtoupper($vendedor);
			$comprador=strtoupper($comprador);
			//$vMail=strtolower($vMail);
			//$cMail=strtolower($cMail);

			$datosVendedor=array('nombre'=> $vendedor, 'mail'=> $vMail, 'telefono'=> $vTlf);
			$datosComprador=array('nombre'=> $comprador, 'mail'=> $cMail, 'telefono'=> $cTlf);

			$datos['matricula']=$matricula;
			$datos['base_imponible']=$base_imponible;
			$datos['tipo_de_gravamen']=$tipo_de_gravamen;
			if($tipo=="part"){
				$datos['id_vendedor']=$this->id_cliente($datosVendedor);
			}else{
				$datos['id_compraventa']=$id_compraventa;
			}
			$datos['id_comprador']=$this->id_cliente($datosComprador);
			
			$datos['id_tipo']=$tipo_traspaso;
			$datos['provision']=$provision;
			$datos['cobrado']=isset($pago)?date('Y-m-d'):NULL;
			$datos['id_usuario']=$_SESSION['usuario']->getId();

			EntradaM::insert($datos);





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
			
			$objPHPExcel->getActiveSheet()->SetCellValue('S13', $base_imponible);
			$objPHPExcel->getActiveSheet()->SetCellValue('V13', $tipo_de_gravamen);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('G14', $vendedor);
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

			/*echo "<script> if (window.confirm('Si presionas en \"ok\" se creara la plantilla de entrada . Estan todos los datos correctos? ')){

				window.location.href='App/Controllers/Traspasos/$fileName';
				window.location.href='?controller=entrada&action=view';

			};
			</script>";*/

		}else{//si por algo no cargo el archivo bak_
			echo "Rellena el formulario";
		}
		if($ok=EntradaM::insert($entrada)){//Si es correcto se reenvia a la tabla
			
			echo "<script> if (window.confirm('Si presionas en \"ok\" se creara la plantilla de entrada . Estan todos los datos correctos? ')){
				window.location.href='?controller=entrada&action=view';
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

	public function editar() {

		extract($_POST);

		/** Clases necesarias */

		require_once('Classes/PHPExcel.php');

		require_once('Classes/PHPExcel/Reader/Excel2007.php');

		require_once('Classes/PHPExcel/Writer/Excel2007.php');
		
		// Cargando la hoja de cálculo

		$objReader = new \PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load(__DIR__."\Traspasos\\$matricula.xlsx");

		$objFecha = new \PHPExcel_Shared_Date();

		// Asignar hoja de excel activa

		$objPHPExcel->setActiveSheetIndex(0);



		if($objPHPExcel->getActiveSheet()->getCell('X2')->getFormattedValue()==$matricula){
			$edit['matricula']=$matricula;
			$edit['valor']=$objPHPExcel->getActiveSheet()->getCell('s13')->getFormattedValue();
			$edit['vendedor']=$objPHPExcel->getActiveSheet()->getCell('F14')->getFormattedValue();
			$edit['vTlf']=$objPHPExcel->getActiveSheet()->getCell('D16')->getFormattedValue();
			$edit['vMail']=$objPHPExcel->getActiveSheet()->getCell('D18')->getFormattedValue();
			$edit['comprador']=$objPHPExcel->getActiveSheet()->getCell('F21')->getFormattedValue();
			$edit['cTlf']=$objPHPExcel->getActiveSheet()->getCell('D23')->getFormattedValue();
			$edit['cMail']=$objPHPExcel->getActiveSheet()->getCell('D25')->getFormattedValue();
		}

		echo json_encode($edit);

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