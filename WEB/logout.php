<?php
session_start();
// Establecer conexión a la base de datos
$conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");

// Comprobar la conexión
if ($conn->connect_error) {
    // Si la conexión falla, lanzar una excepción personalizada
    throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
}

// Iniciar sesión en PHP (si no se ha iniciado ya)

// Obtener el DNI de la sesión PHP
$dni_cliente = $_SESSION['dni']; // Asegúrate de que 'dni' sea la clave correcta de tu sesión
$comentario = "Se ha cerrado sesión mediante logout.php";
// Obtener la fecha actual
$fecha_fin = date("Y-m-d H:i:s"); // Formato: Año-Mes-Día Hora:Minutos:Segundos

// Consulta para insertar los datos en la tabla sesiones
$sql_insertar_sesion = "INSERT INTO sesiones (dni_cliente, fecha_fin,comentario) VALUES ('$dni_cliente', '$fecha_fin','$comentario')";

// Ejecutar la consulta
if ($conn->query($sql_insertar_sesion) === TRUE) {
    echo "La sesión se ha registrado correctamente.";
} else {
    echo "Error al registrar la sesión: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

// Hacer insert into sesiones cogiendo la fecha para meterlo en fecha fin, y con el dni 

// Eliminar todas las variables de sesi�n
session_unset();
// Destruir la sesi�n
session_destroy();
header("Location: index.html");
exit();
?>