<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Tablas</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        // Verificar si se recibió el nombre de la base de datos como un parámetro GET
        if (isset($_GET['database']) && !empty($_GET['database'])) {
            $database = $_GET['database'];
            $server = $_GET['server'];
            $username = $_GET['username'];
            $password = $_GET['password'];

            // Crear la conexión
            $conn = new mysqli($server, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("<div class='alert alert-danger' role='alert'>Error al conectar a la base de datos: " . $conn->connect_error . "</div>");
            }

            // Consulta SQL para obtener las tablas de la base de datos especificada
            $sql = "SHOW TABLES FROM $database";

            // Ejecutar la consulta
            $result = $conn->query($sql);

            // Verificar si la consulta fue exitosa
            if ($result) {
                // Mostrar las tablas de la base de datos especificada
                echo "<div class='text-right mb-4 font-weight-bold'>Usuario conectado: <strong>$username</strong></div>";
                echo "<div class='text-center'>"; // Contenedor para centrar el encabezado
                echo "<h2>Tablas de la Base de Datos '$database':</h2>";
                echo "</div>"; 
                echo "<ul class='list-group'>";
                while ($row = $result->fetch_array()) {
                    // Generar enlaces con datos de conexión y nombre de la tabla como parámetros GET
                    echo "<li class='list-group-item'><a href='mostrar_tablas.php?server=$server&username=$username&password=$password&database=$database&table=" . $row[0] . "'>" . $row[0] . "</a></li>";
                }
                echo "</ul>";

                // Verificar si se recibió el nombre de la tabla como un parámetro GET
                if (isset($_GET['table']) && !empty($_GET['table'])) {
                    $table = $_GET['table'];

                    // Consulta SQL para seleccionar todo de la tabla especificada
                    $sql_table = "SELECT * FROM $table";

                    // Ejecutar la consulta
                    $result_table = $conn->query($sql_table);

                    // Verificar si la consulta fue exitosa
                    if ($result_table) {
                        // Mostrar el contenido de la tabla con botones de editar y eliminar
                        echo "<h2 class='mt-5'>Contenido de la tabla '$table' en la Base de Datos '$database':</h2>";
                        echo "<table class='table table-bordered'>";
                        // Mostrar los encabezados de las columnas
                        echo "<thead class='thead-dark'>";
                        echo "<tr>";
                        $fieldinfo = $result_table->fetch_fields();
                        foreach ($fieldinfo as $field) {
                            echo "<th>" . $field->name . "</th>";
                        }
                        // Encabezados de las columnas adicionales para editar y eliminar
                        echo "<th>Editar</th>";
                        echo "<th>Eliminar</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        // Mostrar los datos de la tabla con botones de editar y eliminar
                        while ($row_table = $result_table->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row_table as $column => $value) {
                                echo "<td>$value</td>";
                            }
                            // Obtener automáticamente el id de la fila
                            $id = $row_table['id']; // Asegúrate de reemplazar 'id' con el nombre correcto de tu columna de identificación
                            // Botones de editar y eliminar con el id correspondiente
                            echo "<td><a href='../includes/updates.php?table=$table&id=$id' class='btn btn-primary btn-sm'>Editar</a></td>";
                            echo "<td><a href='../includes/drops.php?table=$table&id=$id' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error al obtener el contenido de la tabla: " . $conn->error . "</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error al obtener las tablas de la base de datos: " . $conn->error . "</div>";
            }

            // Cerrar la resultado y la conexión
            $result->close();
            $conn->close();
        } else {
            echo "<div class='alert alert-warning' role='alert'>No se ha especificado una base de datos.</div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>