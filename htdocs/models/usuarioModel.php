<?php
class usuario{
	private $usuario;
	private $contrasena;
	private $nombre;
	private $apellidos;
	private $correo;
	
	public function __contruct($usuario, $contrasena, $nombre, $apellidos, $correo){
		$this->usuario=$usuario;
		$this->contrasena=$contrasena;
		$this->nombre=$nombre;
		$this->apellidos=$apellidos;
		$this->correo=$correo;
	}
	/*public function __contruct(array $user){
		$this->usuario=$user[0];
		$this->contrasena=$user[1];
		$this->nombre=$user[2];
		$this->apellidos=$user[3];
		$this->correo=$user[4];
	}*/
	
	public function getUsuario(){
		return $this->usuario;
	}
	public function setUsuario($usuario){
		$this->usuario=$usuario;
	}
	public function getContrasena(){
		return $this->contrasena;
	}
	public function setcontrasena($contrasena){
		$this->contrasena=$contrasena;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function setnombre($nombre){
		$this->nombre=$nombre;
	}
	public function getApellidos(){
		return $this->apellidos;
	}
	public function setApellidos($apellidos){
		$this->apellidos=$apellidos;
	}
	public function getCorreo(){
		return $this->correo;
	}
	public function setCorreo($correo){
		$this->correo=$correo;
	}
}