<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="../Logos/logo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="../js/validar.js"></script>
</head>
<body class="bg-image">

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit = "return validar();">
            <!-- usuario -->
            <div class="input-group">
                <i class="fas fa-user icons" aria-hidden="false"></i>
                <input type="text" name="usuario" placeholder="Usuario" class="form-control" class="text1">
            </div>
            <!--- Nombre -->
            <div class="input-group">
               <i class="fas fa-address-book icons" aria-hidden="false"></i>
                <input type="text" name="nombre" placeholder="Nombre" class="form-control" class="text1">
            </div>
            <!--- Apellido -->
            <div class="input-group">
               <i class="fas fa-address-card icons" aria-hidden="false"></i>
                <input type="text" name="apellido" placeholder="Apellido" class="form-control" class="text1">
            </div>
            <!-- email -->
             <div class="input-group">
                <i class="fas fa-envelope icons" aria-hidden="false"></i>
                <input type="email" name="email" placeholder="user@example.com" class="form-control">
            </div>
            <!-- password -->
            <div class="input-group">
                <i class="fa fa-lock icons" aria-hidden="false"></i>
                <input type="password" name="password" placeholder="Contraseña" class="form-control">
            </div>
           

            <div class="input-group">
                <select class="form-control" name="rol">
                    <option value="">Selecciona un privilegio</option>
                    <option value="alumno">Alumno</option>
                    <option value="profesor">Profesor</option>
                    <option value="coordinador">Coordinador</option>
                    <option value="servidor">Servidor Social</option>
                </select>
            </div>

            <?php if (!empty($errores)): ?>
                <ul>
                    <?php echo $errores; ?>
                </ul>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-flat-green">Registrar</button>
            <a href="<?php echo RUTA.'login.php' ?>" class="login-link">¿Ya tienes cuenta?</a>
        </form>
    </div>
    
</body>
</html>
