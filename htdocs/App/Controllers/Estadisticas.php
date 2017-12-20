<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");
// Comprueba si se esta logeado y si no lo esta se reenvia al login
require PROJECTPATH . '/App/usuario.php';
//USUARIO==1 OR die("Acceso denegado");
 
use \Core\View,
	\App\Models\Entrada as EntradaM,
	\App\Models\Ajax;


class Estadisticas{
	public function view(){
		View::set("title","Estadisticas");
		View::set("entradas",EntradaM::getAll());

		
		View::Set("datos",Ajax::sql("SELECT count(matricula) vehiculos, count(matricula) traspasos, count(id_compraventa) compraventas, count(id_vendedor) particulares FROM entrada"));
		//Cada tipo de traspaso
		View::Set("tipos",Ajax::sql("SELECT tipos.nombre tipo, count(entrada.id) total FROM entrada join tipos on tipos.id = entrada.id_tipo GROUP BY id_tipo"));
		View::render('estadisticas');
	}
	public function sql($sql){
		Ajax::sql($sql);
	}
	//Consulta dinamica de las estadisticas
	public function filtro(){
		extract($_POST);
		//var_export($hasta);
		$con="true";
		//Semafaro para saber si hay que poner AND o no
		$primer=true;

		//Se mira si hay que consultar solo particulares o solo compraventas
		if(!empty($vcv)){
			if($vcv=="cv"){
				$con=" ISNULL(id_vendedor)";
			}else{
				$con=" ISNULL(id_compraventa)";
			}
			$primer=false;
		}
		//Se mostraran solo resultados desde la fecha
		if(!empty($desde)){
			if(!$primer){
				$con.=" AND ";
			}else{
				$con="";
			}
			$con.=" fecha_entrada >= '". $desde . "'";
			$primer=false;
		}
		//Se mostraran solo resultados hasta la fecha
		if(!empty($hasta)){
			if(!$primer){
				$con.=" AND ";
			}else{
				$con="";
			}
			$con.=" fecha_entrada <= '" . $hasta . " 23:59'";
		}
		if(!empty($usuario)){
			if(!$primer){
				$con.=" AND ";
			}else{
				$con="";
			}
			$con.=" usuarios.nombre = '" . $usuario. "'";
		}

		$horas=Ajax::sql("SELECT HOUR(fecha_entrada) hora, count(entrada.id) cantidad FROM entrada join usuarios on usuarios.id = entrada.id_usuario where $con group by HOUR(fecha_entrada)  ORDER BY HOUR(fecha_entrada)");
		$diaria=Ajax::sql("SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as fecha, DAYOFWEEK(entrada.fecha_entrada) dayofweek, count(entrada.id) traspasos, t1.mails FROM entrada LEFT JOIN(SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as clave2, count(entrada.id) mails FROM entrada entrada join cliente on cliente.id = entrada.id_comprador join usuarios on usuarios.id = entrada.id_usuario WHERE cliente.mail like '%@%' AND $con GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')) t1 on DATE_FORMAT(entrada.fecha_entrada,'%m-%d') = t1.clave2 join usuarios on usuarios.id = entrada.id_usuario WHERE $con GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')");

		$usuarios=Ajax::sql("SELECT usuarios.nombre, count(entrada.id) traspasos, IFNULL(m1.mails,0) mails FROM entrada join usuarios on usuarios.id = entrada.id_usuario left join(SELECT usuarios.nombre, count(cliente.mail) mails FROM entrada join cliente on cliente.id= entrada.id_comprador join usuarios on usuarios.id= entrada.id_usuario WHERE cliente.mail LIKE '%@%' AND $con group by id_usuario) m1 on m1.nombre = usuarios.nombre WHERE $con group by id_usuario ORDER BY traspasos DESC");

		$json['usuarios']=$usuarios;
		$json['diaria']=$diaria;
		$json['horas']=$horas;

		//Se devuelve un objeto JSON
		echo json_encode($json);
	}
}