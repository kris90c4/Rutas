<?php
namespace  App\Models;
// Si se accede directamente al archivo se lanza un mensaje de acceso denegado
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Tarjeta_transporte implements Crud{
	const TABLE = "tarjeta_transporte";
	
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
	public static function getView(){
		try {
			//Se declara la instancia que se comunica con la base de datos
			$connection = Database::instance();
			$sql = "SELECT * FROM vistaTarjetaTransporte";
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
	public static function getLastId2(){
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
	public static function getLastId(){
		try {
			$connection = Database::instance();
			$sql = "SELECT LAST_INSERT_ID()";
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
	// Inserta en la base de datos los datos pasados por el formualrio de introduccion.
	// $data array asociativo.
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(matricula, id_cliente, fecha_vencimiento, id_usuario) VALUES(:matricula, :id_cliente, :fecha_vencimiento, :id_usuario)";
			$query = $connection->prepare($sql);
			//isset($data['mail'])&&!empty($data['mail'])?:$data['mail']=null;
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":id_cliente", $data['id_cliente'], \PDO::PARAM_INT);
			$valido_hasta=!empty($data['fecha_vencimiento'])?$data['fecha_vencimiento']:null;
			$query->bindParam(":fecha_vencimiento", $valido_hasta, \PDO::PARAM_STR);
			$query->bindParam(":id_usuario", $data['id_usuario'], \PDO::PARAM_INT);
			
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
			$sql = "UPDATE ". self::TABLE. " SET matricula = :matricula, id_cliente = :id_cliente, fecha_vencimiento = :fecha_vencimiento where id = :id";
			$query = $connection->prepare($sql);
			$query->bindParam(":id", $data['id'], \PDO::PARAM_INT);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":id_cliente", $data['id_cliente'], \PDO::PARAM_INT);
			$valido_hasta=!empty($data['fecha_vencimiento'])?$data['fecha_vencimiento']:null;
			$query->bindParam(":fecha_vencimiento", $valido_hasta, \PDO::PARAM_STR);

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