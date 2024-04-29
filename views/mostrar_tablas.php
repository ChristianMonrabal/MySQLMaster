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
session_start(); // Inicia la sesión si aún no se ha iniciado

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
        echo "<h2>Tablas de la Base de Datos $database</h2>";
        echo "</div>"; 
        echo "<ul class='list-group'>";
        while ($row = $result->fetch_array()) {
            $table = $row[0]; // Inicializar $table con el nombre de la tabla actual
            // Generar enlaces con datos de conexión y nombre de la tabla como parámetros GET
            echo "<li class='list-group-item'><a href='mostrar_tablas.php?server=$server&username=$username&password=$password&database=$database&table=" . $table . "'>" . $table . "</a></li>";
        }
        echo "</ul>";

        // Botones para agregar datos, ver características y ver permisos
        echo "<div class='text-center mt-4'>";
        echo "<div class='btn-group'>";
        echo "<a href='../includes/inserts.php?server=$server&username=$username&password=$password&database=$database&table=" . (isset($table) ? $table : '') . "' class='btn btn-success mr-2'>Insertar datos</a>";
        echo "<a href='../includes/executes.php?server=$server&username=$username&password=$password&database=$database' class='btn btn-primary mr-2'>Consulta</a>";
        echo "<a href='mostrar_tablas.php?server=$server&username=$username&password=$password&database=$database&action=show_characteristics' class='btn btn-info mr-2'>Características</a>";
        echo "<a href='mostrar_tablas.php?server=$server&username=$username&password=$password&database=$database&action=show_grants' class='btn btn-warning'>Ver permisos</a>";
        echo "</div>";
        echo "</div>";

                
                // Verificar si se recibió el nombre de la tabla como un parámetro GET
                if (isset($_GET['table']) && !empty($_GET['table'])) {
                    $_SESSION['selected_table'] = $_GET['table'];
                    $table = $_GET['table'];

                    // Consulta SQL para seleccionar todo de la tabla especificada
                    $sql_table = "SELECT * FROM $table";

                    // Ejecutar la consulta
                    $result_table = $conn->query($sql_table);

                    // Verificar si la consulta fue exitosa
                    if ($result_table) {
                        // Mostrar el contenido de la tabla con botones de editar y eliminar
                        echo "<div class='container mt-5'>";
                        echo "<div class='text-center'>";
                        echo "<h2 class='mt-5'>Contenido de la tabla $table</h2>";
                        echo "</div>";
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
                            $id = $row_table['id']; 
                            // Botones de editar y eliminar con el id correspondiente
                            echo "<td><a href='../includes/updates.php?server=$server&username=$username&password=$password&database=$database&table=$table&id=$id' class='btn btn-primary btn-sm'>Editar</a></td>";
                            echo "<td><a href='../includes/drops.php?server=$server&username=$username&password=$password&database=$database&table=$table&id=$id' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>"; // Cierre del contenedor
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error al obtener el contenido de la tabla: " . $conn->error . "</div>";
                    }
                }                    

                // Verificar si se recibió el parámetro action como un parámetro GET
                if (isset($_GET['action'])) {
                    if ($_GET['action'] === 'show_characteristics') {
                        // Obtener el nombre de la tabla seleccionada de la variable de sesión
                        $table = $_SESSION['selected_table'];

                        // Ejecutar la consulta DESCRIBE
                        $sql_describe = "DESCRIBE $table";
                        $result_describe = $conn->query($sql_describe);

                        // Verificar si la consulta fue exitosa
                        if ($result_describe) {
                            // Mostrar las características de la tabla
                            echo "<div class='container mt-5'>";
                            echo "<div class='text-center'>";
                            echo "<h2>Características de la tabla $table</h2>";
                            echo "<table class='table table-bordered'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th>Field</th>";
                            echo "<th>Type</th>";
                            echo "<th>Null</th>";
                            echo "<th>Key</th>";
                            echo "<th>Default</th>";
                            echo "<th>Extra</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row_describe = $result_describe->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_describe['Field'] . "</td>";
                                echo "<td>" . $row_describe['Type'] . "</td>";
                                echo "<td>" . $row_describe['Null'] . "</td>";
                                echo "<td>" . $row_describe['Key'] . "</td>";
                                echo "<td>" . $row_describe['Default'] . "</td>";
                                echo "<td>" . $row_describe['Extra'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Error al obtener las características: " . $conn->error . "</div>";
                        }
                    } elseif ($_GET['action'] === 'show_grants') {
                        // Ejecutar la consulta SHOW GRANTS
                        $sql_grants = "SHOW GRANTS";
                        $result_grants = $conn->query($sql_grants);

                        // Verificar si la consulta fue exitosa
                        if ($result_grants) {
                            // Mostrar los resultados de SHOW GRANTS en un div con desplazamiento vertical
                            echo "<div class='container mt-5'>";
                            echo "<div class='text-center'>";
                            echo "<h2>Permisos de $username en la base de datos $database</h2>";
                            echo "</div>";
                            echo "<div style='overflow-x: auto;'>";
                            echo "<table class='table table-bordered'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th>Grants</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row_grants = $result_grants->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($row_grants as $grant) {
                                    echo "<td>$grant</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                            echo "</div>"; // Cierre del contenedor
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Error al obtener los permisos: " . $conn->error . "</div>";
                        }
                        
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
