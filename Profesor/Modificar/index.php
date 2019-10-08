<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="shortcut icon" href="../../Logos/logo.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Mis archivos</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css">
	<link rel="stylesheet" type="text/css" href="../../StylesS/css/main.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">	
	<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
</head>
<body>
	<?php
		session_start();
		if(!isset($_SESSION['usuario']))
		{
			session_start();
			session_destroy();
			header('location: ../../Sesion/index.php');
		}
		else
		{
			$usuario = $_SESSION['usuario'];
			$server = "localhost";
			$bd_name = "Repositorio";
			$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
			$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
			$Consulta = "SELECT idUsuario,tipo_usuario FROM Usuario WHERE user = '$usuario'";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$Id_usuario = $temp['idUsuario'];
			$tipo = $temp['tipo_usuario'];

			$Consulta = "SELECT * FROM Profesor JOIN Usuario ON Profesor.Usuario_idUsuario = Usuario.idUsuario WHERE Usuario.user = '$usuario'";
			$resultado = mysqli_query($conect,$Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			if(!$temp)
			{
				session_start();
				session_destroy();
				header('location: ../../Sesion/index.php');
			}
		}
	?>
	
	<header><span class="fas fa-bars" id="show"></span>
		<div class="box">
			<div class="container">
				<form method = "POST" action = "../Buscar/index.php">
					<input type="search" id="search" placeholder="Buscar..." name = "Busqueda"/>
					<button class="icon"><i class="fa fa-search"></i></button>
				</form>
			</div>
		</div>
		<div class = "Nombre">
		<?php
			$Usuario = $_SESSION['usuario'];
			$Consulta = "SELECT firstName,lastName FROM Usuario WHERE user = '$Usuario'"; 
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$Nombre = $temp['firstName'];
			$Apellido = $temp['lastName'];
			echo "<h1>".$Nombre." ".$Apellido."</h1>";
		?>
		</div>
	</header>

	<!-- <h1>profesor</h1> -->
	<main>
		<div class="content-menu">
			<a href = "../Principal/index.php"><li><span class="fas fa-home icon1"></span><h4 class="text1">Inicio</h4></li></a>
			<a href = "../Subir/index.php"><li><span class="fas fa-file-upload icon2"></span><h4 class="text2">Subir Archivo</h4></li></a>
			<a href = "../Cuestionario/index.php"><li><span class="fas fa-poll icon3"></span><h4 class="text3">Crear Encuesta</h4></li></a>
			<a href = "../Eliminar/index.php"><li><span class="fas fa-trash-alt icon4"></span><h4 class="text4">Eliminar Archivos</h4></li></a>
			<a href = "../Modificar/index.php"><li><span class="fas fa-file icon5"></span><h4 class="text5">Modificar Archivo</h4></li></a>
			<a href = "../Archivos/index.php"><li><span class="fas fa-eye icon6"></span><h4 class="text5">Ver  mis archivos</h4></li></a>
			<a href = "../../Sesion/close.php"><li><span class="fas fa-times-circle icon7"></span><h4 class="text5">Cerrar Sesion</h4></li></a>
		</div>
		
		<article>
			<h1>Mis archivos</h1>
			<?php
				switch ($tipo)
				{
					case 'servidor':
						$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Documento.Tipo_Archivo,Archivo.Servidor_Social_Usuario_idUsuario FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE Archivo.Servidor_Social_Usuario_idUsuario = '$Id_usuario'";
					break;
					case 'profesor':
						$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Documento.Tipo_Archivo,Archivo.Profesor_Usuario_idUsuario FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE Archivo.Profesor_Usuario_idUsuario = '$Id_usuario'";
					break;
					case 'coordinador':
						$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Documento.Tipo_Archivo,Archivo.Coordinador_Usuario_idUsuario FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE Archivo.Coordinador_Usuario_idUsuario = '$Id_usuario'";
					break;
				}
				$resultado = mysqli_query($conect, $Consulta);
			
				while($rows = mysqli_fetch_array($resultado))
				{
					echo '<br><br>';
					$idA = $rows['idArchivo'];
					echo "<div class = 'Centro'>";
					echo "<a href = 'cambiar.php?id=".$idA."'>";
					echo "<h2><br>".$rows['Nombre']."</h2>";
					echo "<div class = 'Informacion'>";

					if($rows['Tipo_Archivo'] == ".pdf")
					{
						echo "<img class = 'Logo' src = '../../Logos/archivos/pdf.png'></img>";
					}
					elseif ($rows['Tipo_Archivo'] == ".pptx" ||$rows['Tipo_Archivo'] == ".ppt")
					{
						echo "<img class = 'Logo' src = '../../Logos/archivos/ppt.png'></img>";
					}
					elseif ($rows['Tipo_Archivo'] == ".docx" ||$rows['Tipo_Archivo'] == ".doc")
					{
						echo "<img class = 'Logo' src = '../../Logos/archivos/doc.png'></img>";
					}
	
					echo "<p>Descripcion: <br>".$rows['Descripcion']."<br><br><p>";
					echo "</div>";
					echo "</a>";
					echo "</div>";
				}
			?>


		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
