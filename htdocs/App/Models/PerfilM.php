<?php
namespace App\Models;

defined("APPPATH") OR die("Access denied");

class PerfilM{
	private $id;
	private $nombre;
	private $apellidos;
	private $mail;
	private $pass;
	private $admin;
	private $fechaEntrada;
	
	//Si se le pasa un array con todas las columnas de la tabla, se crea automaticamente el objeto,
	//Sino hay que rellenarlo manualmente.
	public function __construct(){
		if(func_num_args()){
			$user=func_get_arg(0);
			if(is_array($user)){
				$this->id=$user['id'];
				$this->nombre=$user['nombre'];
				$this->apellidos=$user['apellidos'];
				$this->mail=$user['mail'];
				$this->pass=$user['pass'];
				$this->admin=$user['admin'];
				$this->fechaRegistro=$user['fechaRegistro'];
				$this->fechaEntrada=$user['fechaEntrada'];
			}
		}
	}
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	public function getApellidos(){
		return $this->apellidos;
	}
	public function setApellidos($apellidos){
		$this->apellidos=$apellidos;
	}
	public function getMail(){
		return $this->mail;
	}
	public function setMail($mail){
		$this->mail=$mail;
	}
	public function getPass(){
		return $this->pass;
	}
	public function setPass($pass){
		$this->pass=$pass;
	}
	public function getAdmin(){
		return $this->admin;
	}
	public function setAdmin($admin){
		$this->admin=$admin;
	}
	public function getFechaRegistro(){
		return $this->fechaRegistro;
	}
	public function getFechaEntrada(){
		return $this->fechaEntrada;
	}
}