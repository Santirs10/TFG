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
            <?php
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
        echo $fila["nombre"] . "<br>";
        $Nombre= $fila["nombre"];
    }
} else {
    echo "<p style='color:red;'>Error.</p>";
}
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
            </h1>
            <?php
            echo "<p>Tu DNI es: " . $dni . "</p>"       ?>
            <!-- Otros detalles del perfil -->
            <nav>
                <ul>
                    <li><a href="logout.php" style="float: right;">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="fondos">
            <!--select Suma de cuentas con DNI= $dni-->
            <h2>Actualmente, tienes
                <?php echo $saldo; ?> €.</h2>
                <h3><a href="fondos.php">Accede a tu ahorro.</a></h3>
        </div>
        <div class="cuentas">
            <h2>Cuentas: <?php 
            $conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");
            // Comprobar la conexión
            if ($conn->connect_error) {
                // Si la conexión falla, lanzar una excepción personalizada
                throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
            }
            $_SESSION['dni'] = $dni;
            $sql_cuentas = "SELECT id_cuenta FROM titularcuenta WHERE dni_c = '$dni'";
            $resultado_cuentas = $conn->query($sql_cuentas);
            
            // Verificar si hay resultados
            if ($resultado_cuentas->num_rows > 0) {
                // Mostrar todas las cuentas del cliente
                while ($fila_cuenta = $resultado_cuentas->fetch_assoc()) {
                    echo "<div class='cuentas'>";
                    echo "<a href='cuentas.php'>Accede a la cuenta ". $fila_cuenta["id_cuenta"] ."</a>";
                    echo "</div>";
                    echo "<br>";
                }
            } else {
                // Si no hay cuentas asociadas al cliente
                echo "<p><a href='cuentas.php'>No se encuentran cuentas asociadas a este cliente </a></p>";
            }
            
            ?></h2>
        </div>
        <div class="transferencias">
            <h2>Transferencias</h2>
            <div> 
                <a href="transferencias.php">¿Quieres realizar, o solicitar alguna transferencia?</a></div>
        </div>
    </div>
</body>

</html>