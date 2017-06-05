<?php
namespace  App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
\App\Interfaces\Crud;

class Matri implements Crud{
	const TABLE = "matriculaciones";
	
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT matri.id, matri.entrada, matri.bastidor, matri.matricula, matri.cliente, 
							matri.alta, p.nombre provincia, m.nombre municipio, matri.salida  
						FROM ".self::TABLE . " matri 
						JOIN provincias p ON p.id =  matri.provincia 
						JOIN municipios m ON m.id = matri.municipio";
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetchAll();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	public static function getById($id){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE . "where id = ". $id;
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE." VALUES(null, :entrada, :bastidor, :matricula, :cliente, :alta, :provincia, :municipio, :poblacion, :salida, :id_usuario)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			isset($data['poblacion'])?:$data['poblacion']=null;
			isset($data['salida'])&&!empty($data['salida'])?:$data['salida']=null;
			$query->bindParam(":entrada", $data['entrada'], \PDO::PARAM_STR);
			$query->bindParam(":bastidor", $data['bastidor'], \PDO::PARAM_STR);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":cliente", $data['cliente'], \PDO::PARAM_STR);
			$query->bindParam(":alta", $data['alta'], \PDO::PARAM_STR);
			$query->bindParam(":provincia", $data['provincia'], \PDO::PARAM_INT);
			$query->bindParam(":municipio", $data['municipio'], \PDO::PARAM_INT);
			$query->bindParam(":poblacion", $data['poblacion'], \PDO::PARAM_INT);
			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			$query->bindParam(":id_usuario",$_SESSION['usuario']->getId(), \PDO::PARAM_INT);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	
	//
	public static function update($sql){
		try{
			$connection = Database::instance();
			$query = $connection->prepare($sql);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
	
	//pendiente de query
	public static function delete($id){
		try{
			$connection = Database::instance();
			
			$query = $connection->prepare($sql);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
}