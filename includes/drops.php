<?php
// Verificar si se recibió el nombre de la tabla y el ID como parámetros GET
if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['server']) && isset($_GET['username']) && isset($_GET['password']) && isset($_GET['database'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];
    $server = $_GET['server'];
    $username = $_GET['username'];
    $password = $_GET['password'];
    $database = $_GET['database'];

    // Realizar la conexión a la base de datos
    $conn = new mysqli($server, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar la fila correspondiente
    $sql = "DELETE FROM $table WHERE id=$id"; 
    
    if ($conn->query($sql) === TRUE) {
        echo "La fila ha sido eliminada correctamente.";
    } else {
        echo "Error al eliminar la fila: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error: No se especificó la tabla, el ID o los datos de conexión.";
}
?>
