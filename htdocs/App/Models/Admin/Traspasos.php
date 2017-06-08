<?php
namespace  App\Models\Admin;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
\App\Interfaces\Crud;

class Traspasos implements Crud{
	const TABLE = "traspasos";
	
	//devuelve todos los elementos de la tabla traspasos, traduciendo las claves foraneas por su respectivo nombre
	public static function getAll(){
		try {
			$connection = Database::instance();
			$sql = "SELECT traspasos.id, traspasos.entrada, traspasos.matricula, traspasos.cliente, tipos.nombre tipo,
							traspasos.salida, usuarios.nombre creador
						FROM ".self::TABLE . " 
						JOIN tipos  ON tipos.id =  traspasos.id_tipo
						JOIN usuarios  ON usuarios.id = traspasos.id_usuario";
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
			$sql="INSERT INTO ".self::TABLE." VALUES(null, :entrada, :matricula, :cliente, :id_tipo, :salida, :id_usuario)";
			$query = $connection->prepare($sql);
			// si no se asigna una fecha de salida, se deja como null
			isset($data['salida'])&&!empty($data['salida'])?:$data['salida']=null;
			$query->bindParam(":entrada", $data['entrada'], \PDO::PARAM_STR);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":cliente", $data['cliente'], \PDO::PARAM_STR);
			$query->bindParam(":id_tipo", $data['tipo'], \PDO::PARAM_INT);
			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			$id_user=$_SESSION['usuario']->getId();
			$query->bindParam(":id_usuario",$id_user, \PDO::PARAM_INT);
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
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
	
	//pendiente de query
	public static function delete($id){
		try{
			$connection = Database::instance();
			
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