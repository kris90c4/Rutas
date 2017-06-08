<?php
namespace  App\Models\Admin;
defined("APPPATH") OR die("Access denied");

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
							matri.alta, p.nombre provincia, m.nombre municipio, matri.salida, u.nombre creador 
						FROM ".self::TABLE . " matri 
						JOIN provincias p ON p.id =  matri.id_provincias 
						JOIN municipios m ON m.id = matri.id_municipios
						LEFT JOIN usuarios u ON u.id = matri.id_usuario OR matri.id_usuario=NULL";
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
	public static function insert($data){
		try{
			$connection = Database::instance();
			$sql="INSERT INTO ".self::TABLE."(entrada, bastidor, matricula, cliente, alta, id_provincias, id_municipios, salida, id_usuario) VALUES(:entrada, :bastidor, :matricula, :cliente, :alta, :provincia, :municipio, :salida, :id_usuario)";
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

			$query->bindParam(":salida", $data['salida'], \PDO::PARAM_STR);
			$id_user=$_SESSION['usuario']->getId();
			$query->bindParam(":id_usuario",$id_user, \PDO::PARAM_INT);
			return $query->execute();
			//$ok == true? ha ido bien:No ha ido bien.
		}
		catch(\PDOException $e)
		{
			print "Error!: " . $e->getMessage();
		}
	}
	
	//
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