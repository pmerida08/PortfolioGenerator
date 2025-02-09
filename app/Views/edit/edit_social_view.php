<?php
if ($_SESSION["usuario"]["id"] != $data["datos"]["user_id"]) {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <title>PortManager</title>
    <link rel="stylesheet" href="../../css/edit.css">
</head>

<body>
    <header>
        <h1>PortManager</h1>
        <p>¡Bienvenido <?php echo $data["usuario"]["name"] ?>!</p>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
    </nav>
    <main>
        <h2>Mi portfolio</h2>
        <?php
        echo "<h2>Editar red social</h2>";
        echo "<form action='/edit/social/" . $data["datos"]["id"] . "' method='post'>";
        echo "<label for='name'>Nombre</label>";
        echo "<input type='text' name='name' id='name' value='" . $data["datos"]["name"] . "'>";
        echo "<br>";
        echo "<label for='url'>URL</label>";
        echo "<input type='text' name='url' id='url' value='" . $data["datos"]["url"] . "'>";
        echo "<br>";
        echo "<input type='submit' value='Editar'>";
        echo "</form>";
        ?>
    </main>
</body>

</html>