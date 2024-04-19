<?php
// Iniciar sesión
session_start();

// Obtener el nombre de la base de datos de la sesión
$basedatos = $_SESSION['basedatos'] ?? '';

// Verificar si se ha seleccionado una base de datos
if (!empty($basedatos)) {
    // Crear la conexión a MySQL
    $conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

    // Consultar las tablas de la base de datos seleccionada
    $resultado = $conexion->query("SHOW TABLES");

    if ($resultado) {
        echo "<h2>Tablas en la base de datos '$basedatos'</h2>";
        echo "<ul>";
        while ($fila = $resultado->fetch_array()) {
            echo "<li>{$fila[0]}</li>";
        }
        echo "</ul>";
        $resultado->free(); // Liberar el resultado
    } else {
        echo "Error al obtener las tablas de la base de datos: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    echo "No se ha seleccionado una base de datos.";
}
?>
