<?php
namespace App\Models;
defined("APPPATH") OR die("Acceso denegado");

use \core\Database;

class ajax{

	public static function sql($sql){
		try {
			$connection = Database::instance();
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetchAll();

			//devolvemos la colección para que la vista la presente.
			/*header("access-control-allow-origin: *");
			header("Content-Type: application/json; charset=UTF-8");
			
			$myJSON = json_encode($object);
			echo $myJSON;*/
		}catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}

	//Devuelve un string con el formato JSON de la tabla solicitada
	public static function select($tabla){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from $tabla";
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			$object=$query->fetchAll();

			//devolvemos la colección para que la vista la presente.
			header("access-control-allow-origin: *");
			header("Content-Type: application/json; charset=UTF-8");
			
			$myJSON = json_encode($object);
			echo $myJSON;
		}catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
}
?>