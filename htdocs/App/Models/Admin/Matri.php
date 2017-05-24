<?php
namespace  App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
\App\Interfaces\Crud;

class Matri implements Crud{
	const TABLA = "matriculaciones";
	
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE;
			$query = $connection->prepare($sql);
			$query->execute();
			return $query->fetchAll();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	public static function getById($id){
		
	}
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLA." VALUES(null, :entrada, :bastidor, :matricula, :cliente, :alta, :provincia, :municipio, :poblacion, :salida)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			isset($data['poblacion'])?:$data['poblacion']=null;
			isset($data['salida'])&&!empty($data['salida'])?:$data['salida']=null;
			exit($data['alta']);
			$query->bindParam(":entrada", $data['entrada'], \PDO::PARAM_STR);
			$query->bindParam(":bastidor", $data['bastidor'], \PDO::PARAM_STR);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":cliente", $data['cliente'], \PDO::PARAM_STR);
			$query->bindParam(":alta", $data['alta'], \PDO::PARAM_STR);
			$query->bindParam(":provincia", $data['provincia'], \PDO::PARAM_INT);
			$query->bindParam(":municipio", $data['municipio'], \PDO::PARAM_INT);
			$query->bindParam(":poblacion", $data['poblacion'], \PDO::PARAM_INT);
			echo "<script>console.log(".$data["salida"]."Hola);</script>";
			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	public static function update($data){
		
	}
	public static function delete($id){
		
	}
}