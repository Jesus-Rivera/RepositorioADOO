<?php session_start();

    require 'admin/config.php';
    require 'functions.php';



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $usuario = limpiarDatos($_POST['usuario']);
        $password = limpiarDatos($_POST['password']);
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellido = htmlspecialchars($_POST['apellido']);
        $correo = $_POST['email'];

        // protegiendo las contraseñas de los usuarios (encriptacion)
        $password = hash('sha512', $password);
        $rol = $_POST['rol'];


        $errores = '';

        // validar los campos de texto
        if (empty($usuario) || empty($password) || empty($rol)) {
            $errores .= '<li class="error">Favor de llenar todos los campos</li>';
        }else{
            // validacion de que el usuario no exista
            $conexion = conexion($bd_config);
            $statement = $conexion->prepare('SELECT * FROM Usuario WHERE user = :usuario LIMIT 1');
            $statement->execute([
                ':usuario' => $usuario
            ]);
            $resultado = $statement->fetch();

            if ($resultado != false) {
                $errores .= '<li class="error">Este usuario ya existe</li>';
            }
            $conexion = conexion($bd_config);
            $statement = $conexion->prepare('SELECT * FROM Usuario WHERE email = :correo LIMIT 1');
            $statement->execute([
                ':correo' => $correo
            ]);

            $resultado = $statement->fetch();
            if ($resultado != false) {
                $errores .= '<li class="error">Correo ya registrado</li>';
            }
        }

        if($errores == ''){
            $conexion = conexion($bd_config);

            $statement = $conexion->prepare('SELECT idUsuario FROM Usuario ORDER BY idUsuario DESC LIMIT 1');
            $statement->execute();
            $resultado = $statement->fetch();
            $id = $resultado['idUsuario'];
            $id++;
            $statement = $conexion->prepare('INSERT INTO Usuario(idUsuario,firstName,lastName,email,password,user,tipo_usuario) VALUES(:id,:nombre,:apellido,:email,:password,:usuario,:tipo_usuario)');
            // ejecutamos la sentencia sql
            $statement->execute([
                ':id' => $id,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':email' => $correo,
                ':password' => $password,
                ':usuario' => $usuario,
                ':tipo_usuario' => $rol
            ]);
            if($_POST['sesion'] == 1)
            {
                ini_set(session.cookie_lifetime,0);
            }
            $_SESSION['usuario'] = $usuario;
            switch ($rol)
            {
                case 'alumno':
                    $statement = $conexion->prepare('INSERT INTO Alumno(Usuario_idUsuario)VALUES(:id)');
                    $statement->execute([':id' => $id]);
                    header('Location: ../Alumno/index.php');
                break;
                case 'profesor':
                    $statement = $conexion->prepare('INSERT INTO Profesor(Usuario_idUsuario)VALUES(:id)');
                    $statement->execute([':id' => $id]);
                    header('Location: ../Profesor/index.php');
                break;
                case 'coordinador':
                    $statement = $conexion->prepare('INSERT INTO Coordinador(Usuario_idUsuario)VALUES(:id)');
                    $statement->execute([':id' => $id]);
                    header('Location: ../Coordinador/index.php');
                break;
                case 'servidor':
                    $statement = $conexion->prepare('INSERT INTO Servidor_Social(Usuario_idUsuario)VALUES(:id)');
                    $statement->execute([':id' => $id]);
                    header('Location: ../Servidor_Social/index.php');
                break;
            }
        }
    }

require 'views/registro.view.php';

?>