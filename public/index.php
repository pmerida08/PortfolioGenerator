<?php

use App\Controllers\AuthController;
use App\Core\Router;
use App\Controllers\IndexController;
use App\Controllers\JobsController;
use App\Controllers\PortfolioController;
use App\Controllers\ProfileController;
use App\Controllers\ProjectsController;
use App\Controllers\SkillsController;
use App\Controllers\SocialNetworksController;

require_once "../bootstrap.php";


session_start();

if (!isset($_SESSION['perfil'])) {
    $_SESSION['perfil'] = "invitado";
}



$router = new Router();
$router->add(
    array(
        "name" => "home", // Nombre de la ruta
        "path" => "/^\/$/", // Expresión regular con la que extraemos la ruta de la URL
        "action" => [IndexController::class, "indexAction"], // Clase y metedo que se ejecuta cuando se busque esa ruta
        "auth" => ["usuario", "invitado"] // Perfiles de autenticación que pueden acceder
    ) // Perfiles de autenticación que pueden acceder
);

$router->add(
    array(
        "name" => "search",
        "path" => "/^\/search\/\?termino=([^&]+)$/", // Ruta más flexible para el término de búsqueda
        "action" => [IndexController::class, "searchAction"],
        "auth" => ["usuario", "invitado"]
    )
);



$router->add(
    array(
        "name" => "visible",
        "path" => "/^\/visibility$/",
        "action" => [IndexController::class, "visibilityAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "portfolio",
        "path" => "/^\/portfolio\/([0-9]+)$/",
        "action" => [PortfolioController::class, "indexAction"],
        "auth" => ["usuario", "invitado"]
    )
);

$router->add(
    array(
        "name" => "Login",
        "path" => "/^\/login$/",
        "action" => [AuthController::class, "loginAction"],
        "auth" => ["invitado"]
    )
);

$router->add(
    array(
        "name" => "Logout",
        "path" => "/^\/logout$/",
        "action" => [AuthController::class, "logoutAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "register",
        "path" => "/^\/register$/",
        "action" => [AuthController::class, "registerAction"],
        "auth" => ["invitado"]
    )
);

// Ruta para la activación de la cuenta
$router->add(array(
    "name" => "activate",
    "path" => "/^\/activate\?token=(.*)$/",
    "action" => [AuthController::class, "activateAction"],
    "auth" => ["invitado"]
));


$router->add(
    array(
        "name" => "Editar",
        "path" => "/^\/profile\/([0-9]+)$/",
        "action" => [ProfileController::class, "indexAction"],
        "auth" => ["usuario"]
    )
);


$router->add(
    array(
        "name" => "Editar",
        "path" => "/^\/edit\/job\/([0-9]+)$/",
        "action" => [JobsController::class, "editAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Editar",
        "path" => "/^\/edit\/project\/([0-9]+)$/",
        "action" => [ProjectsController::class, "editAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Editar",
        "path" => "/^\/edit\/skill\/([0-9]+)$/",
        "action" => [SkillsController::class, "editAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Editar",
        "path" => "/^\/edit\/social\/([0-9]+)$/",
        "action" => [SocialNetworksController::class, "editAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Crear",
        "path" => "/^\/add\/job$/",
        "action" => [JobsController::class, "addAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Crear",
        "path" => "/^\/add\/project$/",
        "action" => [ProjectsController::class, "addAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Crear",
        "path" => "/^\/add\/skill$/",
        "action" => [SkillsController::class, "addAction"],
        "auth" => ["usuario"]
    )
);

$router->add(
    array(
        "name" => "Crear",
        "path" => "/^\/add\/social$/",
        "action" => [SocialNetworksController::class, "addAction"],
        "auth" => ["usuario"]
    )
);


$router->add(
    array(
        "name" => "Delete",
        "path" => "/^\/delete\/(job|project|skill|social)\/([0-9]+)$/",
        "action" => [IndexController::class, "delAction"],
        "auth" => ["usuario"]
    )
);

$request = $_SERVER['REQUEST_URI']; // Recoje URL
$route = $router->match($request); // Busca en todas las rutas hasta encontrar cual coincide con la URL

if ($route) {
    if (in_array($_SESSION['perfil'], $route['auth'])) {
        $className = $route['action'][0];
        $classMethod = $route['action'][1];
        $object = new $className;
        $object->$classMethod($request);
    } else {
        exit(http_response_code(403));
    }
} else {
    exit(http_response_code(404));
}
