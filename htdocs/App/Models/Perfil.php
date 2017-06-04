<?php
class usuario{
	private $usuario;
	private $contrasena;
	private $nombre;
	private $apellidos;
	private $mail;
	private $fechaEntrada;
	private $admin;
	
	public function __construct(){
		if(func_num_args()){
			$user=func_get_arg(0);
			if(is_array($user)){
				$this->id=$user['id'];
				$this->nombre=$user['nombre'];
				$this->apellidos=$user['apellidos'];
				$this->mail=$user['mail'];
				$this->pass=$user['pass'];
				$this->fechaEntrada=date("h:i d-m-Y");
			}
		}
	}
	
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
	public function getFechaEntrada(){
		return $this->fechaEntrada;
	}
	public function getAdmin(){
		return $this->admin;
	}
	public function setAdmin($admin){
		$this->admin=$admin;
	}
}