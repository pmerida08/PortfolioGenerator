<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Pablo">
        <title>PortManager</title>
        <link rel="stylesheet" href="../css/add.css">
    </head>
    <body>
        <header>
            <h1>PortManager</h1>
            <p>¡Bienvenido <?php echo $data["usuario"] ?>!</p>
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
                switch ($data["elemento"]) {
                    case "job":
                        echo "<h2>Añadir trabajo</h2>";
                        echo "<form action='/add/job' method='post'>";
                            echo "<label for='title'>Título</label>";
                            echo "<input type='text' name='title' id='title'>";
                            echo "<br>";
                            echo "<label for='description'>Descripción</label>";
                            echo "<input type='text' name='description' id='description'>";
                            echo "<br>";
                            echo "<label for='start_date'>Fecha de inicio</label>";
                            echo "<input type='date' name='start_date' id='start_date'>";
                            echo "<br>";
                            echo "<label for='finish_date'>Fecha de fin</label>";
                            echo "<input type='date' name='finish_date' id='finish_date'>";
                            echo "<br>";
                            echo "<label for='achievements'>Logros</label>";
                            echo "<input type='text' name='achievements' id='achievements'>";
                            echo "<br>";
                            echo "<input type='submit' value='Añadir'>";
                        echo "</form>";
                        break;
                    case "project":
                        echo "<h2>Añadir proyecto</h2>";
                        echo "<form action='/add/project' method='post'>";
                            echo "<label for='title'>Título</label>";
                            echo "<input type='text' name='title' id='title'>";
                            echo "<br>";
                            echo "<label for='description'>Descripción</label>";
                            echo "<input type='text' name='description' id='description'>";
                            echo "<br>";
                            echo "<label for='technologies'>Tecnologías</label>";
                            echo "<input type='text' name='technologies' id='technologies'>";
                            echo "<br>";
                            echo "<input type='submit' value='Añadir'>";
                        echo "</form>";
                        break;
                    case "skill":
                        echo "<h2>Añadir habilidad</h2>";
                        echo "<form action='/add/skill' method='post'>";
                            echo "<label for='name'>Nombre</label>";
                            echo "<input type='text' name='name' id='name'>";
                            echo "<br>";
                            echo "<input type='submit' value='Añadir'>";
                        echo "</form>";
                        break;
                    case "social":
                        echo "<h2>Añadir red social</h2>";
                        echo "<form action='/add/social' method='post'>";
                            echo "<label for='name'>Nombre</label>";
                            echo "<input type='text' name='name' id='name'>";
                            echo "<br>";
                            echo "<label for='url'>URL</label>";
                            echo "<input type='text' name='url' id='url'>";
                            echo "<br>";
                            echo "<input type='submit' value='Añadir'>";
                        echo "</form>";
                        break;
                }
            ?>
        </main>
    </body>
</html>