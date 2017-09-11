<?php
namespace  App\Models;
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Enviado implements Crud{
	const TABLE = "enviado";
	
	//devuelve todos los elementos de la tabla traspasos, traduciendo las claves foraneas por su respectivo nombre
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT id_entrada FROM ".self::TABLE;
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
	// Devuelve el traspasos corresponiente al id pasado como parametro
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

	// Inserta en la base de datos una nueva linea con los datos pasados
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE." (id_entrada) VALUES( :id_entrada)";
			$query = $connection->prepare($sql);
			$query->bindParam(":id_entrada",$data['id_entrada'], \PDO::PARAM_INT);
			return $query->execute();
			//return == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			//se muestra el error de SQL en caso de dar fallo
			print "Error!: " . $e->getMessage();
		}
	}
	
	// Ejecuta una sentecia en sql de update , se debe de especificar el set y el where en el parametro enviado.
	public static function update($sql){
		try{
			$connection = Database::instance();
			$query = $connection->prepare("UPDATE " . self::TABLE . " " .$sql);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			//se muestra el error de SQL en caso de dar fallo
			print "Error!U: " . $e->getMessage();
			return false;
		}
	}
	
	// Elimina un registro de la tabla Traspasos
	// $id int con el id del registro a eliminar
	public static function delete($id){
		try{
			$connection = Database::instance();
			
			$query = $connection->prepare("DELETE FROM ". self::TABLE . " WHERE id_entrada = $id");
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!D: " . $e->getMessage();
		}
	}
	public static function deleteAll(){
		try{
			$connection = Database::instance();
			
			$query = $connection->prepare("DELETE FROM ". self::TABLE . " WHERE 1");
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
}