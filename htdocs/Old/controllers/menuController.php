<?php
class menu{
	public $usuario;
	public $fecha_entrada;
	
	function __construct(){
		$this->fecha_entrada=time();
	}
	static function pintar_menu(){
		include "template/menu.php";
	}
}
?>