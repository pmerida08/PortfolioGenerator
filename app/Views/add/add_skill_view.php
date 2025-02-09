<!DOCTYPE html>
<html lang=es>

<head>
    <meta charset=UTF-8>
    <meta name=viewport content=width=device-width, initial-scale=1.0>
    <meta name=author content=Pablo>
    <title>PortManager</title>
    <link rel=stylesheet href=../css/add.css>
</head>

<body>
    <header>
        <h1>PortManager</h1>
        <p>¡Bienvenido <?php  echo $data["usuario"]["name"] ?>!</p>
    </header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
    </nav>
    <main>
        <h2>Mi portfolio</h2>

        <h2>Añadir habilidad</h2>
        <form action='/add/skill' method='post'>
            <label for='name'>Nombre</label>
            <input type='text' name='name' id='name'>
            <br>
            <input type='submit' value='Añadir'>
        </form>
    </main>
</body>

</html>