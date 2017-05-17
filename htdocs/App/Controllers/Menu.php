<?php
class Menu{
	public $usuario;
	public $fecha_entrada;
	
	function __construct(){
		$this->fecha_entrada=time();
	}
	public static function pintar_menu(){
		include "template/menu.php";
	}
}
?>