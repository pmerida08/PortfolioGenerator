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
            <p>¡Bienvenido <?php echo $data["usuario"]["name"] ?>!</p>
            <img id="avatar" src="/media/<?php echo $data["usuario"]["photo"] ??  "user.jpg" ?>" alt="">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <?php
            echo "<li><a href='/portfolio/" . $_SESSION["usuario"]["id"] . "'>Mi portfolio</a></li>";
            ?>
            <li><a href="/logout">Cerrar sesión</a></li>
        </ul>
    </nav>
    <div class="mainDiv">
        <main>
            <h2>Mi portfolio</h2>
            <?php
            echo "<h2>" . $data["portfolio"]["title"] . "</h2>";
            echo "<img id='photoSmall' src='/media/" . $data["portfolio"]["photo"] . "' alt=''>";
            echo "<div>";
            echo "<h4>Experiencia</h4>";
            if ($data["portfolio"]["id"] == $_SESSION["usuario"]["id"]) {
                echo "<a href='/add/job'>Añadir</a>";
            }
            foreach ($data["portfolio"]["jobs"] as $job) {
                echo "<div class='job'>";
                echo "<h4> Trabajo: " . $job["title"] . "</h4>";
                echo "<a href='/edit/job/" . $job["id"] . "'>Editar</a> <a href='/delete/job/" . $job["id"] . "'>Borrar</a>";
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
            if ($data["portfolio"]["id"] == $_SESSION["usuario"]["id"]) {
                echo "<a href='/add/project'>Añadir</a>";
            }
            foreach ($data["portfolio"]["projects"] as $project) {
                echo "<div class='job'>";
                echo "<h4> Proyecto: " . $project["title"] . "</h4>";
                echo "<a href='/edit/project/" . $project["id"] . "'>Editar</a> <a href='/delete/project/" . $project["id"] . "'>Borrar</a>";
                echo "<ul>";
                echo "<li> Descripcion: " . $project["description"] . "</li>";
                echo "<li> Technologies: " . $project["technologies"] . "</li>";
                echo "</ul>";
                echo "</div>";
            }
            echo "</div>";

            echo "<div>";
            echo "<h4>Skills</h4>";
            if ($data["portfolio"]["id"] == $_SESSION["usuario"]["id"]) {
                echo "<a href='/add/skill'>Añadir</a>";
            }
            foreach ($data["portfolio"]["skills"] as $skill) {
                echo "<div class='job'>";
                echo "<h4> Skill: " . $skill["name"] . "</h4>";
                echo "<a href='/edit/skill/" . $skill["id"] . "'>Editar</a> <a href='/delete/skill/" . $skill["id"] . "'>Borrar</a>";
                echo "</div>";
            }
            echo "</div>";

            echo "<div>";
            echo "<h4>Redes Sociales</h4>";
            if ($data["portfolio"]["id"] == $_SESSION["usuario"]["id"]) {
                echo "<a href='/add/social'>Añadir</a>";
            }
            foreach ($data["portfolio"]["socialNetworks"] as $socialNetwork) {
                echo "<div class='job'>";
                echo "<h4> Red: " . $socialNetwork["name"] . "</h4>";
                echo "<a href='/edit/social/" . $socialNetwork["id"] . "'>Editar</a> <a href='/delete/social/" . $socialNetwork["id"] . "'>Borrar</a>";
                echo "<h5> URL: <a href='" . $socialNetwork["url"] . "' target='_blank'>" . $socialNetwork["url"] . "</a></h5>";
                echo "</div>";
            }
            echo "</div>";
            ?>
        </main>
        <?php
        // if (isset($data["usuario"]["active_account"]) && $data["usuario"]["active_account"] == 1) {
        //     if (isset($perfiles) && count($perfiles) > 0) {
        //         foreach ($perfiles as $perfil) {
        //             if ($perfil["visible"] == 1) {
        //                 echo "<div id='profile'>";
        //                 echo "<img id='photo' src='./media/" . $perfil["photo"] . "' alt=''>";
        //                 echo "<h4>Nombre: " . $perfil["name"] . "</h4>";
        //                 echo "<h5>Apellido: " . $perfil["surname"] . "</h5>";
        //                 echo "<h5>Email: " . $perfil["email"] . "</h5>";


        //TODO
        // if ($data["portfolio"]["skills"][0]["user_id"] == $perfil["id"]) {
        //     echo "<div class='job'>";
        //     echo "<h4> Skill: " . $data["portfolio"]["skills"][0]["name"] . "</h4>";
        //     echo "</div>";
        // }


        //                 echo "</div>";
        //             }
        //         }
        //     } else {
        //         echo "<p>No se encontraron perfiles que coincidan con tu búsqueda.</p>";
        //     }
        // } else {
        //     echo "<p>Tu cuenta no está activa. No puedes realizar búsquedas de perfiles.</p>";
        // }


        ?>

    </div>

</body>

</html>