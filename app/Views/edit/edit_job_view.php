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
        echo "<h2>Editar trabajo</h2>";
        echo "<form action='/edit/job/" . $data["datos"]["id"] . "' method='post'>";
        echo "<label for='title'>Título</label>";
        echo "<input type='text' name='title' id='title' value='" . $data["datos"]["title"] . "'>";
        echo "<br>";
        echo "<label for='description'>Descripción</label>";
        echo "<input type='text' name='description' id='description' value='" . $data["datos"]["description"] . "'>";
        echo "<br>";
        echo "<label for='start_date'>Fecha de inicio</label>";
        echo "<input type='date' name='start_date' id='start_date' value='" . $data["datos"]["start_date"] . "'>";
        echo "<br>";
        echo "<label for='finish_date'>Fecha de fin</label>";
        echo "<input type='date' name='finish_date' id='finish_date' value='" . $data["datos"]["finish_date"] . "'>";
        echo "<br>";
        echo "<label for='achievements'>Logros</label>";
        echo "<input type='text' name='achievements' id='achievements' value='" . $data["datos"]["achievements"] . "'>";
        echo "<br>";
        echo "<input type='submit' value='Editar'>";
        echo "</form>";
        ?>
    </main>
</body>

</html>