<!DOCTYPE html>
<html lang=es>

<head>
    <meta charset=UTF-8>
    <meta name=viewport content=width=device-width, initial-scale=1.0>
    <meta name=author content=Pablo>
    <title>PortManager</title>
    <link rel=stylesheet href=../../css/add.css>
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
        <h2>Añadir trabajo</h2>
        <form action='/add/job' method='post'>
            <label for='title'>Título</label>
            <input type='text' name='title' id='title'>
            <br>
            <label for='description'>Descripción</label>
            <input type='text' name='description' id='description'>
            <br>
            <label for='start_date'>Fecha de inicio</label>
            <input type='date' name='start_date' id='start_date'>
            <br>
            <label for='finish_date'>Fecha de fin</label>
            <input type='date' name='finish_date' id='finish_date'>
            <br>
            <label for='achievements'>Logros</label>
            <input type='text' name='achievements' id='achievements'>
            <br>
            <input type='submit' value='Añadir'>
        </form>
    </main>
</body>

</html>