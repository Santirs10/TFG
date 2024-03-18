<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['dni'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

// Recuperar la información del usuario de la sesión
$dni = $_SESSION['dni'];
 // Asegúrate de almacenar esta información en la sesión al autenticar al usuario

// Aquí puedes agregar más información del usuario que desees mostrar en la página de perfil

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="bank.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Usuario</title>
</head>
<body>
    <h1>Bienvenido </h1>
    <p>Tu DNI es: <?php echo $dni; ?></p>
    <!-- Otros detalles del perfil -->
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>