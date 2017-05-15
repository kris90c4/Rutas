<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

class View
{
	/**
	 * @var
	 */
	protected static $data;
	protected static $title;
	/**
	 * @var
	 */
	const VIEWS_PATH = "../App/views/";
	
	/**
	 * @var
	 */
	const EXTENSION_TEMPLATES = "php";
	
	/**
	 * [render views with data]
	 * @param  [String]  [template name]
	 * @return [html]    [render html]
	 */
	public static function render($template)
	{
		if(!file_exists(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES))
		{
			throw new \Exception("Error: El archivo " . self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES . " no existe", 1);
		}
		//Cargo el menu en la variable $menu
		$menu=file_get_contents(self::VIEWS_PATH . "menu." . self::EXTENSION_TEMPLATES);
		//Se comienza a almacenar en el buffer los datos que salgan por pantalla
		ob_start();
		//Se extraen todos los indices y se convierten en variables
		extract(self::$data);
		//Se incluye la vista que el controlador manda cargar
		include(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);
		//Se guarda todo el contenido del buffer en una variable
		$content = ob_get_contents();
		//Y se limpia el buffer
		ob_end_clean();
		//Obtengo la ruta donde cargar todos los archivos del cliente web
		$asset="/localhost".$_SERVER['PHP_SELF']."/../../asset/";
		//Por ultimo, cargo el marco decorativo donde va a cargarse las vistas que los controladores ejecuten a traves de la variable $content
		include self::VIEWS_PATH."layout/layout.".self::EXTENSION_TEMPLATES;
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