<?php
	session_start();
	$id = $_GET['id'];
	$server = "localhost";
	$bd_name = "Repositorio";
	$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
	$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
	$Usuario  = $_SESSION['usuario'];
	$Consulta = "SELECT idUsuario FROM Usuario WHERE user = '$Usuario'"; 
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);
	$id_user = $temp['idUsuario'];
	$Consulta = "DELETE FROM Archivo_Guardado WHERE Archivo_idArchivo = $id AND Usuario_idUsuario = $id_user"; 
	$resultado = mysqli_query($conect, $Consulta);
	header('location: index.php');
?>