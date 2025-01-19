<?php
    use App\Controllers\AuthController;
    use App\Core\Router;
    use App\Controllers\IndexController;

    require_once "../bootstrap.php";
    

    session_start();

    if (!isset($_SESSION['perfil'])) {
        $_SESSION['perfil'] = "invitado";
        $_SESSION['usuario'] = [
            "name" => "Invitado",
            "surname" => "",
            "photo" => "",
            "categoria" => "",
            "email" => "",
            "resumen" => "",
            "visible" => "",
            "updated_at" => ""
        ];
    }

    $router = new Router();
    $router->add(array(
        "name" => "home", // Nombre de la ruta
        "path" => "/^\/$/", // Expresión regular con la que extraemos la ruta de la URL
        "action" => [IndexController::class, "indexAction"], // Clase y metedo que se ejecuta cuando se busque esa ruta
        "auth" => ["usuario"]) // Perfiles de autenticación que pueden acceder
    );

    $router->add(array(
        "name" => "search",
        "path" => "/^\/search$/",
        "action" => [IndexController::class, "searchAction"],
        "auth" => ["usuario"])
    );

    $router->add(array(
        "name" => "visible",
        "path" => "/^\/visibility$/",
        "action" => [IndexController::class, "visibilityAction"],
        "auth" => ["usuario"])
    );

    $router->add(array(
        "name" => "Login",
        "path" => "/^\/login$/", 
        "action" => [AuthController::class, "loginAction"], 
        "auth" => ["invitado"])
    );

    $router->add(array(
        "name" => "Logout",
        "path" => "/^\/logout$/", 
        "action" => [AuthController::class, "logoutAction"], 
        "auth" => ["usuario"])
    );

    $router->add(array(
        "name" => "register",
        "path" => "/^\/register$/", 
        "action" => [AuthController::class, "registerAction"], 
        "auth" => ["invitado"])
    );

    $router->add(array(
        "name" => "Editar",
        "path" => "/^\/edit\/(job|project|skill|social)\/([0-9]+)$/", 
        "action" => [IndexController::class, "editAction"], 
        "auth" => ["usuario"])
    );

    $router->add(array(
        "name" => "Crear",
        "path" => "/^\/add\/(job|project|skill|social)$/", 
        "action" => [IndexController::class, "addAction"], 
        "auth" => ["usuario"])
    );

    $router->add(array(
        "name" => "Delete",
        "path" => "/^\/delete\/(job|project|skill|social)\/([0-9]+)$/",
        "action" => [IndexController::class, "delAction"], 
        "auth" => ["usuario"])
    );

    $request = $_SERVER['REQUEST_URI']; // Recoje URL
    $route = $router->match($request); // Busca en todas las rutas hasta encontrar cual coincide con la URL
    
    if ($route) {
        if (in_array($_SESSION['perfil'], $route['auth'])) {
            $className = $route['action'][0];
            $classMethod = $route['action'][1];
            $object = new $className;
            $object->$classMethod($request);
        } elseif ($_SESSION['perfil'] != "invitado") {
            header("Location: /");
        } else {
            header("Location: /login");
        }
    } else {
        exit(http_response_code(404));
    }
