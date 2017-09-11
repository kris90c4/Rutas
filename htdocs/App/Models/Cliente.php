<?php
namespace  App\Models;
// Si se accede directamente al archivo se lanza un mensaje de acceso denegado
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Cliente implements Crud{
	const TABLE = "cliente";
	
	//Se devuelve una consulta adecuada a la tabla donde se va a visualizar
	public static function getAll(){
		try {
			//Se declara la instancia que se comunica con la base de datos
			$connection = Database::instance();
			$sql = "SELECT * FROM ".self::TABLE;
			// Se preapara la sentencia SQL
			$query = $connection->prepare($sql);
			//Se ejecuta la sentencia
			$query->execute();
			//se elige como se devolvera el resultado
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			//Se devuelven todos las filas dentro de un array
			return $query->fetchAll();
		}
		catch(\PDOException $e)
		{//En caso de error se imprime
			print "Error!: " . $e->getMessage();
		}
	}
	public static function getLastId(){
		try {
			//Se declara la instancia que se comunica con la base de datos
			$connection = Database::instance();
			$sql = "SELECT * FROM ".self::TABLE. " ORDER BY ID DESC LIMIT 1";
			// Se preapara la sentencia SQL
			$query = $connection->prepare($sql);
			//Se ejecuta la sentencia
			$query->execute();
			//se elige como se devolvera el resultado
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			//Se devuelven todos las filas dentro de un array
			
			$cliente=$query->fetch();
			return $cliente["id"]+1;
		}
		catch(\PDOException $e)
		{//En caso de error se imprime
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
	public static function getByName($cv){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE . " where nombre LIKE '%". $cv."%'";
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetchAll();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			var_export($sql);
		}
	}
	public static function getBytlf($tlf){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE . " where telefono LIKE '" . $tlf . "'";
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			var_export($sql);
		}
	}
	// Inserta en la base de datos los datos pasados por el formualrio de introduccion.
	// $data array asociativo.
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(nombre, mail, telefono) VALUES(:nombre, :mail, :telefono)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			//isset($data['mail'])&&!empty($data['mail'])?:$data['mail']=null;
			$query->bindParam(":mail", $data['mail'], \PDO::PARAM_STR);
			$query->bindParam(":nombre", $data['nombre'], \PDO::PARAM_STR);
			$query->bindParam(":telefono", $data['telefono'], \PDO::PARAM_INT);
			
			if($query->execute()){
				return $connection->ultimaId();
			}
			return false;

			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			var_export($data);
		}
	}
	
	// Actualización un registro de la tabla matriculaciones
	// $sql String con el set y el where
	public static function update($data){
		try{
			$connection = Database::instance();
			$sql = "UPDATE ". self::TABLE. " SET nombre = :nombre, mail = :mail, telefono = :telefono where id = :id";
			$query = $connection->prepare($sql);
			$query->bindParam(":id", $data['id'], \PDO::PARAM_INT);
			$query->bindParam(":mail", $data['mail'], \PDO::PARAM_STR);
			$query->bindParam(":nombre", $data['nombre'], \PDO::PARAM_STR);
			$query->bindParam(":telefono", $data['telefono'], \PDO::PARAM_INT);

			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
	public static function updateManual($data){
		try{
			$connection = Database::instance();
			$sql = "UPDATE ". self::TABLE . " " . $data;
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
	public static function update2($data){
		try{
			$connection = Database::instance();
			$sql = "UPDATE ". self::TABLE. " SET nombre = :nombre, mail = :mail where telefono = :telefono";
			$query = $connection->prepare($sql);
			$query->bindParam(":mail", $data['mail'], \PDO::PARAM_STR);
			$query->bindParam(":nombre", $data['nombre'], \PDO::PARAM_STR);
			$query->bindParam(":telefono", $data['telefono'], \PDO::PARAM_INT);

			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
	
	// Elimina un registro de la tabla matriculaciones
	// $id int con el id del registro a eliminar
	public static function delete($id){
		try{
			$connection = Database::instance();
			$sql="DELETE FROM ". self::TABLE . " WHERE id = $id";
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