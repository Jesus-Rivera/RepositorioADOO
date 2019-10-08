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
	$idUser = $temp['idUsuario'];
	$fecha_hora_actual = date('Y-m-d H:i:s');
	$Consulta = "SELECT * FROM Archivo_Guardado WHERE Archivo_idArchivo = $id AND Usuario_idUsuario = $idUser";
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);
	if(!$temp)
	{
		$Consulta = "INSERT INTO Archivo_Guardado(Archivo_idArchivo,Usuario_idUsuario,Fecha_guardado)VALUES($id,$idUser,'$fecha_hora_actual')";
		$resultado = mysqli_query($conect, $Consulta);
	}
	header('location: ../Archivos/index.php')
?>