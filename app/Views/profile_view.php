<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <title>PortManager</title>
    <link rel="stylesheet" href="/css/profile.css">
</head>

<body>
    <header>
        <h1>PortManager</h1>
        <div class="user">
            <p>¡Bienvenido <?php echo $data["usuario"]["name"] ?>!</p>
            <img id="avatar" src="/media/<?php echo $data["usuario"]["photo"] ?? "user.jpg" ?>" alt="">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/portfolio/<?php echo $_SESSION["usuario"]["id"] ?>">Mi portfolio</a></li>
            <li><a href="/perfil/<?php echo $_SESSION["usuario"]["id"] ?>">Mi perfil</a></li>
            <li><a href="/logout">Cerrar sesión</a></li>
        </ul>
    </nav>
    <div class="mainDiv">
        <main>
            <!-- Asegurarse de agregar enctype="multipart/form-data" para permitir la carga de archivos -->
            <h2>Mi perfil</h2>
            <form action="" method="POST">
                <div>
                    <label for="name">Nombre</label><br><br>
                    <input type="text" name="name" id="name" value="<?php echo $data["usuario"]["name"] ?>">

                    <label for="surname">Apellido</label><br><br>
                    <input type="text" name="surname" id="surname" value="<?php echo $data["usuario"]["surname"] ?>">
                </div>

                <div>
                    <label for="email">Email</label><br><br>
                    <input type="email" name="email" id="email" value="<?php echo $data["usuario"]["email"] ?>">
                </div>

                <div>
                    <label for="photo">Selecciona una nueva foto</label><br><br>
                    <img id="photoSmall" src="/media/<?php echo $data['usuario']['photo'] ?>" alt="">
                    <input type="file" name="photo" id="photo">
                </div>

                <div>
                    <label for="profile_summary">Actualiza tu resumen</label><br><br>
                    <textarea name="profile_summary" id="profile_summary"><?php echo $data["usuario"]["profile_summary"] ?></textarea>
                </div>

                <div>
                    <label for="categoria_profesional">Nueva categoría profesional</label><br><br>
                    <input type="text" name="categoria_profesional" id="categoria_profesional" value="<?php echo $data['usuario']['categoria_profesional'] ?>">
                </div>

                <input type="submit" value="Guardar" name="editarPerfil">
            </form>
        </main>
    </div>
</body>

</html>