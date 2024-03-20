<?php
            error_reporting(E_ALL);
            session_start();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar credenciales del formulario
                $dni = $_POST["DNI"];
                $clave = $_POST["CLAVE"];
                
    // Datos de conexión
                $servername = "198.128.168.143";  // Nombre del servidor (IP)
                $database = "banco_sv";  // Nombre de la base de datos (Use world)
                $username = "webadmin";  // Nombre de usuario de MySQL (usuario que solo pueda leer)
                $password = "2Q_hyTd2";  // Contraseña de MySQL cambiada
                $PassVerify=FALSE;
            try {
        $conn = new mysqli("192.168.128.143", "webadmin", "2Q_hyTd2", "banco_sv");

        // Comprobar la conexión
        if ($conn->connect_error) {
            // Si la conexión falla, lanzar una excepción personalizada
            throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
        }
        
        // Consulta SQL para buscar en la base de datos
        $sql = "SELECT * FROM clientes WHERE dni_cliente='$dni' ";
        $result = $conn->query($sql);
        // Comprobar si la consulta devolvió algún resultado
        if ($result->num_rows > 0) {
            // Si hay resultados, redirigir a otra página
            $fila = $result->fetch_assoc();
            $clave_almacenada = $fila["clave"];
            
        } else {
            // Si no hay resultados, mostrar un mensaje de error
            $error= "<p style='color: red;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
        }
        
        $sql = "SELECT * FROM clientes WHERE dni_cliente='$dni'AND aes_decrypt('$clave_almacenada','password')='$clave'";
        $result = $conn->query($sql);
        echo $sql;
        //La consulta no devuelve nada cuando intentas inyeccion SQL
        if ($result->num_rows > 0) {  
            $_SESSION['dni'] = $dni;
            echo "<meta http-equiv='refresh' content='0; url=user.php'>";
            exit();
        }
        else{
             
            $error= "<p style='color: red;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
        }
        if ($conn) {
            $conn->close();
        }
    } catch (Exception $e) {
        //Mostrar un mensaje personalizado de error
        echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    }
    
    // Cerrar conexión

}
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
    <title>Inicio de Sesión</title>


    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script>
    let lord = document.querySelector('.lord');
    let pass = document.getElementById('inputPassword').value;
    let ojo = document.getElementById('ojo');

    function cambiarTrigger() {
        let lordIcon = document.querySelector('.lord lord-icon');
        lordIcon.setAttribute('trigger', 'hover');
    }

    function hover2() {
        let lordIcon = document.querySelector('.lord lord-icon');
        lordIcon.setAttribute('trigger', 'hover');
        lordIcon.setAttribute('state', 'in');
    }

    function validarDNI() {
        let dniInput = document.getElementById('inputDNI').value;
        let letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        let numeroDNI = dniInput.substring(0, 8);
        let letraDNI = dniInput.substring(8).toUpperCase();

        if (numeroDNI.length !== 8 || letraDNI.length !== 1) {
            alert("Longitud de DNI incorrecta")
            return false; // Longitud incorrecta
        }

        let letraCalculada = letras[numeroDNI % 23];

        if (letraDNI !== letraCalculada) {
            alert("Escribe el DNI correcto")
            return false
        };
    }

    function comprobarDNI() {
        dniInput = document.getElementById('inputDNI').value;
        if (validarDNI()) {
            alert('El DNI es válido.');
        } else {
            alert('El DNI no es válido.');
        }
    }

    function MostrarContraseña() {
        if (inputPassword.type == "password") {
            inputPassword.type = "text";
        } else {
            inputPassword.type = "password";
        }
    }
    </script>
</head>

<body>

    <div class="container">
        <div class="column d-flex">
            <div class="lord" onmouseenter="hover2()" onclick="window.location.href='index.html'">
                <lord-icon src="https://cdn.lordicon.com/kkiecexg.json" trigger="in" delay="300" stroke="bold"
                    state="in-reveal" colors="primary:#2516c7,secondary:#30c9e8" style="width:100px;height:100px">
                </lord-icon>
            </div>
            <h1>Inicio de sesión</h1>
        </div>
        <form class="formulario" action="login.php" method="POST">
            <div>
                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                <lord-icon src="https://cdn.lordicon.com/kthelypq.json" trigger="click"
                    style="width:200px;height:200px">
                </lord-icon>
            </div>
            <div class="login">
                Bienvenido al nano-banco
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su DNI</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="DNI" id="inputDNI" placeholder="DNI" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Clave de Acceso</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="CLAVE" id="inputPassword"
                        placeholder="Clave de acceso" required>
                </div>
                <div class="col-sm-2">
                    <img src="icono.ojo.png" class="icon" height="50vh" width="50vw" id="ojo"
                        onclick=MostrarContraseña()>
                </div>

            </div>
            <button type="submit" class="btn btn-info button">Iniciar Sesión</button>
            <?php  echo $error ?>
            <div class="nocuenta">
                ¿No tienes cuenta?<a href="register.php">Regístrate</a>

            </div>
        </form>

    </div>
</body>

</html>