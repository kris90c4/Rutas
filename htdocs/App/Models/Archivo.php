<?php
namespace  App\Models;
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Archivo implements Crud{
	const TABLE = "archivo ";
	
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
	// Devuelve el traspasos corresponiente al id pasado como parametro
	public static function getById($id){
		try {
			$connection = Database::instance();
			$sql = "SELECT * from ".self::TABLE . " where id = ". $id;
			$query = $connection->prepare($sql);
			$query->execute();
			$query->bindColumn(1, $id);
			$query->bindColumn(2, $nombre);
			$query->bindColumn(3, $tipo, \PDO::PARAM_STR, 256);
        	$query->bindColumn(4, $contenido, \PDO::PARAM_LOB);
        	//$sentencia->bindColumn(1, $tipo, PDO::PARAM_STR, 256);
			//$sentencia->bindColumn(2, $lob, PDO::PARAM_LOB);
			$query->bindColumn(5, $id_tarjeta_transporte);
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
			$sql="INSERT INTO ".self::TABLE." (nombre, tipo, contenido, id_tarjeta_transporte) VALUES( :nombre, :tipo, :contenido, :id_tarjeta_transporte)";
			$query = $connection->prepare($sql);

			$contenido=file_get_contents('uploaded/circulo.jpg');
			$fp = fopen($data['tmp_name'], "rb");
			
			// si no se asigna una fecha de salida, se deja como null
			$query->bindParam(":nombre", $data['name'], \PDO::PARAM_STR);
			$query->bindParam(":tipo", $data['type'], \PDO::PARAM_STR);
			$query->bindParam(":contenido",$fp, \PDO::PARAM_LOB);
			$query->bindParam(":id_tarjeta_transporte", $data['fk'], \PDO::PARAM_INT);
			if($query->execute()){
				fclose($fp);
				return $connection->ultimaId();
			}
			//return == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			//se muestra el error de SQL en caso de dar fallo
			print("Error!: " . $e->getMessage());
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