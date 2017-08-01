<!-- http://ProgramarEnPHP.wordpress.com -->

<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<form id="plantilla" method="post" action="">
	<label>Solicitante</label>
	<select name="tipo" id="tipo">
		<option value="part">Particular</option>
		<option value="cv">CompraVenta</option>
	</select>
	<br><br>
	<h3>Datos Vehiculo</h3><br>
	<label for="matricula">Matricula <font color="red">*</font></label>
	<input id="matricula" type="text" name="matricula"/>
	<br>
	<label for="valor">Valoración <font color="red">*</font></label>
	<input id="valor" type="text" name="valor"/>
	<br><br>
	<h3>Vendedor/Compraventa</h3><br>
	<label for="vendedor">Nombre <font color="red">*</font></label>
	<input id="vendedor" type="text" name="vendedor" required />
	<br>
	<label for="vMail">Mail <font color="red">*</font></label>
	<input id="vMail" type="text" name="vMail" required />
	<br>
	<label for="vTlf">Telefono <font color="red">*</font></label>
	<input id="vTlf" type="number" name="vTlf" required />
	<br><br>
	<h3>Comprador</h3><br>
	<label for="comprador">Nombre <font color="red">*</font></label>
	<input id="comprador" type="text" name="comprador" required />
	<br>
	<label for="cMail">Mail <font color="red">*</font></label>
	<input id="cMail" type="text" name="cMail" required />
	<br>
	<label for="cTlf">Telefono <font color="red">*</font></label>
	<input id="cTlf" type="number" name="cTlf" required />
	<br><br>
	<h3>Cobro</h3>
	<br>
	<label for="provision">Provision<font color="red">*</font></label>
	<select name="provision" id="provision">
		<option value="tarjeta">Visa</option>
		<option value="efectivo">Efectivo</option>
		
	</select>
	<br>
	<label for="cMail">Mail <font color="red">*</font></label>
	<input id="cMail" type="text" name="cMail" required />
	<br><br>
	<input class="btn btn-success" type='submit' name='enviar'  value="Crear Entrada"  />

</form>

<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

<?php

	

	if (isset($_POST['enviar'])){

		extract($_POST);

		/** Clases necesarias */

		require_once('Classes/PHPExcel.php');

		require_once('Classes/PHPExcel/Reader/Excel2007.php');

		require_once('Classes/PHPExcel/Writer/Excel2007.php');
		
		// Cargando la hoja de cálculo

		$objReader = new PHPExcel_Reader_Excel2007();

		if($tipo=="part")
			$objPHPExcel = $objReader->load(__DIR__."\HojaEntradaParticulares2017.xlsx");
		else{
			$objPHPExcel = $objReader->load(__DIR__."\HojaEntradaCompraventas2017.xlsx");
		}

		$objFecha = new PHPExcel_Shared_Date();

		// Asignar hoja de excel activa

		$objPHPExcel->setActiveSheetIndex(0);


		//conectamos con la base de datos

		///////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////


		// Llenamos el arreglo con los datos  del archivo xlsx

		$objPHPExcel->getActiveSheet()->SetCellValue('X2', $matricula);
		$objPHPExcel->getActiveSheet()->SetCellValue('X4', date('d-m-Y'));
		$objPHPExcel->getActiveSheet()->SetCellValue('X6', $_SESSION['usuario']->getNombre());
		$objPHPExcel->getActiveSheet()->SetCellValue('s13', $valor);
		$objPHPExcel->getActiveSheet()->SetCellValue('F14', $vendedor);
		$objPHPExcel->getActiveSheet()->SetCellValue('D16', $vTlf);
		$objPHPExcel->getActiveSheet()->SetCellValue('D18', $vMail);
		$objPHPExcel->getActiveSheet()->SetCellValue('F21', $comprador);
		$objPHPExcel->getActiveSheet()->SetCellValue('D23', $cTlf);
		$objPHPExcel->getActiveSheet()->SetCellValue('D25', $cMail);

		// Nombre archivo

		$fileName=$matricula.".xlsx";

		var_export($fileName);
		// Guarda el archivo

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

		$objWriter->save(__DIR__.'\Traspasos\\'.$fileName);

		echo "<a href=\"App\Views\Traspasos\\".$fileName."\" >Descargar</a>";

	}else{//si por algo no cargo el archivo bak_
		echo "Rellena el formulario";
	}
	



?>