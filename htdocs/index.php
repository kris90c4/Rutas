<?php
//directorio del proyecto
define("PROJECTPATH", __DIR__);

//directorio app
define("APPPATH", PROJECTPATH . '/App');
ini_set('date.timezone' , 'Europe/Madrid');
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
session_cache_expire();
//Se inicia la global $_SESSION
session_start();

//Estas constantes sirven para dar y denegar acceso segun si se esta logeado o no
if(isset($_SESSION['usuario'])){
	// Si ya se ha logeado el usaurio se inicializa la constante USUARIO
	define('USUARIO',$_SESSION['usuario']->getAdmin());
}else{//Si no se ha iniciado el usuario se incia la constante INVITADO
	define('INVITADO',"Invitado");
}

//instanciamos la app
$app = new \Core\App;

//lanzamos la app
$app->render();
?>