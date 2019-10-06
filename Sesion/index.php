<?php session_start();

    require 'admin/config.php';
    require 'functions.php';

    // comprobando session
    if (isset($_SESSION['usuario'])) {
       
        // validar los datos por privilegio
        $conexion = conexion($bd_config);
        $usuario = iniciarSession('Usuario', $conexion);

        // validando los diferentes tipos de usuarios
        if ($usuario['tipo_usuario'] == 'alumno') {
            header('Location: ../Alumno/Principal/index.php');
        } elseif ($usuario['tipo_usuario'] == 'profesor') {
            header('Location: ../Profesor/Principal/index.php');
        } elseif ($usuario['tipo_usuario'] == 'coordinador') {
            header('Location: ../Coordinador/Principal/index.php');
        } elseif ($usuario['tipo_usuario'] == 'servidor') {
            header('Location: ../Servidor_Social/Principal/index.php');
        }else {
            header('Location: '.RUTA.'login.php');
        }
    } else { //sino es ningun tipo de usuario
        header('Location: '.RUTA.'login.php');
    }
?>
