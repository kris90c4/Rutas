<?php
class bd{
	const DB_RUTAS = "gestoria";
	protected $conexion;
	
	function __construct() {
		$this->conexion = new mysqli("localhost", "root", "", self::DB_RUTAS);;
	}
	function desconectar(){
		$this->conexion->close();
	}
	
	function select($tabla){
		return $query=$this->conexion->query("select * from " . $tabla);
	}
}

?>