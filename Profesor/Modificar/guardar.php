<?php 

	session_start();

	$Descripcion = $_POST['descripcion'];
	$Nombre = trim($_POST['Nombre']); 
	$Tema = $_POST['Tema'];
	$id = $_GET['id'];

	$server = "localhost";
	$bd_name = "Repositorio";
	$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
	$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
	$Consulta = "SELECT Nombre,Descripcion,Tema FROM Archivo WHERE idArchivo = '$id'"; 
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);
	$DescripcionAntigua = $temp['Descripcion'];
	$NombreAntiguo = $temp['Nombre'];
	$TemaAntiguo = $temp['Tema'];

	$server = "localhost";
	$bd_name = "Repositorio";
	$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
	$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
	if($Nombre != NULL)
	{	
		$Consulta = "UPDATE Archivo SET Nombre = '$Nombre' WHERE idArchivo = '$id'";
		$resultado = mysqli_query($conect, $Consulta);
	}
	if($Descripcion != NULL)
	{
		$Consulta = "UPDATE Archivo SET Descripcion = '$Descripcion' WHERE idArchivo = '$id'";
		$resultado = mysqli_query($conect, $Consulta);
	}
	if($Tema != NULL)
	{
		$Consulta = "UPDATE Archivo SET Tema = '$Tema' WHERE idArchivo = '$id'";
		$resultado = mysqli_query($conect, $Consulta);
	}
	header("location: ../Principal/index.php");
?>