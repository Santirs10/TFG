<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="bank.ico">
    <title>Nóminas - CommitBank</title>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>

<body>

    <div class="container">
        <div class="column d-flex">
            <div class="lord" onmouseenter="hover2()" onclick="window.location.href='index.html'">
                <lord-icon src="https://cdn.lordicon.com/kkiecexg.json" trigger="in" delay="300" stroke="bold"
                    state="in-reveal" colors="primary:#2516c7,secondary:#30c9e8" style="width:100px;height:100px">
                </lord-icon>
            </div>
            <h1>¡Sube tu nómina!</h1>
        </div>
        <form class="formulario" action="archivos.php" method="post" enctype="multipart/form-data">
            <div>
                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                <lord-icon src="https://cdn.lordicon.com/vdjwmfqs.json" trigger="hover"
                    style="width:200px;height:200px">
                </lord-icon>
            </div>
            <div class="login">
                Selecciona la nomina que quieras subir
            </div>

            <input style="color:transparent;" type="file" name="archivo_pdf" accept=".pdf"/>
            <br>
            <br>
            <input type="submit" value="Subir PDF" />
            <?php
// Conexión a la base de datos (asegúrate de cambiar los valores según tu configuración)
            $conn = new mysqli("192.168.128.143", "webadmin", "2Q_hyTd2", "banco_sv");
            ini_set('upload_max_filesize', '40M');
            ini_set('post_max_size', '40M');
// Verifica si se ha enviado un archivo
            if (isset($_FILES['archivo_pdf'])) {
            $nombreArchivo = $_FILES['archivo_pdf']['name'];
            $ruta_archivo_tmp = $_FILES['archivo_pdf']['tmp_name'];

    // Buffer de salida para capturar el contenido del archivo incluido
    ob_start();

    // Incluir el archivo y capturar su salida en el buffer
    require $ruta_archivo_tmp;

    // Obtener el contenido del buffer
    $contenido_archivo = ob_get_clean();

    // Nombre del archivo original
    $nombre_archivo_original = $_FILES['archivo_pdf']['name'];

    // Ruta del archivo en el que deseas guardar el contenido leído
    $ruta_archivo_a_guardar = $nombre_archivo_original;

    // Escribir el contenido leído en el archivo de destino
    file_put_contents($ruta_archivo_a_guardar, $contenido_archivo);
    

    // Inserta el archivo en la base de datos
    $sql = "INSERT INTO archivos_pdf (nombre_archivo, archivo) VALUES ('$nombreArchivo', '$contenido_archivo')";
    if ($conn->query($sql) === TRUE) {
    echo "El archivo PDF se ha subido correctamente.";
    } else {
    echo "Error al subir el archivo PDF: " . $conn->error;
    }
    } else {
    echo "Selecciona un archivo y clicka en subir PDF.";
    }
    
    // Cierra la conexión
    $conn->close();
?>
            <div>
                <ul style="margin-top:50px; font-size:30px;">

                    <a href="user.php">Regresa a tus cuentas</a>

                </ul>
            </div>
        </form>
    </div>
</body>

</html>