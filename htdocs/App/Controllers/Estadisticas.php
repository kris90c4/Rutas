<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
defined("USUARIO") OR die("Acceso denegado");
USUARIO==1 OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Entrada as EntradaM,
	\App\Models\Ajax;


class Estadisticas{
	public function view(){
		View::set("title","Estadisticas");
		View::set("entradas",EntradaM::getAll());
		//$fecha="month(entrada.fecha_entrada) = 9 ";
		$fecha="entrada.fecha_entrada > 01-09-2016 ";
		//View::Set("usuarios",Ajax::sql("SELECT usuarios.nombre FROM entrada join usuarios on usuarios.id= entrada.id_usuario group by id_usuario  ORDER BY id_usuario"));
		View::Set("usuarioTraspasos",Ajax::sql("SELECT usuarios.nombre, count(entrada.id) traspasos FROM entrada join usuarios on usuarios.id= entrada.id_usuario WHERE 1 group by id_usuario  ORDER BY id_usuario"));
		View::Set("usuarioMails",Ajax::sql("SELECT usuarios.nombre, count(cliente.mail) mails FROM entrada join cliente on cliente.id= entrada.id_comprador join usuarios on usuarios.id= entrada.id_usuario WHERE cliente.mail LIKE '%@%' and 1 group by id_usuario ORDER BY id_usuario"));
		
		View::Set("datos",Ajax::sql("SELECT count(DISTINCT(matricula)) vehiculos, count(matricula) traspasos, count(id_compraventa) compraventas, count(id_vendedor) particulares FROM entrada where $fecha"));
		//Cada tipo de traspaso
		View::Set("tipos",Ajax::sql("SELECT tipos.nombre tipo, count(entrada.id) total FROM entrada join tipos on tipos.id = entrada.id_tipo WHERE $fecha GROUP BY id_tipo"));
		//Consulta para saber los traspasos que se hacen en cada hora
		View::Set("horas",Ajax::sql("SELECT HOUR(fecha_entrada) hora, count(id) cantidad FROM entrada  group by HOUR(fecha_entrada)  ORDER BY HOUR(fecha_entrada)"));

		View::render('estadisticas');
	}
	public function sql($sql){
		Ajax::sql($sql);
	}
	public function ajax1($vcv=""){
		extract($_POST);
		$con="1";
		if(!empty($vcv)){
			if($vcv=="cv"){
				$con="id_vendedor is null";
			}else{
				$con="id_compraventa is null";
			}
		}
		$traspasos=Ajax::sql("SELECT usuarios.nombre, count(entrada.id) traspasos FROM entrada join usuarios on usuarios.id= entrada.id_usuario where $con group by id_usuario  ORDER BY id_usuario");
		$mails=Ajax::sql("SELECT usuarios.nombre, count(cliente.mail) mails FROM entrada join cliente on cliente.id= entrada.id_comprador join usuarios on usuarios.id= entrada.id_usuario WHERE cliente.mail LIKE '%@%' and $con group by id_usuario ORDER BY id_usuario");
		//Se juntan los dos arrays en uno, cada indice contendra el nombre y dispondra de dos dimensiones, la primera para los traspasos y la segunda para los mails
		for ($i=0; $i < count($traspasos); $i++) { 
			$json[]=array($traspasos[$i]['nombre'],$traspasos[$i]['traspasos'],isset($mails[$i]['mails'])?$mails[$i]['mails']:"");
		}

		//Se devuelve un objeto JSON
		echo json_encode($json);
	}
}