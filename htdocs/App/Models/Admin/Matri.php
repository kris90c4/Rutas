<?php
namespace  App\Models\Admin;
// Si se accede directamente al archivo se lanza un mensaje de acceso denegado
defined("APPPATH") OR die("Acceso denegado");

use \Core\Database,
\App\Interfaces\Crud;

class Matri implements Crud{
	const TABLE = "matriculaciones";
	
	//Se devuelve una consulta adecuada a la tabla donde se va a visualizar
	public static function getAll(){
		try {
			//Se declara la instancia que se comunica con la base de datos
			$connection = Database::instance();
			$sql = "SELECT matri.id, matri.entrada, matri.bastidor, matri.matricula, matri.cliente, 
							matri.alta, matri.suplido, matri.exento, p.nombre provincia, m.nombre municipio, matri.salida, u.nombre creador 
						FROM ".self::TABLE . " matri 
						JOIN provincias p ON p.id =  matri.id_provincias 
						JOIN municipios m ON m.id = matri.id_municipios
						LEFT JOIN usuarios u ON u.id = matri.id_usuario OR matri.id_usuario=NULL";
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
	// Inserta en la base de datos los datos pasados por el formualrio de introduccion.
	// $data array asociativo.
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(entrada, bastidor, matricula, cliente, alta, id_provincias, id_municipios, salida, id_usuario, suplido, exento) VALUES(:entrada, :bastidor, :matricula, :cliente, :alta, :provincia, :municipio, :salida, :id_usuario, :suplido, :exento)";
			$query = $connection->prepare($sql);
			//si no se envia la poblacion, se asigna null
			isset($data['salida'])&&!empty($data['salida'])?:$data['salida']=null;
			$query->bindParam(":entrada", $data['entrada'], \PDO::PARAM_STR);
			$query->bindParam(":bastidor", $data['bastidor'], \PDO::PARAM_STR);
			$query->bindParam(":matricula", $data['matricula'], \PDO::PARAM_STR);
			$query->bindParam(":cliente", $data['cliente'], \PDO::PARAM_STR);
			$query->bindParam(":alta", $data['alta'], \PDO::PARAM_STR);
			$query->bindParam(":provincia", $data['provincia'], \PDO::PARAM_INT);
			$query->bindParam(":municipio", $data['municipio'], \PDO::PARAM_INT);
			$query->bindParam(":suplido", $data['suplido']!=""?$data['suplido']:"0", \PDO::PARAM_STR);
			$query->bindParam(":exento", isset($data['exento'])?$data['exento']:"0", \PDO::PARAM_STR);
			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			// Se alamacena en una variable para evitar un mensaje de advertencia del tipo Strict
			$id_user=$_SESSION['usuario']->getId();
			$query->bindParam(":id_usuario",$id_user, \PDO::PARAM_INT);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
			var_export($data);
		}
	}
	
	// Actualización un registro de la tabla matriculaciones
	// $sql String con el set y el where
	public static function update($sql){
		try{
			$connection = Database::instance();
			$query = $connection->prepare("UPDATE ". self::TABLE. " $sql");
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