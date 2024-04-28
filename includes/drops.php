<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Registro</title>
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
        <h2 class="text-center">Eliminar Registro</h2>
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
                die("<div class='alert alert-danger text-center' role='alert'>Error de conexión: " . $conn->connect_error . "</div>");
            }

            // Consulta SQL para eliminar la fila correspondiente
            $sql = "DELETE FROM $table WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success text-center' role='alert'>La fila ha sido eliminada correctamente.</div>";
            } else {
                echo "<div class='alert alert-danger text-center' role='alert'>Error al eliminar la fila: " . $conn->error . "</div>";
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "<div class='alert alert-danger text-center' role='alert'>Error: No se especificó la tabla, el ID o los datos de conexión.</div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
