<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Conexión</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        // Recibir los datos del formulario
        $server = $_POST['server'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $database = isset($_POST['database']) ? $_POST['database'] : '';

        // Crear la conexión
        $conn = new mysqli($server, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("<div class='alert alert-danger' role='alert'>Error al conectar a la base de datos: " . $conn->connect_error . "</div>");
        }

        // Verificar si se ha especificado una base de datos
        if (!empty($database)) {
            // Consulta SQL para obtener las tablas de la base de datos especificada
            $sql = "SHOW TABLES FROM $database";

            // Ejecutar la consulta
            $result = $conn->query($sql);

            // Verificar si la consulta fue exitosa
            if ($result) {
                // Mostrar las tablas de la base de datos especificada
                echo "<h2 class='mb-4'>Tablas de la Base de Datos '$database':</h2>";
                echo "<ul class='list-group'>";
                while ($row = $result->fetch_array()) {
                    echo "<li class='list-group-item'>" . $row[0] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error al obtener las tablas de la base de datos: " . $conn->error . "</div>";
            }
        } else {
            // Consulta SQL para obtener todas las bases de datos
            $sql = "SHOW DATABASES";

            // Ejecutar la consulta
            $result = $conn->query($sql);

            // Verificar si la consulta fue exitosa
            if ($result) {
                // Mostrar todas las bases de datos disponibles como enlaces
                echo "<div class='text-right mb-4 font-weight-bold'>Usuario conectado: $username</div>";
                echo "<div class='text-center'>"; // Contenedor para centrar el encabezado
                echo "<h2 class='mb-4'>Bases de Datos Disponibles:</h2>";
                echo "</div>"; 
                while ($row = $result->fetch_array()) {
                    // Generar enlaces con datos de conexión como parámetros GET
                    echo "<li class='list-group-item'><a href='mostrar_tablas.php?server=$server&username=$username&password=$password&database=" . $row[0] . "'>" . $row[0] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error al obtener las bases de datos: " . $conn->error . "</div>";
            }
        }

        // Cerrar la resultado y la conexión
        $result->close();
        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
