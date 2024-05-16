<?php
error_reporting(E_ALL);
session_start();
ini_set('display_errors', 1);
$saldo = $_SESSION['saldo'];
echo $saldo;
$cuenta= $_SESSION['cuenta'];
echo $cuenta;
// Verificar si se reciben los datos del formulario
if (isset($saldo, $_POST['cantidad'], $_POST['numero_cuenta'])) {
    // Conectar a la base de datos (ajusta los valores según tu configuración)
    $conn = new mysqli("192.168.128.143", "webadmin", "2Q_hyTd2", "banco_sv");

    // Verificar la conexión
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $cantidad = floatval($_POST['cantidad']);
    $numero_cuenta_origen = $cuenta; // Obtener el número de cuenta de la URL
    $numero_cuenta_destino = $_POST['numero_cuenta'];

    // Verificar que la cantidad sea válida
    if ($cantidad <= 0 || $cantidad > $saldo) {
        echo 'Error: La cantidad a transferir no es válida.';
        exit();
    }

    // Realizar la transacción
    $conn->autocommit(FALSE); // Desactivar el modo de autocommit

    // Actualizar el saldo de la cuenta de origen
    $sql_actualizar_origen = "UPDATE cuenta SET saldo = saldo - ? WHERE id_cuenta = ?";
    $stmt_actualizar_origen = $conn->prepare($sql_actualizar_origen);
    $stmt_actualizar_origen->bind_param('ds', $cantidad, $numero_cuenta_origen);
    $stmt_actualizar_origen->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt_actualizar_origen->affected_rows !== 1) {
        $conn->rollback(); // Revertir la transacción
        echo 'Error: No se pudo actualizar el saldo de la cuenta de origen.';
        exit();
    }

    // Actualizar el saldo de la cuenta destino
    $sql_actualizar_destino = "UPDATE cuenta SET saldo = saldo + ? WHERE id_cuenta = ?";
    $stmt_actualizar_destino = $conn->prepare($sql_actualizar_destino);
    $stmt_actualizar_destino->bind_param('ds', $cantidad, $numero_cuenta_destino);
    $stmt_actualizar_destino->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt_actualizar_destino->affected_rows !== 1) {
        $conn->rollback(); // Revertir la transacción
        echo 'Error: No se pudo actualizar el saldo de la cuenta destino.';
        exit();
    }

    $conn->commit(); // Confirmar la transacción
    $conn->autocommit(TRUE); // Reactivar el modo de autocommit

    $fecha_transaccion = date('Y-m-d H:i:s');
    $tipo_transaccion = 'transferencia';
    $estado_transaccion = 'correcta';

    $sql_insert_transaccion = "INSERT INTO transacciones (num_cuenta_origen, num_cuenta_destino, fecha_transaccion, tipo_transaccion, cantidad_transaccion, estado_transaccion) VALUES ($numero_cuenta_origen, $numero_cuenta_destino, '$fecha_transaccion', '$tipo_transaccion', $cantidad, '$estado_transaccion')";
    $result_insert_transaccion = $conn->query($sql_insert_transaccion);
    // Verificar si la inserción fue exitosa

    if ($result_insert_transaccion===FALSE) {
        echo 'No se pudo insertar la transacción en la tabla transacciones.';
        exit();
    }
    else{
    echo 'Transacción realizada exitosamente.';
    header("Location: user.php?s=1");
    exit();
}
} else {
    echo $_POST['saldo'], $_POST['cantidad'], $_POST['numero_cuenta'];
    echo 'No se recibieron todos los datos del formulario.';
}
?>
