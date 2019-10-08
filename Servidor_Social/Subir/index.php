<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="shortcut icon" href="../../Logos/logo.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Subir archivo</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
		}

	?>
	<!-- <h1>Bienvenido <?php echo $user['usuario']; ?></h1>
	<h2>Profesor</h2>
	<a href="<?php echo RUTA.'close.php' ?>">Cerrar Sesion</a> -->
	
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
			<a href = "../Eliminar/index.php"><li><span class="fas fa-trash-alt icon4"></span><h4 class="text4">Eliminar Archivos</h4></li></a>
			<a href = "../Archivos/index.php"><li><span class="fas fa-eye icon6"></span><h4 class="text5">Ver  mis archivos</h4></li></a>
			<a href = "../../Sesion/close.php"><li><span class="fas fa-times-circle icon7"></span><h4 class="text5">Cerrar Sesion</h4></li></a>
		</div>
		
		<article>
			<div class = "Subir">
				<form action = "guardar.php" method = "post" enctype = "multipart/form-data"> 
					<h1>Subir archivo</h1>
					<h2>Seleccione el archivo<h2>
					<input type = "file" name = "archivo" id = "archivo" accept = '.pdf,.doc,.docx,.ppt,.pptx'/>
					<br>
					<h2>Ingrese el nombre del archivo</h2>
					<br>
					<input type = "text" name = "Nombre">
					<br><br>
					<h2>Ingrese el tema</h2>
					<input type = "text" name = "Tema">
					<br>
					<h2>Ingrese una descripcion (Max 400 caracteres)</h2>
					<br><br>
					<textarea name = "descripcion" placeholder = "Agregue su descripción..."></textarea>
					<br>
					<input type = "submit" value = "Enviar"/> 
				</form>
			</div>
		</article>
	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="../../Estilos/js/menu.js"></script>
</body>
</html>
