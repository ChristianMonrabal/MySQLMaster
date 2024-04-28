<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Conexión</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <h2 class="mb-4">Inicio de sesión</h2>
        </div>        
        <form action="./views/mostrar.php" method="post" id="login-form">
            <div class="form-group">
                <label for="server">Nombre del servidor:</label>
                <input type="text" class="form-control" id="server" name="server" value="localhost:3306">
                <div class="error-message" id="server-error"></div>
            </div>
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" value="root">
                <div class="error-message" id="username-error"></div>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" value="qweQWE123">
                <div class="error-message" id="password-error"></div>
            </div>
            <div class="form-group">
                <label for="database">Base de Datos:</label>
                <input type="text" class="form-control" id="database" name="database">
                <div class="error-message" id="database-error"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Conectar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>
