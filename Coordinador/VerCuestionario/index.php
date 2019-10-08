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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.3.5/sweetalert2.all.min.js"></script>
</head>
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

	$idArchivo =  $_GET['id'];
	$Consulta = "SELECT Cuestionario.Preguntas,Cuestionario.Respuestas FROM Archivo JOIN Cuestionario ON Archivo.idArchivo = Cuestionario.Archivo_idArchivo WHERE Archivo.idArchivo = '$idArchivo'";
	$resultado = mysqli_query($conect, $Consulta);
	$temp = mysqli_fetch_assoc($resultado);

	$Respuestas = $temp['Respuestas'];
	$Preguntas = $temp['Preguntas'];
	$arrPreguntas = [];
	$arrRespuestas = [];
	$Correcto = [];
	$bandera = 0;
	$i = 0;
	while ($bandera == 0)
	{
		if($Preguntas[($i + 1)] == "&")
			$bandera = 1;
		else
			$i ++;
	}
	$TotalPreguntas = "";
	for ($j = 0; $j <= $i; $j++)
		$TotalPreguntas .=  $Preguntas[$j];
	$TotalPreguntas += 0;

	$bandera = 0;
	$k = 0;
	while ($bandera == 0)
	{
		if($Respuestas[($k + 1)] == "&")
			$bandera = 1;
		else
			$k ++;
	}
	$TotalRespuestas = "";
	for ($j = 0; $j <= $k; $j++)
		$TotalRespuestas .=  $Respuestas[$j];
	$TotalRespuestas += 0;

	$i += 13;
	for($j=0; $j < $TotalPreguntas; $j++)
	{
		$i += 13;
		$bandera = 0;
		$Pregunta = "";
		while (1==1) 
		{
			if(($Preguntas[$i] != "&") || ($Preguntas[$i + 1] != "e") || ($Preguntas[$i + 2] != "n") || ($Preguntas[$i + 3] != "d") || ($Preguntas[$i + 4] != "&"))
			{
				$Pregunta .= $Preguntas[$i];
				$i += 1;	
			}
			else
				break;
		}
		$i += 5;
		array_push($arrPreguntas,$Pregunta);
		$k += 26;
		for ($l=0; $l < $TotalRespuestas; $l++)
		{
			$k += 14;
			$bandera = 0;
			$Respuesta = "";
			while (1==1) 
			{
				if(($Respuestas[$k] != "&") || ($Respuestas[$k + 1] != "e") || ($Respuestas[$k + 2] != "n") || ($Respuestas[$k + 3] != "d") || ($Respuestas[$k + 4] != "R") || ($Respuestas[$k + 5] != "e") || ($Respuestas[$k + 6] != "s") || ($Respuestas[$k + 7] != "p") || ($Respuestas[$k + 8] != "&"))
				{
					$Respuesta .= $Respuestas[$k];
					$k += 1;	
				}
				else
					break;
			}
			$k += 9;
			array_push($arrRespuestas,$Respuesta);
		}
		array_push($Correcto,$Respuestas[$k]);
		$k += 1;
	}
?>
<script>
	function Correcto()
	{
		swal('Correcto','Todas las respuestas son correctas','success')
	}
</script>
<?php  
	echo '<script>';
	echo "function Incorrecto() {swal('Incorrecto'";
	echo ",'Existen respuestas incorrectas<br>Respuestas correctas: <br>";
	for ($i = 0; $i < $TotalPreguntas; $i++)
	{
		echo ($i + 1).")-".$Correcto[$i]."<br>";
	}
	echo "','error')}";
?>
		
</script>
<?php
	if(isset($_GET['total']))
	{
		$bandera = 0;
		for ($i = 0; $i < $_GET['total']; $i++)
			if(isset($_POST['Solucion'.$i]))
				if($_POST['Solucion'.$i] == $Correcto[$i])
					$bandera ++;
		if($bandera == $_GET['total'])
			echo '<body onload="Correcto();">';
		else
			echo '<body onload="Incorrecto();">';
	}
	else
	{
		echo '<body>';
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
			<div class = "Cuestionario">
				<?php
					$idArchivo =  $_GET['id'];
					$Consulta = "SELECT Archivo.Nombre,Archivo.Tema,Archivo.Descripcion,Archivo.Autor FROM Archivo JOIN Cuestionario ON Archivo.idArchivo = Cuestionario.Archivo_idArchivo WHERE Archivo.idArchivo = '$idArchivo'";
					$resultado = mysqli_query($conect, $Consulta);
					$temp = mysqli_fetch_assoc($resultado);
					echo "<div class = 'Centro'>";
					echo "<div class = 'Informacion'>";
					echo "<img class = 'Logo' src = '../../Logos/Cuestionario.png'></img>";
					echo "<p>".$temp['Nombre']."</p>";
					echo "<p>".$temp['Tema']."</p>";
					echo "<p>".$temp['Descripcion']."</p>";
					echo "</div>";
					echo "</div>";
				?>
				<?php
					echo '<form method = "POST" action = "index.php?total='.$TotalPreguntas.'&id='.$_GET['id'].'">';
					$k = 0;
					for ($i = 0; $i < $TotalPreguntas; $i++) 
					{
						echo '<br><br><br>';
						echo '<h2>'.($i + 1).".- ".$arrPreguntas[$i].'</h2>';
						for ($j = 0; $j < $TotalRespuestas; $j++)
						{
							switch ($j)
							{
								case '0':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "A" />A)';
								break;
								case '1':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "B" />B)';
								break;
								case '2':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "C" />C)';
								break;
								case '3':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "D" />D)';
								break;
								case '4':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "E" />E)';
								break;
								case '5':
									echo '<br><p style = "margin-left : 50px"><input type="radio" name="Solucion'.$i.'" value = "F" />F)';
								break;
							}
							echo "			".$arrRespuestas[$k].'</p>';
							$k++;
						}
					}
				?>
			</div>
			<br><br>
			<input type = "submit" name = "Comprobar" value = "Verificar resultados">
			</form>
		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
