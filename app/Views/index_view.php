<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Pablo">
        <title>PortManager</title>
        <link rel="stylesheet" href="./css/index.css">
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
                echo "<h2>" . $data["portfolio"]["title"] . "</h2>";

                echo "<div>";
                    echo "<h4>Experiencia</h4>"; 
                    echo "<a href='/add/job'>Añadir</a>";
                    foreach ($data["portfolio"]["jobs"] as $job) {
                        echo "<div class='job'>";
                            echo "<h4> Trabajo: " . $job["title"] . "</h4>";
                            echo "<a href='/edit/job/".$job["id"]."'>Editar</a> <a href='/delete/job/".$job["id"]."'>Borrar</a>";
                            echo "<ul>";
                                echo "<li> Descripcion: " . $job["description"] . "</li>";
                                echo "<li> Fecha de Inicio: " . $job["start_date"] . "</li>";
                                echo "<li> Fecha de Fin: " . $job["finish_date"] . "</li>";
                                echo "<li> Logros: " . $job["achievements"] . "</li>";
                            echo "</ul>";
                        echo "</div>";
                    }
                echo "</div>";

                echo "<div>";
                    echo "<h4>Proyectos</h4>";
                    echo "<a href='/add/project'>Añadir</a>";
                    foreach ($data["portfolio"]["projects"] as $project) {
                        echo "<div class='job'>";
                            echo "<h4> Proyecto: " . $project["title"] . "</h4>";
                            echo "<a href='/edit/project/".$project["id"]."'>Editar</a> <a href='/delete/project/".$project["id"]."'>Borrar</a>";
                            echo "<ul>";
                                echo "<li> Descripcion: " . $project["description"] . "</li>";
                                echo "<li> Technologies: " . $project["technologies"] . "</li>";
                            echo "</ul>";
                        echo "</div>";
                    }
                echo "</div>";
            
                echo "<div>";
                    echo "<h4>Skills</h4>";
                    echo "<a href='/add/skill'>Añadir</a>";
                    foreach ($data["portfolio"]["skills"] as $skill) {
                        echo "<div class='job'>";
                            echo "<h4> Skill: " . $skill["name"] . "</h4>";
                            echo "<a href='/edit/skill/".$skill["id"]."'>Editar</a> <a href='/delete/skill/".$skill["id"]."'>Borrar</a>";
                        echo "</div>";
                    }
                echo "</div>";
            
                echo "<div>";
                    echo "<h4>Redes Sociales</h4>";
                    echo "<a href='/add/social'>Añadir</a>";
                    foreach ($data["portfolio"]["socialNetworks"] as $socialNetwork) {
                        echo "<div class='job'>";
                            echo "<h4> Red: " . $socialNetwork["name"] . "</h4>";
                            echo "<a href='/edit/social/".$socialNetwork["id"]."'>Editar</a> <a href='/delete/social/".$socialNetwork["id"]."'>Borrar</a>";
                            echo "<h5> URL: <a href='".$socialNetwork["url"]."' target='_blank'>".$socialNetwork["url"]."</a></h5>";
                        echo "</div>";    
                    }
                echo "</div>";
            ?>
        </main>
    </body>
</html>