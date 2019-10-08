<?php
	session_start();
	if(!isset($_SESSION['usuario']))
	{
		session_start();
		session_destroy();
		header('location: ../Sesion/index.php');
	}
	else
	{
		header('Location: Principal/index.php');
	}
?>