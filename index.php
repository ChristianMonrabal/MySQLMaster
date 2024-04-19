<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Conexión</title>
</head>
<body>
    <h2>Formulario de Conexión</h2>
    <form action="./includes/conexion.php" method="post">
        <label for="servidor">IP o nombre del servidor:</label><br>
        <input type="text" id="servidor" name="servidor" value="localhost:3306" required><br><br>

        <label for="usuario">Usuario:</label><br>
        <input type="text" id="usuario" name="usuario" value="root" required><br><br>

        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" value="qweQWE123" required><br><br>

        <label for="basedatos">Base de datos:</label><br>
        <input type="text" id="basedatos" name="basedatos"><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
