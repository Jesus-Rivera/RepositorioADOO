<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="shortcut icon" href="../../Logos/logo.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Archivo</title>
	<link rel="stylesheet" type="text/css" href="../../StylesS/css/main.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
			$id = $_GET['id'];
			$server = "localhost";
			$bd_name = "Repositorio";
			$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
			$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
			$Usuario  = $_SESSION['usuario'];

			$Consulta = "SELECT * FROM Profesor JOIN Usuario ON Profesor.Usuario_idUsuario = Usuario.idUsuario WHERE Usuario.user = '$Usuario'";
			$resultado = mysqli_query($conect,$Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			if(!$temp)
			{
				session_start();
				session_destroy();
				header('location: ../../Sesion/index.php');
			}

			$Consulta = "SELECT Tipo_Archivo FROM Documento WHERE Archivo_idArchivo = '$id'";
			if($resultado = mysqli_query($conect, $Consulta))
			{
				$temp = mysqli_fetch_assoc($resultado);
				$tipo = $temp['Tipo_Archivo'];
			}


			$Consulta = "SELECT idUsuario FROM Usuario WHERE user = '$Usuario'";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$id_Usuario = $temp['idUsuario'];
			$fecha_hora_actual = date('Y-m-d H:i:s');
			$Consulta = "SELECT Vistas FROM Archivo_visto WHERE Archivo_idArchivo = $id AND Usuario_idUsuario = $id_Usuario";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			if(!$temp)
			{
				$Consulta = "INSERT INTO Archivo_visto(Archivo_idArchivo,Usuario_idUsuario,Fecha_visto,Vistas)VALUES($id,$id_Usuario,'$fecha_hora_actual',1)";
				$resultado = mysqli_query($conect, $Consulta);
			}
			else
			{
				$vistas = $temp['Vistas'];
				$vistas++;
				$Consulta = "UPDATE Archivo_visto SET Vistas = $vistas WHERE Archivo_idArchivo = $id AND Usuario_idUsuario = $id_Usuario";
				$resultado = mysqli_query($conect, $Consulta);
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
			<div class = "Descarga">
				<div class = "Izq">
					<?php
					$Consulta = "SELECT Nombre,Autor,Descripcion,Tema,Calificacion,Ruta FROM Archivo WHERE idArchivo = '$id'"; 
				$resultado = mysqli_query($conect, $Consulta);
				$temp = mysqli_fetch_assoc($resultado);		
						$item = $temp['Nombre'];
						$autor = $temp["Autor"];
						$Descripcion = $temp['Descripcion'];
						$Ruta = $temp['Ruta'];
						$Nombre = $temp['Nombre'];
						echo "<h2>".$item."</h2>";

					?>
					<div class = "portada">
					<?php
						if($tipo == ".pdf")
						{
							echo "<img src = '../../Logos/archivos/pdf.png'>";
						}
						else if($tipo == ".pptx" || $tipo == ".ppt" )
						{
							echo "<img src = '../../Logos/archivos/ppt.png'>";
						}
						else if($tipo == ".doc" || $tipo == ".docx")
						{
							echo "<img src = '../../Logos/archivos/doc.png'>";
						}
					?>
					</div>
					<div class = "Detalles">
					<?php
						echo "<a href = #>".$autor."</a>";
					?>
						<p>Mas detalles</p>
					</div>
				</div>
				<div class = "Der">
					<div class = "Descripcion">
						<p>
							<h2>Descripcion del documento</h2>
							<?php
								echo $Descripcion;
							?>
						</p>
						<br>
						<?php
							echo "<a href = '$Ruta' download = '$Nombre'>";
							echo "<input type = 'submit' name = 'descargar' value = 'Descargar'>";
							echo "</a>";
						?>
							<br><br><br><br>
					</div>
				</div>
			</div>
		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
