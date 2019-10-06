<?php session_start();

    require 'admin/config.php';
    require 'functions.php';

    $errores = '';

    if(isset($_SESSION['usuario']))
    {
        $conexion = conexion($bd_config);
        $statement = $conexion->prepare('SELECT tipo_usuario FROM Usuario WHERE user = :usuario');
        $statement->execute([
            ':usuario' => $usuario,
        ]);
        $resultado = $statement->fetch();
        switch ($resultado['tipo_usuario'])
        {
            case 'alumno':
                header('Location: ../Alumno/index.php');
            break;
            case 'profesor':
                header('Location: ../Profesor/index.php');
            break;
            case 'coordinador':
                header('Location: ../Coordinador/index.php');
            break;
            case 'servidor':
                header('Location: ../Servidor_Social/index.php');
            break;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);

        $conexion = conexion($bd_config);
        $statement = $conexion->prepare('SELECT * FROM Usuario WHERE user = :usuario AND password = :password');
        $statement->execute([
            ':usuario' => $usuario,
            ':password' => $password
        ]);
        $resultado = $statement->fetch();

        if ($resultado !== false) {
            if($_POST['sesion'] == 1)
            {
                ini_set(session.cookie_lifetime,0);
            }
            $_SESSION['usuario'] = $usuario;
            header('Location: '.RUTA.'index.php');
        } else {
            $errores .= '<li class="error">Tu usuario y/o contraseña son incorrectos</li>';
        }
    }
    require 'views/login.view.php';
?>