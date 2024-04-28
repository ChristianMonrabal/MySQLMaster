<?php
// Verificar si se recibió el nombre de la tabla como un parámetro GET
if (isset($_GET['server'], $_GET['username'], $_GET['password'], $_GET['database'], $_GET['table'])) {
    $server = $_GET['server'];
    $username = $_GET['username'];
    $password = $_GET['password'];
    $database = $_GET['database'];
    $table = $_GET['table'];

    // Crear la conexión
    $conn = new mysqli($server, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("<div class='alert alert-danger' role='alert'>Error al conectar a la base de datos: " . $conn->connect_error . "</div>");
    }

    // Obtener la estructura de la tabla seleccionada
    $sql_describe = "DESCRIBE $table";
    $result_describe = $conn->query($sql_describe);

    // Verificar si la consulta fue exitosa
    if ($result_describe) {
        // Mostrar el formulario para insertar datos
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $insert_values = [];
            $columns = [];

            // Obtener los valores de los campos del formulario y construir la consulta de inserción
            while ($row_describe = $result_describe->fetch_assoc()) {
                $column_name = $row_describe['Field'];
                $columns[] = $column_name;
                $value = $_POST[$column_name];
                $insert_values[] = "'$value'";
            }

            $columns_str = implode(",", $columns);
            $values_str = implode(",", $insert_values);

            // Ejecutar la consulta de inserción
            $sql_insert = "INSERT INTO $table ($columns_str) VALUES ($values_str)";
            if ($conn->query($sql_insert) === TRUE) {
                echo "<div class='alert alert-success' role='alert'>Datos insertados correctamente en la tabla $table.</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error al insertar datos: " . $conn->error . "</div>";
            }
        }
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Insertar Datos</title>
            <!-- Bootstrap CSS -->
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    padding-top: 20px;
                    padding-bottom: 20px;
                }

                .container {
                    max-width: 600px;
                    padding: 15px;
                    margin: auto;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2 class="mb-4">Insertar Datos en <?php echo $table; ?></h2>
                <form action="#" method="post">
                    <?php
                    // Mostrar los campos del formulario según la estructura de la tabla
                    $result_describe->data_seek(0); // Reiniciar el puntero del resultado
                    while ($row_describe = $result_describe->fetch_assoc()) {
                        echo "<div class='form-group'>";
                        echo "<label for='" . $row_describe['Field'] . "'>" . $row_describe['Field'] . ":</label>";
                        echo "<input type='text' class='form-control' id='" . $row_describe['Field'] . "' name='" . $row_describe['Field'] . "'>";
                        echo "</div>";
                    }
                    ?>
                    <!-- Campo oculto para almacenar el nombre de la tabla -->
                    <input type="hidden" name="table" value="<?php echo $table; ?>">
                    <button type="submit" class="btn btn-primary">Insertar</button>
                </form>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>

        </html>
<?php
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al obtener la estructura de la tabla: " . $conn->error . "</div>";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "<div class='alert alert-warning' role='alert'>No se han especificado todos los parámetros necesarios.</div>";
}
?>
