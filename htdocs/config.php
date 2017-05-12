<?php

if(isset($_POST['login'])){
	$bd=new bd();
	$usuario=$bd->select('usuarios where usuario="'.$_POST['usuario'].'"');
	if ($row=$usuario->fetch_row()) {
		$log= new usuario();
		$log->setUsuario($row[0]);
		$log->setNombre($row[2]);
		$log->setApellidos($row[3]);
		$log->setCorreo($row[4]);
		$_SESSION['usuario']=$log;
		header("location: .");
	}
}