<?php
	session_start();
	$preguntas = $_GET['preg'];
	$respuestas = $_GET['res'];
	$PreguntasTotales = $preguntas."&&cantidad&&";
	$RespuestasTotales = $respuestas."&&cantidad&&";
	for ($i = 0; $i < $preguntas; $i++)
	{ 
		$nombre = 'Pregunta'.$i;
		$PreguntasTotales .= $i."&&pregunta&&".$_POST[$nombre].'&end&';
		$RespuestasTotales .= $i."&&Pregunta&&";
		for ($j=0; $j < $respuestas; $j++)
		{ 
			$nombreR = 'Respuesta'.$j.$i;
			$RespuestasTotales .= $j."&&respuesta&&".$_POST[$nombreR]."&endResp&";
		}
		$RespuestasTotales .= $_POST['Solucion'.$i].'&&Respuesta&&';
	}
	echo $PreguntasTotales.'<br>';
	echo $RespuestasTotales.'<br>';
	$Nombre = $_POST['Nombre'];
	$Tema =  $_POST['Tema'];
	$Descripcion  = $_POST['descripcion'];
	$fecha_hora_actual = date('Y-m-d H:i:s'); 

	$server = "localhost";
	$bd_name = "Repositorio";
	$Usuario  = $_SESSION['usuario'];
	$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
	$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
	$Consulta = "SELECT idUsuario,tipo_usuario FROM Usuario WHERE user = '$Usuario'";
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);
	$Id_usuario = $temp['idUsuario'];
	$tipo = $temp['tipo_usuario'];

	$Consulta = "SELECT idArchivo FROM Archivo ORDER BY idArchivo DESC LIMIT 1";
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);
	$idA = $temp['idArchivo'];
	$idA++;

	if($Nombre == NULL)
		echo "No hay nombre";
	else if($Descripcion == NULL)
		echo "No hay descripcion";
	else
	{
		switch ($tipo)
		{
			case 'profesor':
				$Consulta = "INSERT INTO Archivo(idArchivo,Nombre,Descripcion,Fecha,Calificacion,Autor,Tema,Profesor_Usuario_idUsuario,Ruta,Tam)VALUES('$idA','$Nombre','$Descripcion','$fecha_hora_actual','0','$Usuario','$Tema','$Id_usuario','$Usuario $Tema','0')";
			break;
			case 'coordinador':
				$Consulta = "INSERT INTO Archivo(idArchivo,Nombre,Descripcion,Fecha,Calificacion,Autor,Tema,Coordinador_Usuario_idUsuario,Ruta,Tam)VALUES('$idA','$Nombre','$Descripcion','$fecha_hora_actual','0','$Usuario','$Tema','$Id_usuario','$Usuario $Tema','0')";
			break;
		}
		$resultado = mysqli_query($conect, $Consulta);
		$Consulta = "INSERT INTO Cuestionario(Archivo_idArchivo,Preguntas,Respuestas)VALUES('$idA','$PreguntasTotales','$RespuestasTotales')";
		$resultado = mysqli_query($conect, $Consulta);
		header("location: ../Principal/index.php");
	}
?>
