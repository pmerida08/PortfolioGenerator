<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <header>
        <h1>PortManager</h1>
        <h2>Inicio de sesión</h2>
    </header>
    <main>
        <p style="color: red"> <?php echo $data["message"] ?></p>
        <form action="/login" method="post">
            <label for="email">Email
                <input type="email" name="email" id="email" required>
            </label>

            <label for="password">Contraseña
                <input type="password" name="password" id="password" required>
            </label>


            <input type="submit" value="Enviar">
        </form>
        <div class="forgot">
            <p>¿No tienes cuenta?</p>
            <a href="/register">Registrarse ahora</a>
        </div>
    </main>
</body>

</html>