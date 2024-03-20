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
$conn = new mysqli("192.168.128.143", "webadmin", "2Q_hyTd2", "banco_sv");

// Comprobar la conexión
if ($conn->connect_error) {
    // Si la conexión falla, lanzar una excepción personalizada
    throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
}
// Tabla cliente.
    $sql = "SELECT * FROM clientes where dni_cliente='$dni'";
    $resultado = $conn->query($sql);


if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo "Nombre: " . $fila["nombre"] . "<br>";
        $Nombre= $fila["nombre"];
    }
} else {
    echo "<p style='color:red;'>Error.</p>";
}
// Tabla Cuenta
$sql = "SELECT * FROM cuenta where dni_c='$dni'";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo "ID Cuenta: " . $fila["id_cuenta"] . "<br>";
        $id_cuenta = $fila["id_cuenta"];
        echo "DNI Cliente: " . $fila["dni_c"] . "<br>";
        echo "Tipo de cuenta: " . $fila["tipo_cuenta"] . "<br>";
        $tipo_c=$fila["tipo_cuenta"];
        echo "Saldo: " . $fila["saldo"] . "<br>";
        $saldo=$fila["saldo"];
        echo "Fecha de apertura: " . $fila["fecha_apertura"] . "<br>";
        echo "Fecha de cierre: " . $fila["fecha_cierre"] . "<br>";
        echo "Tipo de interés: " . $fila["tipo_interes"] . "<br>";
        echo "Límite de retiro: " . $fila["limite_retiro"] . "<br>";
        echo "Estado de cuenta: " . $fila["estado_cuenta"] . "<br>";
        echo "<br>";
    }
} else {
    echo "No tienes una cuenta asociada.";
}

$conn->close();
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
    <header>
        <div class="container">
            <h1>Bienvenido
                <?php echo $Nombre ?>
            </h1>
            <p>Tu DNI es:
                <?php echo $dni; ?>
            </p>
            <!-- Otros detalles del perfil -->
            <nav>
                <ul>
                    <li><a href="user.php">Inicio</a></li>

                    <li><a href="logout.php" style="float: rigth;">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="fondos">
            <!--select Suma de cuentas con DNI= $dni-->
            <h2>Actualmente, tienes
                <?php echo $saldo; ?>€.</h3>
                <a href="fondos.php">Accede a tu ahorro.</a>
        </div>
        <div class="cuentas">
            <h2>Cuenta: <?php echo $id_cuenta?></h2>
            <a href="cuentas.php">Accede a tus cuentas </a>
        </div>
        <div class="transferencias">
            <h2>Transferencias</h2>
            <div> ¿Quieres realizar, o solicitar alguna transferencia?</div>
        </div>
    </div>
</body>

</html>