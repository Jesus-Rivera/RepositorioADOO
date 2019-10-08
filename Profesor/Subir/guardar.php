<?php 

	session_start();
	$tipo_archivo = $_FILES['archivo']['type'];
	$tam_archivo = $_FILES['archivo']['size'];
	$url = ""; 

	$Descripcion = $_POST['descripcion'];
	$Nombre = trim($_POST['Nombre']);
	$fecha_hora_actual = date('Y-m-d H:i:s'); 
	$Usuario  = trim($_SESSION['usuario']);
	$Tema = $_POST['Tema'];


	$server = "localhost";
	$bd_name = "Repositorio";
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
		if($_FILES['archivo']['error'] > 0)
		{
			echo "Error";
		}
		else
		{
			if ($tipo_archivo == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
			{ 
				$url = "../../Documentos/Documentos/Office/".$Nombre."_?".$Usuario.".pptx";
				$tipo_archivo = ".pptx";
			}
			else if ($tipo_archivo == "application/vnd.ms-powerpoint")
			{
				$url = "../../Documentos/Documentos/Office/".$Nombre."_?".$Usuario.".ppt";
				$tipo_archivo = ".ppt";
			}
			else if ($tipo_archivo == "application/msword")
			{
				$url = "../../Documentos/Documentos/Office/".$Nombre."_?".$Usuario.".doc";
				$tipo_archivo = ".doc";
			}
			else if ($tipo_archivo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
			{
				$url = "../../Documentos/Documentos/Office/".$Nombre."_?".$Usuario.".docx";
				$tipo_archivo = ".docx";
			}
			else if($tipo_archivo == "application/pdf")
			{
				$url = "../../Documentos/Documentos/Pdf/".$Nombre."_*?".$Usuario.".pdf";
				$tipo_archivo = ".pdf";
			}

			switch ($tipo)
			{
				case 'profesor':
					$Consulta = "INSERT INTO Archivo(idArchivo,Nombre,Ruta,Descripcion,Fecha,Calificacion,Tam,Autor,Tema,Profesor_Usuario_idUsuario)VALUES('$idA','$Nombre','$url','$Descripcion','$fecha_hora_actual','0','$tam_archivo','$Usuario','$Tema','$Id_usuario')";
				break;
				case 'coordinador':
					$Consulta = "INSERT INTO Archivo(idArchivo,Nombre,Ruta,Descripcion,Fecha,Calificacion,Tam,Autor,Tema,Coordinador_Usuario_idUsuario)VALUES('$idA','$Nombre','$url','$Descripcion','$fecha_hora_actual','0','$tam_archivo','$Usuario','$Tema','$Id_usuario')";
				break;
				case 'servidor':
					$Consulta = "INSERT INTO Archivo(idArchivo,Nombre,Ruta,Descripcion,Fecha,Calificacion,Tam,Autor,Tema,Servidor_Social_Usuario_idUsuario)VALUES('$idA','$Nombre','$url','$Descripcion','$fecha_hora_actual','0','$tam_archivo','$Usuario','$Tema','$Id_usuario')";
				break;
			}
			$resultado = mysqli_query($conect, $Consulta);
			move_uploaded_file($_FILES['archivo']['tmp_name'],$url);
			if($tipo_archivo != ".mp4")
			{
				$Consulta = "SELECT idArchivo FROM Archivo WHERE Ruta = '$url'";
				$resultado = mysqli_query($conect, $Consulta);
				$temp = mysqli_fetch_assoc($resultado);
				$id = $temp['idArchivo'];
				$Consulta = "INSERT INTO Documento(Archivo_idArchivo,Tipo_Archivo)VALUES('$id','$tipo_archivo')";
				echo $Consulta;
				$resultado = mysqli_query($conect, $Consulta);
			}
			header("location: ../Principal/index.php");
		}
	}
?>