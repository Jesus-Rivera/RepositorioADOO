<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="shortcut icon" href="../../Logos/logo.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>RMD</title>
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
			$server = "localhost";
			$bd_name = "Repositorio";
			$conect = mysqli_connect($server, "root", "") or die ("No se ha podido realizar la conexión a la BBBDD".mysql_error());
			$db = mysqli_select_db($conect, $bd_name) or die ("Error...");
			$Usuario  = $_SESSION['usuario'];
			$Consulta = "SELECT * FROM Coordinador JOIN Usuario ON Coordinador.Usuario_idUsuario = Usuario.idUsuario WHERE Usuario.user = '$Usuario'";
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

		<div class="content-menu">
			<a href = "../Principal/index.php"><li><span class="fas fa-home icon1"></span><h4 class="text1">Inicio</h4></li></a>
			<a href = "../Subir/index.php"><li><span class="fas fa-file-upload icon2"></span><h4 class="text2">Subir Archivo</h4></li></a>
			<a href = "../Cuestionario/index.php"><li><span class="fas fa-book icon3"></span><h4 class="text3">Cuestionarios</h4></li></a>
			<a href = "../Eliminar/index.php"><li><span class="fas fa-trash-alt icon4"></span><h4 class="text4">Eliminar Archivos</h4></li></a>
			<a href = "../Modificar/index.php"><li><span class="fas fa-file icon5"></span><h4 class="text5">Modificar Archivo</h4></li></a>
			<a href = "../Archivos/index.php"><li><span class="fas fa-eye icon6"></span><h4 class="text5">Ver  mis archivos</h4></li></a>
			<a href = "../../Sesion/close.php"><li><span class="fas fa-times-circle icon7"></span><h4 class="text5">Cerrar Sesion</h4></li></a>
		</div>
	<main>
		<article>
		<h1>Los archivos mas visitados</h1>
		<?php
			$Consulta = "SELECT Archivo_visto.Archivo_idArchivo,SUM(Vistas) as 'Total' FROM `Archivo_visto` GROUP BY Archivo_visto.Archivo_idArchivo ORDER BY Total DESC LIMIT 3";
			$resultado = mysqli_query($conect, $Consulta);
			$i = 0;
			$mas = [];
			while($rows = mysqli_fetch_array($resultado))
			{
				array_push($mas,$rows['Archivo_idArchivo']);
				$i++;
			}
		?>
		<div class = "centro">
			<div class="container-2">
				<input type="radio" name="nav" id="first" checked/>
				<input type="radio" name="nav" id="second" />
				<input type="radio" name="nav" id="third" />
				<label for="first" class="first"></label>
				<label for="second"  class="second"></label>
				<label for="third" class="third"></label>
		
		<?php
			$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Archivo.Autor,Archivo.Tema,Documento.Tipo_Archivo FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE idArchivo = $mas[0]";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$Nombre = $temp['Nombre'];
			$Autor = $temp['Autor'];
			$Descripcion = $temp['Descripcion'];
			$tipo = $temp['Tipo_Archivo'];
			$tema = $temp['Tema'];
			echo '<div class="one slide">';
			echo '<blockquote>';
			echo $Descripcion;
			echo '</blockquote>';
			if($tipo == ".pdf")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/pdf.png'></img>";
			}
			elseif ($tipo == ".pptx" ||$tipo == ".ppt")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/ppt.png'></img>";
			}
			elseif ($tipo == ".docx" ||$tipo == ".doc")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/doc.png'></img>";
			}
			echo '<h2>'.$Nombre.'</h2>';
			echo '<h6>'.$Autor.'</h6>';
			echo '<h6>'.$tema.'</h6>';
			echo '</div>';
		?>
		<?php
			$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Archivo.Autor,Archivo.Tema,Documento.Tipo_Archivo FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE idArchivo = $mas[1]";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$Nombre = $temp['Nombre'];
			$Autor = $temp['Autor'];
			$Descripcion = $temp['Descripcion'];
			$tipo = $temp['Tipo_Archivo'];
			$tema = $temp['Tema'];
			echo '<div class="two slide">';
			echo '<blockquote>';
			echo $Descripcion;
			echo '</blockquote>';
			if($tipo == ".pdf")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/pdf.png'></img>";
			}
			elseif ($tipo == ".pptx" ||$tipo == ".ppt")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/ppt.png'></img>";
			}
			elseif ($tipo == ".docx" ||$tipo == ".doc")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/doc.png'></img>";
			}
			echo '<h2>'.$Nombre.'</h2>';
			echo '<h6>'.$Autor.'</h6>';
			echo '<h6>'.$tema.'</h6>';
			echo '</div>';	
		?>
		<?php
			$Consulta = "SELECT Archivo.idArchivo,Archivo.Nombre,Archivo.Descripcion,Archivo.Autor,Archivo.Tema,Documento.Tipo_Archivo FROM (Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo) WHERE idArchivo = $mas[2]";
			$resultado = mysqli_query($conect, $Consulta);
			$temp = mysqli_fetch_assoc($resultado);
			$Nombre = $temp['Nombre'];
			$Autor = $temp['Autor'];
			$Descripcion = $temp['Descripcion'];
			$tipo = $temp['Tipo_Archivo'];
			$tema = $temp['Tema'];
			echo '<div class="three slide">';
			echo '<blockquote>';
			echo $Descripcion;
			echo '</blockquote>';
			if($tipo == ".pdf")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/pdf.png'></img>";
			}
			elseif ($tipo == ".pptx" ||$tipo == ".ppt")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/ppt.png'></img>";
			}
			elseif ($tipo == ".docx" ||$tipo == ".doc")
			{
				echo "<img class = 'Logo' src = '../../Logos/archivos/doc.png'></img>";
			}
			echo '<h2>'.$Nombre.'</h2>';
			echo '<h6>'.$Autor.'</h6>';
			echo '<h6>'.$tema.'</h6>';
			echo '</div>';	
		?>
		</div>
		<br><br>
		<h1>Subidos recientemente</h1>
		<br><br>

		<?php
			$Consulta = "SELECT idArchivo,Nombre,Tipo_Archivo,Autor,Tema FROM Archivo JOIN Documento ON Archivo.idArchivo = Documento.Archivo_idArchivo ORDER BY Fecha DESC LIMIT 5";
			$resultado = mysqli_query($conect,$Consulta);
			while($rows = mysqli_fetch_array($resultado))
			{
				echo '<br><br>';
				$idA = $rows['idArchivo'];
				echo "<div class = 'Centro-2'>";
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

				echo "Autor: <br>".$rows['Autor']."<br><br>";
				echo "Tema: <br>".$rows['Tema']."<br><br>";
				echo "</div>";
				echo "</a>";
				echo "</div>";
			}
		?>

		<br><br>
		<h1>Ultimos cuestionarios</h1>
		<br><br>

		<?php
			$Consulta = "SELECT idArchivo,Nombre,Autor,Tema FROM Archivo JOIN Cuestionario ON Archivo.idArchivo = Cuestionario.Archivo_idArchivo ORDER BY Fecha DESC LIMIT 3";
			$resultado = mysqli_query($conect,$Consulta);
			while($rows = mysqli_fetch_array($resultado))
			{
				echo '<br><br>';
				$idA = $rows['idArchivo'];
				echo "<div class = 'Centro-2'>";
				echo "<a href = '../VerCuestionario/index.php?id=".$idA."'>";
				echo "<h2><br>".$rows['Nombre']."</h2>";
				echo "<div class = 'Informacion'>";
				echo "<img class = 'Logo' src = '../../Logos/Cuestionario.png'></img>";
				echo "Autor: <br>".$rows['Autor']."<br><br>";
				echo "Tema: <br>".$rows['Tema']."<br><br>";
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
