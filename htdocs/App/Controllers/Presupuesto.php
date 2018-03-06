<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
//Solo se permite el acceso si se ha inicializado la constante INVITADO
require PROJECTPATH . '/App/usuario.php';

use \Core\View,
	\App\Models\Presupuesto as PresupuestoM;

class Presupuesto extends ControllerBase{
	//Se muestra el formulario para logear
	public function view(){
		View::set("title", "Presupuesto");
		View::render("presupuesto");
	}

	//Se recivirá via ajax un objeto JSON
	public function save(){
		extract($_POST);
		$values=json_decode($json,true);
		//var_export($values);
		$values['id_usuario']=$_SESSION['usuario']->getId();
		echo PresupuestoM::insert($values);
	}
	public function correo(){
		extract($_POST);
		//echo $html;
		$this->mandar_mail('cristiansmx2a@gmail.com','Presupuesto', $html);
	}
}