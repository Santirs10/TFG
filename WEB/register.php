<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="bank.ico">
    <link rel="stylesheet" href="style.css">

    <title>Registrate</title>


    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script>
    let lord = document.querySelector('.lord');
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

    function MostrarContraseñaConfirmar() {
        if (inputPasswordConfirm.type == "password") {
            inputPasswordConfirm.type = "text";
        } else {
            inputPasswordConfirm.type = "password";
        }
    }

    function ComprobarContraseña() {
        let pass = document.getElementById('inputPassword').value;
        let passConfirm = document.getElementById('inputPasswordConfirm').value;
        let simbolosPassword = ['!', '"', '$', '%', '&', "'", "+", "@", "^", "{", "}", "(", ")"];
        let tieneMayuscula = /[A-Z]/.test(pass);
        let tieneMinuscula = /[a-z]/.test(pass);
        let tieneNumeros = /[0-9]/.test(pass);
        let tieneCaracterEspecial = false;

        // Verificar si la contraseña contiene al menos un carácter especial permitido
        for (let i = 0; i < simbolosPassword.length; i++) {
            if (pass.includes(simbolosPassword[i])) {
                tieneCaracterEspecial = true;
                break;
            }
        }

        if (pass.length >= 8 && tieneMayuscula && tieneMinuscula && tieneNumeros && tieneCaracterEspecial) {
            if (pass == passConfirm) {
                return true;
            } else {
                alert("Error comprobar Contraseña")
            }
        } else {
            alert(
                "La contraseña tiene que ser de mínimo 8 caracteres y tener mayúsculas, minúsculas y caracteres especiales"
            )
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
            <h1>Únete</h1>
        </div>
        <form class="formulario" action="register.php" method="POST" onsubmit="return validarDNI()">
            <div>
                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                <lord-icon src="https://cdn.lordicon.com/kthelypq.json" trigger="click"
                    style="width:200px;height:200px">
                </lord-icon>
            </div>
            <div class="login">
                Bienvenido al CommitBank
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su email</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputemail" name="email" placeholder="ejemplo@email.com"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su DNI</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputDNI" name="DNI" placeholder="DNI" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su Nombre</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputNombre" name="Nombre" placeholder="Nombre"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su Dirección</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputDireccion" name="Direccion"
                        placeholder="C/ Ejemplo" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca su primer Apellido</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputAp1" name="Apellido1" placeholder="Apellido"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca el segundo apellido</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputAp2" name="Apellido2" placeholder="Apellido2">
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Introduzca un número de teléfono</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="inputTLF" name="Tlf" placeholder="+34">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Clave de Acceso</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="inputPassword" name="CLAVE_CLARO"
                        placeholder="Clave de acceso" required>
                </div>
                <div class="col-sm-2">
                    <img src="icono.ojo.png" class="icon" height="50vh" width="50vw" id="ojo"
                        onclick=MostrarContraseña()>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Confirmar Clave de Acceso</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="inputPasswordConfirm"
                        placeholder="Confirmar Clave de acceso" required>
                </div>
                <div class="col-sm-2">
                    <img src="icono.ojo.png" class="icon" height="50vh" width="50vw" id="ojo"
                        onclick=MostrarContraseñaConfirmar()>
                </div>
            </div>
            <button type="submit" class="btn btn-info button" onclick="ComprobarContraseña()">Únete</button>
            <?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $ipUsuario = $_SERVER['REMOTE_ADDR'];
    $DNI = $_POST["DNI"];
    $NOMBRE = $_POST["Nombre"];
    $APELLIDO1 = $_POST["Apellido1"];
    $APELLIDO2 = $_POST["Apellido2"];
    $DIRECCION = $_POST["Direccion"];
    $EMAIL = $_POST["email"];

    $NUM_TLF= $_POST["Tlf"];

    $CLAVE_CL = $_POST["CLAVE_CLARO"]; // Contraseña que se encripta en mysql
    echo " <br>IP: ";
    echo $ipUsuario;
    // Conectar a la base de datos (ajusta según tu configuración)
    try {
        $conn = new mysqli("192.168.1.143", "webadmin", "2Q_hyTd2", "banco_sv");
        // Verificar la conexión
        if ($conn->connect_error) {
            throw new Exception("No se pudo conectar a la base de datos. Por favor, inténtalo de nuevo más tarde.");
        }

        // Verificar si el DNI ya existe en la base de datos
        $check_query = "SELECT COUNT(*) AS count FROM clientes WHERE dni_cliente = '$DNI'";
        $check_result = $conn->query($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $row = $check_result->fetch_assoc();
            if ($row['count'] > 0) {
                echo "<p style='color: red;'>Ya existe un cliente con ese DNI en nuestra base de datos.<a href='login.php'>Inicia sesión</a> con un DNI válido</p>";
                exit(); // Salir del script si ya existe un cliente con ese DNI
            }
        }

        // Insertar datos en la tabla
        $sql = "INSERT INTO clientes (dni_cliente, email, clave, nombre, apellido1, apellido2, direccion,num_telefono) VALUES ('$DNI', '$EMAIL', aes_encrypt('$CLAVE_CL','password'),'$NOMBRE','$APELLIDO1','$APELLIDO2','$DIRECCION','$NUM_TLF')";
        if ($conn->query($sql) === TRUE) {  
            echo "<p>Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.</p>";
        } else {
            echo "Error al ejecutar la consulta: " . $conn->error;
        }
        
        // Cerrar conexión
        $conn->close();
    } catch (Exception $e) {
        // Si hay algún otro error, manejarlo aquí
        echo "<p style='color: red;'>Se produjo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.</p>";
    }
}
?>

            <div class="nocuenta">
                ¿Ya tienes cuenta?<a href="login.php">Inicia Sesión</a>
            </div>
        </form>

    </div>
    <footer>
        <div class="container">
            &copy; 2024 CommitBank. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>