<?php
//directorio del proyecto
define("PROJECTPATH", __DIR__);

//directorio app
define("APPPATH", PROJECTPATH . '/App');

//autoload con namespaces
function autoload_classes($class_name)
{
	$filename = PROJECTPATH . '/' . str_replace('\\', '/', $class_name) .'.php';
	if(is_file($filename))
	{
		include_once $filename;
	}
}
//registramos el autoload autoload_classes
spl_autoload_register('autoload_classes');

// Con esa sencilla función, todos los archivos que estén dentro del proyecto y cualquier directorio serán autocargados para poder utilizarlos donde necesitemos, y lo más importante, utilizando namespaces.

//Se inicia la global $_SESSION
session_start();
if(isset($_SESSION['usuario'])){
	define('USUARIO',$_SESSION['usuario']->getAdmin());
}

//instanciamos la app
$app = new \Core\App;

//lanzamos la app
$app->render();
?>