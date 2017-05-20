<?php
namespace App\Controllers;
defined("APPPATH") OR die("Access denied");
use \Core\View,
\App\Models\User as Users,
\Core\Controller;
class Perfil extends Controller
{
	private $id;
	private $nombre;
	private $apellidos;
	private $mail;

	public function index()
	{
		echo __CLASS__;
	}
	public function getId($id)
	{
		echo $id;
	}
	
}