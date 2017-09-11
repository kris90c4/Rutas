<?php
namespace  App\Models;
// Si se accede directamente al archivo se lanza un mensaje de acceso denegado
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Entrada implements Crud{
	const TABLE = "entrada";
	
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
	// Inserta en la base de datos los datos pasados por el formualrio de introduccion.
	// $data array asociativo.
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(matricula, nombre, mail, telefono, nombre2, mail2, telefono2, entrada) VALUES(:matricula, :nombre, :mail, :telefono, :nombre2, :mail2, :telefono2, :entrada)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			//isset($data['mail'])&&!empty($data['mail'])?:$data['mail']=null;
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":nombre", $data['vendedor'], \PDO::PARAM_STR);
			$query->bindParam(":mail", $data['vMail'], \PDO::PARAM_STR);
			$query->bindParam(":telefono", $data['vTlf'], \PDO::PARAM_INT);
			$query->bindParam(":nombre2", $data['comprador'], \PDO::PARAM_STR);
			$query->bindParam(":mail2", $data['cMail'], \PDO::PARAM_STR);
			$query->bindParam(":telefono2", $data['cTlf'], \PDO::PARAM_INT);
			$query->bindParam(":entrada", date("Y-m-d H:i:s"), \PDO::PARAM_STR);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			ob_start();
			print "Error!: " . $e->getMessage();
			echo "\n$sql\n";
			var_export($data);
			$error= ob_get_contents();
			ob_end_clean();
			ob_start();

			return $error;
		}
	}
	
	// Actualización un registro de la tabla matriculaciones
	// $sql String con el set y el where
	public static function update($data){
		try{
			$connection = Database::instance();
			$sql = "UPDATE ". self::TABLE. " SET matricula = :matricula, nombre = :nombre, mail = :mail, telefono = :telefono, nombre2 = :nombre2, mail2 = :mail2, telefono2 = :telefono2  where id = :id";
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":nombre", $data['vendedor'], \PDO::PARAM_STR);
			$query->bindParam(":mail", $data['vMail'], \PDO::PARAM_STR);
			$query->bindParam(":telefono", $data['vTlf'], \PDO::PARAM_INT);
			$query->bindParam(":nombre2", $data['comprador'], \PDO::PARAM_STR);
			$query->bindParam(":mail2", $data['cMail'], \PDO::PARAM_STR);
			$query->bindParam(":telefono2", $data['cTlf'], \PDO::PARAM_INT);

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