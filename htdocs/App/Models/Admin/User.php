<?php
namespace App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
 \App\Interfaces\Crud;

class User implements Crud{
	
	const TABLE = "usuarios";
	
	//Devuelve un array con todos los usaurios de la base de datos
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE;
			$query = $connection->prepare($sql);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetchAll();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}

	//Obtiene el registro de la base de datos corresponiente a su id
	// Devuelve un array asociativo
	
	public static function getById($id){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE." WHERE id = ?";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $id, \PDO::PARAM_INT);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}
	
	/**Extrae el usuario que coincida en la base de datos
	 *
	 * @param String $mail
	 * @return Array asociativo con usuario encontrado sino, no devuelve nada
	 */
	public static function getByMail($mail){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE." WHERE mail = ?";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $mail, \PDO::PARAM_STR);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
	}

	// $user  array con los datos del formulario de registro
	
	public static function insert($user){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(nombre, apellidos, mail, pass) VALUES(?,?,?,?)";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $user['nombre'], \PDO::PARAM_STR);
			$query->bindParam(2, $user['apellidos'], \PDO::PARAM_STR);
			$query->bindParam(3, $user['mail'], \PDO::PARAM_STR);
			$query->bindParam(4, $user['pass'], \PDO::PARAM_STR);
			return $query->execute();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
		}
		//$ok == true? ha ido bien:No ha ido bien.
	}
	//Se le pasa el set y el where
	public static function update($sql){
		try{
			$connection = Database::instance();
			$query = $connection->prepare("UPDATE ".self::TABLE. " $sql");
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	// $id = id del usuario que se desea eliminar
	
	public static function delete($id){
		try{
			$connection = Database::instance();
			$sql="DELETE FROM ".self::TABLE. " WHERE id = $id";
			$query = $connection->prepare($sql);
			return $query->execute();
		}
		catch(\PDOException $e){
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
}