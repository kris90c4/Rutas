<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");
use \Core\View,
\App\Models\User as Users,
\Core\Controller;
class Perfil
{
	private $id;
	private $nombre;
	private $apellidos;
	private $mail;
	private $pass;

	public function __construct($user){
		if(is_array($user)){
			$this->id=$user['id'];
			$this->nombre=$user['nombre'];
			$this->apellidos=$user['apellidos'];
			$this->mail=$user['mail'];
			$this->pass=$user['pass'];
		}
	}
	public function getId()
	{
		return $this->id;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getApellidos()
	{
		return $this->apellidos;
	}
	public function getMail()
	{
		return $this->mail;
	}
	public function getPass()
	{
		return $this->pass;
	}
	public function setId($id)
	{
		$this->id=$id;
	}
	public function setNombre($nombre)
	{
		$this->nombre=$nombre;
	}
	public function setApellidos($apellidos)
	{
		$this->apellidos=$apellidos;
	}
	public function setMail($mail)
	{
		$this->mail=$mail;
	}
	public function setPass($pass)
	{
		$this->pass=$pass;
	}
	
}