<?php
session_start();

// Eliminar todas las variables de sesi�n
session_unset();

// Destruir la sesi�n
session_destroy();

// Redirigir al usuario al formulario de inicio de sesi�n
header("Location: index.html");
exit();
?>