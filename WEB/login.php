<!DOCTYPE html>
<html lang="en">

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

            if( letraDNI !== letraCalculada){
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

    <div class="container" >
        <div class="column d-flex">
            <div class="lord" onmouseenter="hover2()" onclick="window.location.href='main.html'">
                <lord-icon src="https://cdn.lordicon.com/kkiecexg.json" trigger="in" delay="300" stroke="bold"
                    state="in-reveal" colors="primary:#2516c7,secondary:#30c9e8" style="width:100px;height:100px">
                </lord-icon>
            </div>
            <h1>Inicio de sesión</h1>
        </div>
        <form class="formulario" action="login.php" method="POST" onsubmit="return validarDNI()" >
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
                        placeholder="Clave de acceso" required >
                </div>
                <div class="col-sm-2">
                    <img src="icono.ojo.png" class="icon" height="50vh" width="50vw" id="ojo"
                        onclick=MostrarContraseña()>
                </div>

            </div>
            <button type="submit" class="btn btn-info button">Iniciar Sesión</button>
            <?php
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar credenciales del formulario
        $dni = $_POST["DNI"];
        $clave = $_POST["CLAVE"];
        $servername = "localhost";  // Nombre del servidor (normalmente localhost)
        $database = "basededatos";  // Nombre de la base de datos
        try {
            // Intentar crear la conexión
            $conn = new mysqli($servername, $dni, $clave, $database);
            // Comprobar la conexión
            if ($conn->connect_error) {
                // Si la conexión falla, lanzar una excepción personalizada
                throw new Exception();
            }
            // Si la conexión es exitosa, continuar con el código
            header("Location: main.html");
            exit();
            // Cerrar conexión
            $conn->close();
        } catch (Exception $e) {
            // Capturar la excepción y mostrar un mensaje personalizado
            echo "<p style='color: red;'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>";
            
        }
    }
    ?>
            <div class="nocuenta">
                ¿No tienes cuenta? <a href="register.html">Regístrate</a>
                
            </div>
        </form>

    </div>
</body>

</html>