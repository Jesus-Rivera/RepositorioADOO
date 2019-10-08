<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="shortcut icon" href="../../Logos/logo.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>RMD</title>
	<link rel="stylesheet" type="text/css" href="../../StylesS/css/main.css">
	<link rel="stylesheet" type="text/css" href="CSS/main.css">
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

			$Consulta = "SELECT * FROM Profesor JOIN Usuario ON Profesor.Usuario_idUsuario = Usuario.idUsuario WHERE Usuario.user = '$Usuario'";
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
			<a href = "../Cuestionario/index.php"><li><span class="fas fa-poll icon3"></span><h4 class="text3">Crear Encuesta</h4></li></a>
			<a href = "../Eliminar/index.php"><li><span class="fas fa-trash-alt icon4"></span><h4 class="text4">Eliminar Archivos</h4></li></a>
			<a href = "../Modificar/index.php"><li><span class="fas fa-file icon5"></span><h4 class="text5">Modificar Archivo</h4></li></a>
			<a href = "../Archivos/index.php"><li><span class="fas fa-eye icon6"></span><h4 class="text5">Ver  mis archivos</h4></li></a>
			<a href = "../../Sesion/close.php"><li><span class="fas fa-times-circle icon7"></span><h4 class="text5">Cerrar Sesion</h4></li></a>
		</div>
	<main>
		<article>
			<div class = "Cuestionarios">
				<h1>Nuevo cuestionario</h1>
				<form action = "crear.php" method = "POST" name = "Validar">
					<p>Cantidad: </p><input type="range" name="Preguntas" id="pregInput" value="15" min="3" max="35" oninput="pregOutput.value = pregInput.value">
   					<output name="SalidaPreguntas" id="pregOutput">15</output>
   					

   					<p>Respuestas por pregunta: </p><input type="range" name="Respuestas" id="resIntput" value="15" min="2" max="5" oninput="resOutput.value = resIntput.value">
   					<output name="SalidaRespuestas" id="resOutput">3</output>
				<br><input type = "submit" name = "cargar" value = "Aceptar">
				</form>
				<?php
					if(isset($_POST['Preguntas']) && isset($_POST['Respuestas']))
					{
						$preg = $_POST['Preguntas'];
						$res =  $_POST['Respuestas'];
						echo '<form action = "cargar.php?preg='.$preg.'&res='.$res.'" method = "POST" name = "Crear">';
						echo "<br>";
						echo '<p>Nombre: <input type = "text" name = "Nombre" style = "width: 150px"></p>';
						echo '<br>';
						echo '<p>Tema: <input type = "text" name = "Tema" style = "width: 150px"></p>';
						echo '<br>';
						echo '<p>Descripcion: <br><textarea name = "descripcion" placeholder = "Agregue su descripción..." ></textarea></p>';
						echo '<br>';
						for ($i = 0; $i < $preg; $i++)
						{
							echo '<p>'.($i + 1).'.- <input type = "text" name = "Pregunta'.$i.'"></p>';
							echo '<br>';
							for ($j=0; $j < $res; $j++)
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
								echo ' <input type = "text" name = "Respuesta'.$j.$i.'"></p>';
							}
						}
						echo '<input type = "submit" name = "Enviar" value = "Aceptar">';
						echo '</form>';
					}
				?>


			</div>

		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
