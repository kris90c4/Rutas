<?php
namespace App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
 \App\Interfaces\Crud;

class User implements Crud
{
	
	const TABLA = "usuarios";
	
	public static function getAll()
	{
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE;
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
	
	public static function getById($id)
	{
		try {
			$connection = Database::instance();
			$sql = "SELECT * from usuarios WHERE id = ?";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $id, \PDO::PARAM_INT);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	
	/**Extrae el usuario que coincida en la base de datos
	 *
	 * @param String $mail
	 * @return Array asociativo con usuario encontrado sino, no devuelve nada
	 */
	public static function getByMail($mail)
	{
		try {
			$connection = Database::instance();
			$sql = "SELECT * from usuarios WHERE mail = ?";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $mail, \PDO::PARAM_STR);
			$query->execute();
			$query->setFetchMode(\PDO::FETCH_ASSOC);
			return $query->fetch();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	
	public static function insert($user)
	{
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLA." VALUES(null,?,?,?,?)";
			$query = $connection->prepare($sql);
			$query->bindParam(1, $user['nombre'], \PDO::PARAM_STR);
			$query->bindParam(2, $user['apellidos'], \PDO::PARAM_STR);
			$query->bindParam(3, $user['mail'], \PDO::PARAM_STR);
			$query->bindParam(4, $user['pass'], \PDO::PARAM_STR);
			return $query->execute();
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
		//$ok == true? ha ido bien:No ha ido bien.
	}
	
	public static function update($user)
	{
		
	}
	
	public static function delete($id)
	{
		
	}
}