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
                        echo "<h2>Editar trabajo</h2>";
                        echo "<form action='/edit/job/".$data["datos"]["id"]."' method='post'>";
                            echo "<label for='title'>Título</label>";
                            echo "<input type='text' name='title' id='title' value='".$data["datos"]["title"]."'>";
                            echo "<br>";
                            echo "<label for='description'>Descripción</label>";
                            echo "<input type='text' name='description' id='description' value='".$data["datos"]["description"]."'>";
                            echo "<br>";
                            echo "<label for='start_date'>Fecha de inicio</label>";
                            echo "<input type='date' name='start_date' id='start_date' value='".$data["datos"]["start_date"]."'>";
                            echo "<br>";
                            echo "<label for='finish_date'>Fecha de fin</label>";
                            echo "<input type='date' name='finish_date' id='finish_date' value='".$data["datos"]["finish_date"]."'>";
                            echo "<br>";
                            echo "<input type='submit' value='Editar'>";
                        echo "</form>";
                        break;
                    case "project":
                        echo "<h2>Editar proyecto</h2>";
                        echo "<form action='/edit/project/".$data["datos"]["id"]."' method='post'>";
                            echo "<label for='title'>Título</label>";
                            echo "<input type='text' name='title' id='title' value='".$data["datos"]["title"]."'>";
                            echo "<br>";
                            echo "<label for='description'>Descripción</label>";
                            echo "<input type='text' name='description' id='description' value='".$data["datos"]["description"]."'>";
                            echo "<br>";
                            echo "<label for='technologies'>Tecnologias</label>";
                            echo "<input type='text' name='technologies' id='technologies' value='".$data["datos"]["technologies"]."'>";
                            echo "<br>";
                            echo "<input type='submit' value='Editar'>";
                        echo "</form>";
                        break;
                    case "skill":
                        echo "<h2>Editar habilidad</h2>";
                        echo "<form action='/edit/skill/".$data["datos"]["id"]."' method='post'>";
                            echo "<label for='name'>Nombre</label>";
                            echo "<input type='text' name='name' id='name' value='".$data["datos"]["name"]."'>";
                            echo "<br>";
                            echo "<input type='submit' value='Editar'>";
                        echo "</form>";
                        break;
                    case "social":
                        echo "<h2>Editar red social</h2>";
                        echo "<form action='/edit/social/".$data["datos"]["id"]."' method='post'>";
                            echo "<label for='name'>Nombre</label>";
                            echo "<input type='text' name='name' id='name' value='".$data["datos"]["name"]."'>";
                            echo "<br>";
                            echo "<label for='url'>URL</label>";
                            echo "<input type='text' name='url' id='url' value='".$data["datos"]["url"]."'>";
                            echo "<br>";
                            echo "<input type='submit' value='Editar'>";
                        echo "</form>";
                        break;
                }
            ?>
        </main>
    </body>
</html>