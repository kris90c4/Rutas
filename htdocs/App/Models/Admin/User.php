<?php
namespace App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\Interfaces\Crud;

class User implements Crud
{
	
	const TABLA = "usuarios";
	
	public static function getAll()
	{
		try {
			$connection = Database::instance();
			$sql = "SELECT * from usuarios";
			$query = $connection->prepare($sql);
			$query->execute();
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
			$sql = "SELECT * from usuarios WHERE correo = ?";
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
		$connection = Database::instance();
		$sql="INSERT INTO ".self::TABLA." VALUES(null,?,?,?,?)";
		$query = $connection->prepare($sql);
		$query->bindParam(1, $user['nombre'], \PDO::PARAM_STR);
		$query->bindParam(2, $user['apellidos'], \PDO::PARAM_STR);
		$query->bindParam(3, $user['mail'], \PDO::PARAM_STR);
		$query->bindParam(4, $user['pass'], \PDO::PARAM_STR);
		return $query->execute();
		//$ok == true? ha ido bien:No ha ido bien.
	}
	
	public static function update($user)
	{
		
	}
	
	public static function delete($id)
	{
		
	}
}