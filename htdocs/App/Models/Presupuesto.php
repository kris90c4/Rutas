<?php
namespace  App\Models;
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Presupuesto implements Crud{
	const TABLE = "presupuesto ";
	
	//devuelve todos los elementos de la tabla traspasos, traduciendo las claves foraneas por su respectivo nombre
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT * FROM ".self::TABLE;
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
	//Se obtiene una fila determiada segun su id y se devuelve
	// $id int
	public static function getById($id){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE . " where id = ". $id;
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

	// Inserta en la base de datos una nueva linea con los datos pasados
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE." (matricula, marca, modelo, cilindrada, bastidor, fecha_matriculacion, cvf, base_imponible, tipo_gravamen, cuota, tipo, id_usuario) VALUES( :matricula, :marca, :modelo, :cilindrada, :bastidor, :fecha_matriculacion, :cvf, :base_imponible, :tipo_gravamen, :cuota, :tipo, :id_usuario)";
			$query = $connection->prepare($sql);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":marca", $data['marca'], \PDO::PARAM_STR);
			$query->bindParam(":modelo", $data['modelo'], \PDO::PARAM_STR);
			$query->bindParam(":cilindrada", $data['cilindrada'], \PDO::PARAM_STR);
			$query->bindParam(":bastidor", $data['bastidor'], \PDO::PARAM_STR);
			$query->bindParam(":fecha_matriculacion", $data['fecha_matriculacion'], \PDO::PARAM_STR);
			$query->bindParam(":cvf", $data['cvf'], \PDO::PARAM_STR);
			$query->bindParam(":base_imponible", $data['base_imponible'], \PDO::PARAM_STR);
			$query->bindParam(":tipo_gravamen", $data['tipo_gravamen'], \PDO::PARAM_STR);
			$query->bindParam(":cuota", $data['cuota'], \PDO::PARAM_INT);
			$query->bindParam(":tipo", $data['tipo'], \PDO::PARAM_STR);
			$query->bindParam(":id_usuario", $data['id_usuario'], \PDO::PARAM_INT);

			if($query->execute()){
				return $connection->ultimaId();
			}
			//return == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			//se muestra el error de SQL en caso de dar fallo
			throw $e;
		}
	}
	
	// Ejecuta una sentecia en sql de update , se debe de especificar el set y el where en el parametro enviado.
	public static function update($sql){
		try{
			$connection = Database::instance();
			$query = $connection->prepare("UPDATE " . self::TABLE . " $sql");
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			//se muestra el error de SQL en caso de dar fallo
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
	
	// Elimina un registro de la tabla Traspasos
	// $id int con el id del registro a eliminar
	public static function delete($id){
		try{
			$connection = Database::instance();
			
			$query = $connection->prepare("DELETE FROM ". self::TABLE . " WHERE id = $id");
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
}