<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <title>Register</title>
    <link rel="stylesheet" href="./css/register.css">
</head>

<body>
    <header>
        <h1>PortManager</h1>
        <h2>Registrarse</h2>
    </header>
    <main>
        <form action="" method="post">
            <p id="error"><?= $data["message"] ?? "" ?></p>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="Kepa" required>
            <br>
            <label for="surname">Apellidos</label>
            <input type="text" name="surname" id="surname" value="Arrizabalaga" required>
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="a21mevepa@iesgrancapitan.org" required>
            <br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" value="1234" required>
            <br>
            <label for="password2">Repite la contraseña</label>
            <input type="password" name="password2" id="password2" value="1234" required>
            <br>
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo">
            <br>
            <label for="categoria">Categoría</label>
            <input type="text" name="categoria_profesional" id="categoria_profesional" value="Web dev">
            <br>
            <input type="submit" value="Enviar" name="registrar">
        </form>
        <div class="forgot">
            <p>¿Ya tienes cuenta?</p>
            <a href="/login">Iniciar sesión</a>
        </div>
    </main>
</body>

</html>