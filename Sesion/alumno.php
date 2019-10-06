<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  	header('Location: '.RUTA.'login.php');
	}

	$conexion = conexion($bd_config);
	$alum = iniciarSession('usuarios', $conexion);

	if ($alum['tipo_usuario'] == 'alumno') {
	  	// traer el nombre del usuario(alumno)
	  	$user = iniciarSession('usuarios', $conexion);

	  	require 'views/usuario.view.php';
	} else {
	  	header('Location: '.RUTA.'index.php');
}
