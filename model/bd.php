<?php
class db{
    const DB_RUTAS = "db_rutas";
    protected $conexion;
    
    function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", DB_RUTAS);;
    }
    function desconectar(){
        $this->conexion->close();
    }
    
    function select($tabla){
        $this->conexion->query($query);
    }
}

?>