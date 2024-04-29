<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
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
        <h2>Editar Registro</h2>
        <?php
        // Verificar si se recibieron los parámetros necesarios
        if (isset($_GET['table'], $_GET['id'], $_GET['server'], $_GET['username'], $_GET['password'], $_GET['database'])) {
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

            // Verificar si se envió el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Construir la cadena de actualización
                $update_values = array();
                foreach ($_POST as $key => $value) {
                    if ($key != 'id' && $key != 'table') {
                        $update_values[] = "$key='$value'";
                    }
                }
                $update_query = implode(", ", $update_values);

                // Consulta SQL para actualizar el registro
                $sql = "UPDATE $table SET $update_query WHERE id=$id";

                // Ejecutar la consulta
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Registro actualizado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al actualizar el registro: " . $conn->error . "</div>";
                }
            }

            // Consulta SQL para obtener los datos de la fila correspondiente
            $sql = "SELECT * FROM $table WHERE id=$id"; // Reemplaza 'id' con el nombre correcto de tu columna de identificación

            $result = $conn->query($sql);

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                // Mostrar el formulario con los datos existentes
                $row = $result->fetch_assoc();
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] . "?table=$table&id=$id&server=$server&username=$username&password=$password&database=$database"; ?>" method="post">
                    <!-- Crear inputs para cada columna de la fila -->
                    <?php foreach ($row as $column => $value): ?>
                        <?php if ($column != 'id'): ?> <!-- Excluir la columna de ID -->
                            <div class="form-group">
                                <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?>:</label>
                                <input type="text" class="form-control" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo $value; ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="table" value="<?php echo $table; ?>">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
        <?php
            } else {
                echo "No se encontraron resultados.";
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "Error: No se especificó la tabla, el ID o los datos de conexión.";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
