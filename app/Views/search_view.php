<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <title>PortManager</title>
    <link rel="stylesheet" href="/css/index.css">
</head>

<?php
$perfiles = $data["perfiles"];
?>

<body>
    <header>
        <h1>PortManager</h1>
        <div class="user">
            <p>¡Bienvenido <?php echo $data["usuario"]["name"] ?? $data["invitadoUser"] ?>!</p>
            <img id="avatar" src="/media/<?php echo $data["img"] ?? "user.jpg" ?>" alt="">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <?php if (!isset($_SESSION["usuario"])) { ?>
                <li><a href="/login">Iniciar sesión</a></li>
                <?php } else {
                echo "<li><a href='/portfolio/" . $_SESSION["usuario"]["id"] . "'>Mi portfolio</a></li>";
                echo "<li><a href='/profile/" . $_SESSION["usuario"]["id"] . "'>Mi perfil</a></li>";
                foreach ($data["perfiles"] as $perfil) { ?>
                    <?php if ($_SESSION["usuario"]["id"] == $perfil["id"]) { ?>
                        <li><a href=" /visibility">
                                <?php echo $perfil["visible"] == 1 ? "Ocultar perfil" : "Mostrar perfil"; ?>
                            </a></li>
                    <?php } ?>
                <?php } ?>
                <li><a href="/logout">Cerrar sesión</a></li>
            <?php }; ?>
            <li>
                <form action="/search/" method="GET">
                    <input type="text" name="termino" id="termino" placeholder="Buscar..." value="<?= $_GET["termino"] ?? '' ?>">
                    <input type="submit" value="Buscar">
                </form>

            </li>
        </ul>
    </nav>
    <div class="mainDiv">
        <main>
            <?php

            echo "<h2>Perfiles</h2>";
            echo "<ul class='portfolios'>";
            foreach ($perfiles as $perfil) {
                if ($perfil["visible"] != 0) {
                    echo "<li id='profile'>";
                    echo "<h3>" . $perfil["name"] . " " . $perfil["surname"] . "</h3>";
                    echo "<img id='photoSmall' src='/media/" . $perfil["photo"] . "' alt=''>";
                    echo "<p>" . $perfil["categoria_profesional"] . "</p>";
                    echo "<a href='/portfolio/" . $perfil["id"] . "'>Ver perfil</a>";
                    echo "</li>";
                }
            }
            echo "</ul>";

            ?>
        </main>
    </div>

</body>

</html>