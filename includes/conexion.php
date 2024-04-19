<?php
// Recuperar los datos del formulario
$servidor = $_POST['servidor'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$basedatos = $_POST['basedatos'] ?? '';

// Crear la conexión a MySQL
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Iniciar sesión
session_start();

// Almacenar el nombre de la base de datos en la sesión
$_SESSION['basedatos'] = $basedatos;

// Redirigir según si se proporcionó una base de datos o no
if (empty($basedatos)) {
    header("Location: ../views/show_databases.php");
    exit;
} else {
    header("Location: ../views/show_tables.php");
    exit;
}
?>
