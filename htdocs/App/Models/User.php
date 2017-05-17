<?php
namespace App\Models;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
class User
{
	/**
	 * Obtiene una lista de todos los usuarios
	 * 
	 * @return Array con todos los usuarios de la base de datos
	 */
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
	//De momento no se usa
	public static function getUser($mail)
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
}