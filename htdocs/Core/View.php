<?php
namespace Core;

defined("APPPATH") OR die("Acceso denegado");

class View
{
	/**
	 * @var
	 */
	protected static $data=[];
	protected static $title="404";
	/**
	 * @var
	 */
	const VIEWS_PATH = "App/Views/";
	
	/**
	 * @var
	 */
	const EXTENSION_TEMPLATES = "php";
	
	/**
	 * [render views with data]
	 * @param  [String]  [template name]
	 * @return [html]    [render html]
	 */
	//En caso de enviar el segundo parametro en false, solo se accede a la vista sin el layout.
	public static function render($template,$full=true)
	{
		if(!file_exists(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES))
		{
			throw new \Exception("Error: El archivo " . self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES . " no existe", 1);
		}
		extract(self::$data);
		if($full==true){
			//Si se entra desde la url externa, se elimina el menu
			if($_SERVER["SERVER_NAME"]=="portol.ddns.net" || $_SERVER["SERVER_NAME"]=="portolestadisticas.ddns.net"){
				$menu="";
			}else{
				ob_start();
				//Cargo el menu en la variable $menu
				include_once self::VIEWS_PATH . "menu." . self::EXTENSION_TEMPLATES;
				$menu= ob_get_contents();
				
				ob_end_clean();
				
			}
			//Se comienza a almacenar en el buffer los datos que salgan por pantalla
			ob_start();
			//Se extraen todos los indices y se convierten en variables
			if(!isset($title)){
				$title=self::$title;
			}
			/*if(isset($_SESSION['usuario'])&&$template=="login"||$template=="registrar"){
				$template="home";
			}*/
			//Se incluye la vista que el controlador manda cargar
			include_once(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);
			//Se guarda todo el contenido del buffer en una variable
			$content = ob_get_contents();
			//Y se limpia el buffer
			ob_end_clean();
			
			//Obtengo la ruta donde cargar todos los archivos del cliente web
			define("ASSET",$_SERVER['HTTP_HOST']."/../asset/");
			//Por ultimo, cargo el marco decorativo donde va a cargarse las vistas que los controladores ejecuten a traves de la variable $content
			include_once self::VIEWS_PATH."layout/layout.".self::EXTENSION_TEMPLATES;
		}else{
			include_once(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);
		}
	}
	
	/**
	 * [set Set Data form views]
	 * @param [string] $name  [key]
	 * @param [mixed] $value [value]
	 */
	public static function set($name, $value)
	{
		self::$data[$name] = $value;
	}
}