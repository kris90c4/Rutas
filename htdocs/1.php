<?php

try{
	throw new Exception("Error en la consulta");    
}catch(Exception $e){ 
	echo "HOLA"; 
}

?>