<!-- http://ProgramarEnPHP.wordpress.com -->

<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<form name="importa" method="post" action="" enctype="multipart/form-data" >

<input type="file" name="excel" />

<input type='submit' name='enviar'  value="Importar"  />

<input type="hidden" value="upload" name="action" />

</form>

<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

<?php

extract($_POST);

if (isset($action) && $action == "upload"){

	//cargamos el archivo al servidor con el mismo nombre

	//solo le agregue el sufijo bak_

	$archivo = $_FILES['excel']['name'];

	$tipo = $_FILES['excel']['type'];

	$destino = "bak_".$archivo;

	// Comprobacíon de carga correcta de archivo.
	
	if (copy($_FILES['excel']['tmp_name'],$destino)){
		echo "Archivo Cargado Con Éxito";
	}else{
		echo "Error Al Cargar el Archivo";
	}
	////////////////////////////////////////////////////////

	if (file_exists ("bak_".$archivo)){

		/** Clases necesarias */

		require_once('Classes/PHPExcel.php');

		require_once('Classes/PHPExcel/Reader/Excel2007.php');

		
		// Cargando la hoja de cálculo

		$objReader = new PHPExcel_Reader_Excel2007();

		$objPHPExcel = $objReader->load("Hoja Entrada Particulares 2017.xlsx");

		$objFecha = new PHPExcel_Shared_Date();

		// Asignar hoja de excel activa

		try{//HotFix para plantillas con hojas extras
			$objPHPExcel->setActiveSheetIndex(2);
		}catch(Exception $e){
			$objPHPExcel->setActiveSheetIndex(0);
		}

		//conectamos con la base de datos

		///////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////


		// Llenamos el arreglo con los datos  del archivo xlsx

		$_DATOS_EXCEL['matricula'] = $objPHPExcel->getActiveSheet()->getCell('X2')->getFormattedValue();

		$_DATOS_EXCEL['mail'] = $objPHPExcel->getActiveSheet()->getCell('D29')->getFormattedValue();

		$_DATOS_EXCEL['telefono'] = $objPHPExcel->getActiveSheet()->getCell('D27')->getFormattedValue();

	}else{//si por algo no cargo el archivo bak_
		echo "Necesitas primero importar el archivo";
	}
	


	//Se muestran los datos capturados
	if(isset($_DATOS_EXCEL))
		var_export($_DATOS_EXCEL);

	// Se borra el archivo del servidor
	unlink($destino);

}

?>