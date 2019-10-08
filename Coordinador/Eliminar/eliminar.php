<?php
	$id = $_GET['id'];
	$server = "localhost";
	$bd_name = "Repositorio";
	$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
	$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
	$Consulta = "DELETE FROM Archivo WHERE idArchivo = $id";
	$resultado = mysqli_query($conect, $Consulta);
	if($resultado)
		header('location: index.php?ver=1');
?>