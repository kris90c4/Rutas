<?php
namespace App\Models;
defined("APPPATH") OR die("Acceso denegado");
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
	/**
	 * Busca en la base de datos el usuario que coincida con el id pasado
	 *
	 * @param int $id
	 * @return Array asociativo con usuario encontrado sino, no devuelve nada
	 */
	
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
	/**
	 * Extrae el usuario que coincida  en la base de datos
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
}