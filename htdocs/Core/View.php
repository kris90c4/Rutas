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
		$menu=file_get_contents(self::VIEWS_PATH . "menu." . self::EXTENSION_TEMPLATES);
		ob_start();
		extract(self::$data);
		include(self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES);
		$content = ob_get_contents();
		ob_end_clean();
		$asset="/localhost".$_SERVER['PHP_SELF']."/../../asset/";
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