<?php
namespace App\Models;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
class User
{
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
}