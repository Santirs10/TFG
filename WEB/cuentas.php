<?php
error_reporting();
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
$conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");

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
        $Nombre= $fila["nombre"];
    }
} else {
    echo "<p style='color:red;'>Error.</p>";
}
// Tabla Cuenta

$sql_saldo = "SELECT SUM(c.saldo) AS saldo_total 
              FROM cuenta c 
              JOIN titularcuenta t ON c.id_cuenta = t.id_cuenta 
              WHERE t.dni_c = '$dni'";

$resultado_saldo = $conn->query($sql_saldo);

if ($resultado_saldo->num_rows > 0) {
    // Obtenemos el saldo total
    $fila_saldo = $resultado_saldo->fetch_assoc();
    $saldo = $fila_saldo["saldo_total"];
} if ($saldo<=0) {
    $saldo = 0;
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
<script>
    var temporizadorInactividad;

    // Función para reiniciar el temporizador de inactividad
    function reiniciarTemporizador() {
        clearTimeout(temporizadorInactividad);
        temporizadorInactividad = setTimeout(function() {
            // Redirigir al usuario a logout.php después de 1 minuto de inactividad
            window.location.href = "logout.php";
        }, 60000); // 1 minuto en milisegundos
    }

    // Iniciar el temporizador al cargar la página
    reiniciarTemporizador();

    // Agregar escuchadores de eventos para reiniciar el temporizador en diferentes acciones del usuario
    document.addEventListener("mousemove", reiniciarTemporizador);
    document.addEventListener("keypress", reiniciarTemporizador);
    document.addEventListener("click", reiniciarTemporizador);
</script>
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
            <h2>Actualmente, tienes
                <?php echo $saldo; ?> € entre todas tus cuentas.</h3>
                <a href="fondos.php">Accede a tu ahorro.</a>
        </div>
        <div class="cuentas">
            <h2> <?php 
            $conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");

            // Comprobar la conexión
            if ($conn->connect_error) {
                // Si la conexión falla, lanzar una excepción personalizada
                throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
            }
            $sql = "SELECT * FROM titularcuenta where dni_c='$dni'";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $id_cuenta = $fila["id_cuenta"];
        $sql_saldo = "SELECT *
              FROM cuenta c
              INNER JOIN titularcuenta tc ON c.id_cuenta = tc.id_cuenta
              WHERE c.id_cuenta = '$id_cuenta' AND tc.dni_c = '$dni'";

$resultado_saldo = $conn->query($sql_saldo);

if ($resultado_saldo->num_rows > 0) {
    // Obtenemos el saldo de la cuenta deseada
    $fila_saldo = $resultado_saldo->fetch_assoc();
    $saldo = $fila_saldo["saldo"];
} else {
    // Si no se encuentra la cuenta deseada, establecemos el saldo a 0
    $saldo = 0;
}
echo '<div style="width: calc(100% - 40px); max-width: 800px; margin: 20px; background-color: #add8e6; border-radius: 20px; padding: 20px; box-sizing: border-box; box-shadow: 10px 0 8px rgba(0, 0, 0, 0.1);">';        echo "ID Cuenta: " . $fila["id_cuenta"] . "<br>";
        echo "Eres " . $fila["tipo_titularidad"] . " de la cuenta <br>";
        echo "Tienes " . $saldo . " € en esta cuenta";
        echo "</div>";
        echo "<br>";
        
    }
} else {
    echo "<p style='color: red;'>No tienes una cuenta asociada.</p>";
}

            ?></h2>
        </div>
        <div class="transferencias">
            <h2>Transferencias</h2>
            <a href="transferencias.php">¿Quieres realizar, o solicitar alguna transferencia?</a>
        </div>
    </div>
</body>

</html>