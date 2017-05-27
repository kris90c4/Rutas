<?php
namespace App\Models;

class bd{
	//Devuelve todos los resultados
	function select($sql){
		try {
			$connection = Database::instance();
			$query = $connection->prepare($sql);
			//$query->bindParam(1, $mail, \PDO::PARAM_STR);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetchAll();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
	//Devuelve true o false, segun si se ha realizado correctamente.
	function others($sql){
		try {
			$connection = Database::instance();
			$query = $connection->prepare($sql);
			//$query->bindParam(1, $mail, \PDO::PARAM_STR);
			return $query->execute();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
	
}

?>