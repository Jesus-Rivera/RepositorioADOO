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
			$server = "localhost";
			$bd_name = "Repositorio";
			$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
			$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
			$Usuario  = $_SESSION['usuario'];
			$Consulta = "SELECT idUsuario FROM Usuario WHERE user = '$Usuario'"; 
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$id = $temp['idUsuario'];

			$Consulta = "SELECT * FROM Alumno JOIN Usuario ON Alumno.Usuario_idUsuario = Usuario.idUsuario WHERE Usuario.user = '$Usuario'";
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

	<main>
		<div class="content-menu">
			<a href = "../Principal/index.php"><li><span class="fas fa-home icon1"></span><h4 class="text1">Inicio</h4></li></a>
			<a href = "../Cuestionario/index.php"><li><span class="fas fa-book icon4"></span><h4 class="text3"> Cuestionarios</h4></li></a>
			<a href = "../Archivos/index.php"><li><span class="fas fa-eye icon6"></span><h4 class="text5">Archivos Guardados</h4></li></a>
			<a href = "../../Sesion/close.php"><li><span class="fas fa-times-circle icon7"></span><h4 class="text5">Cerrar Sesion</h4></li></a>
		</div>
		<article>
			<h1>Mis archivos guardados</h1>
			<?php
			$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Autor,Archivo.Descripcion,Archivo.Tema,Documento.Tipo_Archivo FROM (Archivo_Guardado JOIN (Archivo JOIN Documento on Archivo.idArchivo = Documento.Archivo_idArchivo) ON Archivo_Guardado.Archivo_idArchivo = Archivo.idArchivo) WHERE Usuario_idUsuario = $id";

			$resultado = mysqli_query($conect,$Consulta);
			$i = 0;
			while($rows = mysqli_fetch_array($resultado))
			{
				echo '<br><br>';
				$idA = $rows['idArchivo'];
				echo "<div class = 'Centro'>";
				echo "<a href = '../Descarga/index.php?id=".$idA."'>";
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
				echo "Autor: <br>".$rows['Autor']."<br><br>";
				echo "Tema: <br>".$rows['Tema']."<br><br>";
				echo "</div>";
				echo '</a><a href = "'."quitar.php?id=".$idA.'"><input type = "submit" name = "Quitar" value = "Quitar de lista.">';
				echo "</a>";
				echo "</div>";
				$i++;
			}
			$temp = mysqli_fetch_assoc($resultado);
			if($i == 0)
			{
				echo '<h2>';
				echo 'No se tienen archivos guardados';
				echo '</h2>';
			}
			?>
		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
