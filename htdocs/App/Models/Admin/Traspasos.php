<?php
namespace  App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
\App\Interfaces\Crud;

class Traspasos implements Crud{
	const TABLE = "traspasos";
	
	//devuelve todos los elementos de la tabla traspasos, traduciendo las claves foraneas por su respectivo nombre
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT traspaso.id, traspaso.entrada, traspaso.matricula, tipos.nombre,
							traspaso.salida, usuarios.nombre
						FROM ".self::TABLE . " 
						JOIN tipos  ON tipos.id =  traspaso.id_tipo
						JOIN usuarios  ON usuarios.id = traspaso.id_usuario";
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
			$sql="INSERT INTO ".self::TABLE." VALUES(null, :entrada, :matricula, :id_tipo, :salida, :id_usuario)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			isset($data['poblacion'])?:$data['poblacion']=null;
			isset($data['salida'])&&!empty($data['salida'])?:$data['salida']=null;
			$query->bindParam(":entrada", $data['entrada'], \PDO::PARAM_STR);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":id_tipo", $data['cliente'], \PDO::PARAM_INT);
			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			$query->bindParam(":id_usuario",$_SESSION['usuario']['id'], \PDO::PARAM_INT);
			return $query->execute();
			//return == true? ha ido bien:No ha ido bien.
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