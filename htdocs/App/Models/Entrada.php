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
	public static function getView(){
		try {
			//Se declara la instancia que se comunica con la base de datos
			$connection = Database::instance();
			$sql = "SELECT * FROM vistaentrada";
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
			$sql="INSERT INTO ".self::TABLE."(matricula, base_imponible, tipo_de_gravamen, id_vendedor, id_compraventa, id_comprador, id_tipo, provision, cobrado, id_usuario, correo_ordinario, tiempo) VALUES(:matricula, :base_imponible, :tipo_de_gravamen, :id_vendedor, :id_compraventa, :id_comprador, :id_tipo, :provision, :cobrado, :id_usuario, :correo_ordinario, :tiempo)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			//isset($data['mail'])&&!empty($data['mail'])?:$data['mail']=null;
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":base_imponible", $data['base_imponible'], \PDO::PARAM_INT);
			$query->bindParam(":tipo_de_gravamen", $data['tipo_de_gravamen'], \PDO::PARAM_INT);
			$query->bindParam(":id_vendedor", $data['id_vendedor'], \PDO::PARAM_INT);
			$query->bindParam(":id_compraventa", $data['id_compraventa'], \PDO::PARAM_INT);
			$query->bindParam(":id_comprador", $data['id_comprador'], \PDO::PARAM_INT);
			$query->bindParam(":id_tipo", $data['id_tipo'], \PDO::PARAM_INT);
			$query->bindParam(":provision", $data['provision'], \PDO::PARAM_STR);
			$query->bindParam(":cobrado", $data['cobrado'], \PDO::PARAM_STR);
			$query->bindParam(":id_usuario", $data['id_usuario'], \PDO::PARAM_INT);
			$query->bindParam(":correo_ordinario", $data['correo_ordinario'], \PDO::PARAM_INT);
			$query->bindParam(":tiempo", $data['tiempo'], \PDO::PARAM_STR);
			
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
			$sql = "UPDATE ". self::TABLE. " SET matricula = :matricula, base_imponible = :base_imponible, tipo_de_gravamen = :tipo_de_gravamen, id_vendedor = :id_vendedor, id_compraventa = :id_compraventa, id_comprador = :id_comprador, id_tipo = :id_tipo, id_usuario = :id_usuario, correo_ordinario = :correo_ordinario where id = :id";
			$query = $connection->prepare($sql);
			$query->bindParam(":id", $data['id'], \PDO::PARAM_INT);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":base_imponible", $data['base_imponible'], \PDO::PARAM_INT);
			$query->bindParam(":tipo_de_gravamen", $data['tipo_de_gravamen'], \PDO::PARAM_INT);
			$query->bindParam(":id_vendedor", $data['id_vendedor'], \PDO::PARAM_INT);
			$query->bindParam(":id_compraventa", $data['id_compraventa'], \PDO::PARAM_INT);
			$query->bindParam(":id_comprador", $data['id_comprador'], \PDO::PARAM_INT);
			$query->bindParam(":id_tipo", $data['id_tipo'], \PDO::PARAM_INT);
			/*$query->bindParam(":provision", $data['provision'], \PDO::PARAM_STR);
			$query->bindParam(":cobrado", $data['cobrado'], \PDO::PARAM_STR);*/
			$query->bindParam(":id_usuario", $data['id_usuario'], \PDO::PARAM_INT);
			$query->bindParam(":correo_ordinario", $data['correo_ordinario'], \PDO::PARAM_INT);

			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function updateSalida(){
		try{
			$connection = Database::instance();
			$sql = "UPDATE entrada SET entrada.fecha_salida = (SELECT CURRENT_TIMESTAMP) where entrada.id = (select enviado.id_entrada from enviado where enviado.id_entrada= entrada.id)";
			$query = $connection->prepare($sql);

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