<?php
	session_start();
	if(!isset($_SESSION['user']))
	{
		session_start();
		session_destroy();
		header('location: ../login/index.php?error=2');
	}
	else
	{
		$id = $_GET['id'];
		$server = "localhost";
		$bd_name = "Repositorio";
		$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
		$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
		$Usuario  = $_SESSION['user'];
		$Consulta = "SELECT Nombre,Autor,Descripcion,Tema,Calificacion,Ruta FROM Archivo WHERE idArchivo = '$id'"; 
		$resultado = mysqli_query($conect, $Consulta);
		$temp = mysqli_fetch_assoc($resultado);
		echo $temp['Nombre']."<br>";
		echo $temp['Autor']."<br>";
		echo $temp['Tema']."<br>";
		echo $temp['Descripcion']."<br>";
		echo $temp['Calificacion']."<br>";
		echo $temp['Ruta']."<br>";
	}
 ?>