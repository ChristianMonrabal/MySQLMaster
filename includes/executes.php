<?php
// Inicia la sesión si aún no se ha iniciado
session_start();

// Verificar si se recibieron los datos de conexión como parámetros GET
if (isset($_GET['server'], $_GET['username'], $_GET['password'], $_GET['database'])) {
    // Almacena los datos de conexión en variables de sesión
    $_SESSION['server'] = $_GET['server'];
    $_SESSION['username'] = $_GET['username'];
    $_SESSION['password'] = $_GET['password'];
    $_SESSION['database'] = $_GET['database'];
}

// Verifica si se envió una consulta SQL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["query"])) {
    // Verifica si existen los datos de conexión en las variables de sesión
    if (isset($_SESSION['server'], $_SESSION['username'], $_SESSION['password'], $_SESSION['database'])) {
        // Obtiene la consulta SQL enviada por el formulario
        $query = $_POST['query'];

        // Obtiene los datos de conexión de las variables de sesión
        $server = $_SESSION['server'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $database = $_SESSION['database'];

        // Crea la conexión
        $conn = new mysqli($server, $username, $password, $database);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("<div class='alert alert-danger mt-3' role='alert'>Error al conectar a la base de datos: " . $conn->connect_error . "</div>");
        }

        // Ejecuta la consulta
        $result = $conn->query($query);

        if ($result === TRUE) {
            echo "<div class='alert alert-success mt-3' role='alert'>Consulta ejecutada correctamente.</div>";
        } elseif ($result === FALSE) {
            echo "<div class='alert alert-danger mt-3' role='alert'>Error al ejecutar la consulta: " . $conn->error . "</div>";
        } else {
            // Muestra resultados si la consulta es un SELECT
            if ($result->num_rows > 0) {
                echo "<h2 class='mt-4'>Resultados de la consulta:</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table'>";
                // Muestra encabezados de columnas
                echo "<thead><tr>";
                while ($field = $result->fetch_field()) {
                    echo "<th>{$field->name}</th>";
                }
                echo "</tr></thead>";
                // Muestra datos de filas
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>{$value}</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div class='alert alert-info mt-3' role='alert'>La consulta no devolvió resultados.</div>";
            }
        }

        // Cierra la conexión
        $conn->close();
    } else {
        echo "<div class='alert alert-danger mt-3' role='alert'>Error: No se han proporcionado datos de conexión.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejecutar Consulta SQL</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Ejecutar Consulta SQL</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="query">Consulta SQL:</label>
                        <input type="text" class="form-control" id="query" name="query" value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ejecutar Consulta</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
