<?php
namespace Core;
defined("APPPATH") OR die("Acceso denegado");


class App{

	private $_controller;

	private $_method = "view";

	private $_params = [];

	private $access;



	const NAMESPACE_CONTROLLERS = "\App\Controllers\\";

	const CONTROLLERS_PATH = "App/Controllers/";

	public function __construct(){

		$this->access=$_SERVER["SERVER_NAME"]=="portol.ddns.net"?"ext":"int";

		
		//comprobamos que exista el archivo en el directorio controllers
		if(file_exists(self::CONTROLLERS_PATH.ucfirst(isset($_GET['controller'])?$_GET['controller']:"Home"). ".php")){
			//nombre del archivo a llamar
			$this->_controller = ucfirst(isset($_GET['controller'])?$_GET['controller']:"Home");
		}else{
			exit(self::CONTROLLERS_PATH.ucfirst(isset($_GET['controller'])?$_GET['controller']:"Home"). ".php");
			//Si el controlador no existe se se redir
			$this->_controller = "Home";
		}
		
		//obtenemos la clase con su espacio de nombres
		$fullClass = self::NAMESPACE_CONTROLLERS.$this->_controller;
		
		//asociamos la instancia a $this->_controller
		$this->_controller = new $fullClass;
		
		//si existe el segundo segmento comprobamos que el método exista en esa clase
		if(isset($_GET['action'])?$_GET['action']:""){
			//aquí tenemos el método
			$this->_method = $_GET['action'];
			if(!method_exists($this->_controller, $_GET['action']))	{
				$fullClass = self::NAMESPACE_CONTROLLERS."Home";
				$this->_controller = new $fullClass;
				$this->_method="error404";
			}
		}

		//Se comprueba si existen parametros pasado por get, en caso de existir, se almacenan en un array separados por sus comas, sino se almacena un array vacio
		if(isset($_GET['parametros'])){
			$parametros=explode(",", $_GET['parametros']);
			$this->_params = array_values($parametros);
		}else{
			$this->_params = [];
		}
	}
	
	/**
	 * [render  lanzamos el controlador/método que se ha llamado con los parámetros]
	 */
	public function render(){
		if($this->access=="ext"){
			$controller=self::NAMESPACE_CONTROLLERS."Tramites";
			$controller=new $controller;
			define("ACCESS","ext");
			if(isset($_GET['url'])){
				$url=explode(",", $_GET['url']);
				$this->_params = array_values($url);
			}else{
				$this->_params = [];
			}
			call_user_func_array([$controller, "estado"],  $this->_params);
		}else{
			call_user_func_array([$this->_controller, $this->_method], $this->_params);
		}
	}
	
	/**
	 * [getConfig Obtenemos la configuración de la app]
	 * @return [Array] [Array con la config]
	 */
	public static function getConfig(){
		return parse_ini_file(APPPATH . '/Config/config.ini');
	}
	
	/**
	 * [getController Devolvemos el controlador actual]
	 * @return [type] [String]
	 */
	public function getController(){
		return $this->_controller;
	}
	
	/**
	 * [getMethod Devolvemos el método actual]
	 * @return [type] [String]
	 */
	public function getMethod(){
		return $this->_method;
	}
	
	/**
	 * [getParams description]
	 * @return [type] [Array]
	 */
	public function getParams(){
		return $this->_params;
	}
}