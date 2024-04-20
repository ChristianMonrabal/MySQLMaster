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
        <h2 class="text-center mb-4">Ejecutar Consulta SQL</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="query">Consulta SQL:</label>
                        <input type="text" class="form-control" id="query" name="query" required>
                    </div>
                    <!-- Campos ocultos para enviar los datos de conexión -->
                    <input type="hidden" name="server" value="<?php echo $_GET['server']; ?>">
                    <input type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
                    <input type="hidden" name="password" value="<?php echo $_GET['password']; ?>">
                    <input type="hidden" name="database" value="<?php echo $_GET['database']; ?>">
                    <button type="submit" class="btn btn-primary">Ejecutar Consulta</button>
                </form>
            </div>
        </div>

        <?php
        // Bloque de código PHP para mostrar los resultados de la consulta
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["query"])) {
            // Obtener los datos del formulario y ejecutar la consulta
            $server = $_POST['server'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $database = $_POST['database'];
            $query = $_POST['query'];

            // Crear la conexión
            $conn = new mysqli($server, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("<div class='alert alert-danger mt-3' role='alert'>Error al conectar a la base de datos: " . $conn->connect_error . "</div>");
            }

            // Ejecutar la consulta
            $result = $conn->query($query);

            if ($result === TRUE) {
                echo "<div class='alert alert-success mt-3' role='alert'>Consulta ejecutada correctamente.</div>";
            } elseif ($result === FALSE) {
                echo "<div class='alert alert-danger mt-3' role='alert'>Error al ejecutar la consulta: " . $conn->error . "</div>";
            } else {
                // Mostrar resultados si la consulta es un SELECT
                if ($result->num_rows > 0) {
                    echo "<h2 class='mt-4'>Resultados de la consulta:</h2>";
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    // Mostrar encabezados de columnas
                    echo "<thead><tr>";
                    while ($field = $result->fetch_field()) {
                        echo "<th>{$field->name}</th>";
                    }
                    echo "</tr></thead>";
                    // Mostrar datos de filas
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

            // Cerrar la conexión
            $conn->close();
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
