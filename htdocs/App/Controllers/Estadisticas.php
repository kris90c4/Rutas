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
		View::Set('diaria',Ajax::sql("SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as fecha, DAYOFWEEK(entrada.fecha_entrada) dayofweek, count(entrada.id) traspasos, t1.mails FROM entrada LEFT JOIN(SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as clave2, count(entrada.id) mails FROM entrada entrada join cliente on cliente.id = entrada.id_comprador WHERE cliente.mail like '%@%' GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')) t1 on DATE_FORMAT(entrada.fecha_entrada,'%m-%d') = t1.clave2 GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')"));
		View::render('estadisticas');
	}
	public function sql($sql){
		Ajax::sql($sql);
	}
	//Consulta dinamica de las estadisticas
	public function ajax1(){
		extract($_POST);
		//var_export($hasta);
		$con="1";
		//Semafaro para saber si hay que poner AND o no
		$primer=true;

		//Se mira si hay que consultar solo particulares o solo compraventas
		if(!empty($vcv)){
			if($vcv=="cv"){
				$con=" id_vendedor is null";
			}else{
				$con=" id_compraventa is null";
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
			//echo $con;
		}
		$horas=Ajax::sql("SELECT HOUR(fecha_entrada) hora, count(id) cantidad FROM entrada where $con  group by HOUR(fecha_entrada)  ORDER BY HOUR(fecha_entrada)");
		$diaria=Ajax::sql("SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as fecha, DAYOFWEEK(entrada.fecha_entrada) dayofweek, count(entrada.id) traspasos, t1.mails FROM entrada LEFT JOIN(SELECT DATE_FORMAT(entrada.fecha_entrada,'%m-%d') as clave2, count(entrada.id) mails FROM entrada entrada join cliente on cliente.id = entrada.id_comprador WHERE cliente.mail like '%@%' AND $con GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')) t1 on DATE_FORMAT(entrada.fecha_entrada,'%m-%d') = t1.clave2 WHERE $con GROUP BY DATE_FORMAT(entrada.fecha_entrada,'%m-%d')");
		//$traspasos=Ajax::sql("SELECT usuarios.nombre, count(entrada.id) traspasos FROM entrada join usuarios on usuarios.id= entrada.id_usuario where $con group by id_usuario  ORDER BY id_usuario");

		$usuarios=Ajax::sql("SELECT usuarios.nombre, count(entrada.id) traspasos, m1.mails FROM entrada join usuarios on usuarios.id = entrada.id_usuario join(SELECT usuarios.nombre, count(cliente.mail) mails FROM entrada join cliente on cliente.id= entrada.id_comprador join usuarios on usuarios.id= entrada.id_usuario WHERE cliente.mail LIKE '%@%' AND $con group by id_usuario ORDER BY id_usuario) m1 on m1.nombre = usuarios.nombre WHERE $con group by id_usuario  ORDER BY id_usuario");

		//$mails=Ajax::sql("SELECT usuarios.nombre, count(cliente.mail) mails FROM entrada join cliente on cliente.id= entrada.id_comprador join usuarios on usuarios.id= entrada.id_usuario WHERE cliente.mail LIKE '%@%' and $con group by id_usuario ORDER BY id_usuario");
		/*for ($i=0; $i < count($mails); $i++) { 
			$mailsf[$mails[$i]['nombre']]=$mails[$i]['mails'];
		}*/
		//var_export($traspasos);
		//Se juntan los dos arrays en uno, cada indice contendra el nombre y dispondra de dos dimensiones, la primera para los traspasos y la segunda para los mails
		/*for ($i=0; $i < count($traspasos); $i++) { 
			$usuarios[]=array($traspasos[$i]['nombre'],$traspasos[$i]['traspasos'],isset($mailsf[$traspasos[$i]['nombre']])?$mailsf[$traspasos[$i]['nombre']]:"0");
		}*/
		$json['usuarios']=$usuarios;
		$json['diaria']=$diaria;
		$json['horas']=$horas;

		//Se devuelve un objeto JSON
		echo json_encode($json);
	}
}