<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
 
use \Core\View;


class Tramites extends ControllerBase{
	//Carga la pagina principal de la aplicacion
	public function view($codigo){
		$id=md5($codigo);
		View::set("id",$id);
		View::render('estado');
	}
	public function estado($codigo=""){

		$matri=base64_decode($codigo);
		//TRANSMISIONES.CODIGOTRANSMISION, VEHICULOS.Matricula, TRANSMISIONES.Anotaciones
		$traspaso=$this->siga("SELECT TOP 1 TRANSMISIONES.CODIGOTRANSMISION, TRANSMISIONES.FPRESENTACION, VEHICULOS.Matricula, ADQ.Nombre, ADQ.Apellido1RazonSocial Apellido, TRANSMISIONES.Anotaciones FROM TRANSMISIONES JOIN VEHICULOS ON VEHICULOS.CodigoVehiculo = TRANSMISIONES.VEHICodigoVehiculo AND VEHICULOS.Matricula = '". $matri."' JOIN PERSONAS ADQ ON ADQ.CodigoPersona = TRANSMISIONES.ADQCodigoPersona ORDER BY TRANSMISIONES.CODIGOTRANSMISION DESC");
		View::set("id",$traspaso);
		View::set("title","Gestoria Portol");
		View::render('estado');
	}
}