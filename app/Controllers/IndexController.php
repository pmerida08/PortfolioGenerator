<?php

namespace App\Controllers;

use App\Models\Jobs;
use App\Models\Projects;
use App\Models\Skills;
use App\Models\SocialNetworks;
use App\Models\Users;

class IndexController extends BaseController
{
    // Acción para mostrar la página de inicio
    public function indexAction()
    {
        $user = Users::getInstancia(); // Obtener la instancia del modelo de usuarios
        $perfiles = $user->getAll(); // Obtener todos los perfiles de usuarios

        // Comprobar si el usuario está logueado
        $usuario = $_SESSION["usuario"] ?? null;
        $userId = $usuario["id"] ?? null;

        // Preparar los datos según si el usuario está logueado o no
        if (isset($usuario)) {
            // Si está logueado, incluir la información del usuario y sus fotos
            $data = [
                "usuario" => $usuario,
                "perfiles" => $perfiles,
                "img" => Users::getInstancia()->getUserById($userId)["photo"], // Obtener la foto del usuario
            ];
        } else {
            // Si no está logueado, mostrar información de invitado
            $data = [
                "invitadoUser" => "Invitado", // Mensaje para usuarios no logueados
                "perfiles" => $perfiles,
            ];
        }

        // Renderizar la vista principal (index_view.php) con los datos preparados
        $this->renderHTML("../app/Views/index_view.php", $data);
    }

    // Acción para eliminar elementos del portafolio (trabajo, proyecto, habilidad, red social)
    public function delAction($request)
    {
        // Separar la URL para obtener el tipo de elemento y el ID del elemento
        $partes = explode('/', $request);
        $elemento = $partes[2]; // Tipo de elemento a eliminar (trabajo, proyecto, habilidad, red social)
        $id = end($partes); // ID del elemento a eliminar

        // Según el tipo de elemento, eliminarlo de la base de datos
        switch ($elemento) {
            case "job":
                $job = Jobs::getInstancia();
                $job->delete($id); // Eliminar el trabajo
                break;
            case "project":
                $project = Projects::getInstancia();
                $project->delete($id); // Eliminar el proyecto
                break;
            case "skill":
                $skill = Skills::getInstancia();
                $skill->delete($id); // Eliminar la habilidad
                break;
            case "social":
                $social = SocialNetworks::getInstancia();
                $social->delete($id); // Eliminar la red social
                break;
        }

        // Redirigir al portafolio del usuario después de eliminar el elemento
        header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
    }

    // Acción para cerrar sesión
    public function logoutAction()
    {
        session_destroy(); // Destruir la sesión, lo que efectivamente cierra la sesión del usuario
        header("Location: /"); // Redirigir al usuario a la página principal
    }

    // Acción para cambiar la visibilidad del perfil del usuario
    public function visibilityAction()
    {
        $user = Users::getInstancia(); // Obtener la instancia del modelo de usuario
        $user_id = $_SESSION["usuario"]["id"]; // Obtener el ID del usuario logueado
        $user->uploadVisible($user_id); // Cambiar la visibilidad del perfil del usuario
        header("Location: /"); // Redirigir a la página principal después de actualizar la visibilidad
    }

    // Acción para realizar una búsqueda de perfiles
    public function searchAction()
    {
        // Recuperar el término de búsqueda desde la URL (parámetro GET)
        $termino = $_GET["termino"] ?? ''; // El valor de búsqueda (por ejemplo, nombre, apellido, etc.)

        // Crear la instancia del modelo de usuarios
        $user = Users::getInstancia();

        // Buscar perfiles que coinciden con el término de búsqueda
        $perfiles = $user->search($termino); // Obtener perfiles que coinciden con el término de búsqueda

        // Obtener la información del usuario si está logueado
        $usuario = $_SESSION["usuario"] ?? null;
        $userId = $usuario["id"] ?? null;

        // Preparar los datos según si el usuario está logueado o no
        if (isset($usuario)) {
            // Si está logueado, incluir su información y foto
            $data = [
                "usuario" => $usuario,
                "perfiles" => $perfiles,
                "img" => Users::getInstancia()->getUserById($userId)["photo"], // Foto del usuario
            ];
        } else {
            // Si no está logueado, mostrar solo los perfiles encontrados
            $data = [
                "invitadoUser" => "Invitado", // Información para el usuario no logueado
                "perfiles" => $perfiles,
            ];
        }

        // Renderizar la vista de resultados de búsqueda (search_view.php)
        $this->renderHTML("../app/Views/search_view.php", $data);
    }
}
