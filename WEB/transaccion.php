<?php
error_reporting();
session_start();

if (!isset($_SESSION['dni'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}
$dni = $_SESSION['dni'];
$cuenta = isset($_GET['cuenta']) ? $_GET['cuenta'] : null;
$cuenta= htmlspecialchars($cuenta);

if ($cuenta === null) {
    echo '<p>Error: No se ha seleccionado una cuenta.</p>';
    exit;
}
$conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Preparar la consulta para verificar que el DNI corresponde al titular de la cuenta
$sql_verificar = "SELECT c.id_cuenta, c.saldo
                  FROM cuenta c
                  INNER JOIN titularcuenta tc ON c.id_cuenta = tc.id_cuenta
                  WHERE c.id_cuenta = ? AND tc.dni_c = ?";

// Preparar la declaración
$stmt = $conn->prepare($sql_verificar);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

// Vincular los parámetros
$stmt->bind_param('ss', $cuenta, $dni);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$resultado = $stmt->get_result();

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Obtener los detalles de la cuenta
    $row = $resultado->fetch_assoc();
    $saldo = $row['saldo'];
    $sql_todos_numeros_cuenta = "SELECT id_cuenta FROM cuenta";
    $resultado_todos_numeros_cuenta = $conn->query($sql_todos_numeros_cuenta);

    // Almacenar los números de cuenta en un array
    $numeros_cuenta = [];
    if ($resultado_todos_numeros_cuenta->num_rows > 0) {
        while ($fila = $resultado_todos_numeros_cuenta->fetch_assoc()) {
            $numeros_cuenta[] = $fila['id_cuenta'];
        }
    }
    // Codificar los números de cuenta en JSON para usarlos en JavaScript
    $numeros_cuenta_json = json_encode($numeros_cuenta);

} else { 
    echo '<script>
            alert("No puedes realizar transferencias con esta cuenta.");
            history.back();
          </script>';
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="bank.ico">
    <title>Transaccion <?php echo $cuenta; ?></title>
</head>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
<?php echo "<script> var arrayCuenta = '".$numeros_cuenta_json."';</script>"?>
<script>

function verificarSaldo() {
    let cantidad = parseFloat(document.getElementById('cantidad').value);
    let NumCuenta = document.getElementById('numero_cuenta').value;
    let destino = document.getElementById('destinatario').value;
    let regex = /^[a-zA-Z]+$/;
    if (cantidad > <?php echo $saldo;?>) {
        alert("Error: La cantidad ingresada es mayor que el saldo disponible.");
        return false; // Impedir el envío del formulario
    }
    if (regex.test(destino)) {
    } else {
        alert ("El campo destinatario contiene números o caracteres especiales.");
        return false;
    }
    if (arrayCuenta.includes(NumCuenta)) {
        return true; // Permitir el envío del formulario
    } else {
        alert("El numero de cuenta introducido no existe");
        return false;
    }

}
</script>

<body>
    <div class="container"></div>
    <h1>Transferencias CommitBank</h1>
    <div class="column d-flex">

        <form class="formulario" action="procesar_transferencia.php" method="post" onsubmit="return verificarSaldo()">
            <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" state="loop-spin"
                colors="primary:#1b1091,secondary:#0a2e5c" style="width:250px;height:250px">
            </lord-icon>
            <br>
            <div class="login">El número de cuenta escogido es <?php echo $cuenta; ?> <br> Tiene <?php echo $saldo; ?> €
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="numero_cuenta">Número de cuenta destino:</label>
                <input type="text" id="numero_cuenta" class="form-control" name="numero_cuenta" required><br><br>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="destinatario">Destinatario:</label>
                <input type="text" id="destinatario" class="form-control" name="destinatario" required><br><br>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="concepto">Concepto:</label>
                <input type="text" id="concepto" class="form-control" name="concepto" required><br><br>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="concepto">Cantidad:</label>
                <input type="number" id="cantidad" class="form-control" name="cantidad" required><br><br>
            </div>
            <input type="submit" class="btn btn-info button" value="Enviar">
            <div>
                <div class="nocuenta">
                    ¿Has cambiado de opinión? <a href="user.php">Volver a tu cuenta</a>

                </div>
            </div>
        </form>
    </div>
</body>

</html>