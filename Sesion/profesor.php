<?php session_start();

	require 'admin/config.php';
	require 'functions.php';

	// comprobar session
	if (!isset($_SESSION['usuario'])) {
	  header('Location: '.RUTA.'login.php');
	}

	$conexion = conexion($bd_config);
	$profe = iniciarSession('usuarios', $conexion);

	if ($profe['tipo_usuario'] == 'profesor') {
	  // traer el nombre del usuario(profesor)
	  $user = iniciarSession('usuarios', $conexion);


	  require 'views/admin.view.php';
	} else {
	  header('Location: '.RUTA.'index.php');
	}

?>
