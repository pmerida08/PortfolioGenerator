<?php

namespace App\Controllers;

use App\Models\Jobs;
use App\Models\Users;

class JobsController extends BaseController
{
    // Acción para editar un trabajo específico
    public function editAction($request)
    {
        // Separa la URL para obtener el ID del trabajo
        $partes = explode('/', $request);
        $elemento = end($partes); // Obtener el ID del trabajo (elemento)

        // Instanciar los modelos necesarios (trabajo y usuario)
        $jobModel = Jobs::getInstancia();
        $userModel = Users::getInstancia();

        // Obtener el ID del usuario relacionado con este trabajo
        $userIdJob = $jobModel->getUserId($elemento); // Obtener el ID de usuario asociado al trabajo
        $usuario = $userModel->get($userIdJob); // Obtener la información del usuario asociado

        // Verificar que el trabajo pertenece al usuario logueado
        if ($userIdJob !== $_SESSION["usuario"]["id"]) {
            // Si el usuario no es dueño del trabajo, redirigir a la página de inicio
            header("Location: /");
            exit();
        }

        // Si se recibe un formulario POST para actualizar el trabajo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            // Establecer los nuevos datos para el trabajo
            $jobModel->setId($elemento);
            $jobModel->setTitle($_POST["title"] ?? ''); // Título del trabajo
            $jobModel->setDescription($_POST["description"] ?? ''); // Descripción del trabajo
            $jobModel->setStartDate($_POST["start_date"] ?? ''); // Fecha de inicio
            $jobModel->setFinishDate($_POST["finish_date"] ?? ''); // Fecha de finalización
            $jobModel->setAchievements($_POST["achievements"] ?? ''); // Logros

            // Llamar al método para actualizar el trabajo en la base de datos
            $jobModel->edit();

            // Redirigir al portafolio del usuario después de editar el trabajo
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }

        // Preparar los datos para la vista de edición (trabajo y usuario)
        $data = [
            "userId" => $userIdJob, // ID del usuario propietario del trabajo
            "usuario" => $usuario, // Datos del usuario propietario
            "datos" => $jobModel->get($elemento)[0], // Datos del trabajo a editar
        ];

        // Renderizar la vista de edición de trabajo
        $this->renderHTML("../app/Views/edit/edit_job_view.php", $data);
    }

    // Acción para añadir un nuevo trabajo al portafolio
    public function addAction($request)
    {
        // Separa la URL para obtener el ID del usuario (el trabajo está asociado a un usuario)
        $partes = explode('/', $request);
        $elemento = end($partes);
        $userId = Jobs::getInstancia()->getUserId($elemento); // Obtener el ID del usuario asociado al trabajo
        $usuario = Users::getInstancia()->get($userId); // Obtener la información del usuario

        // Preparar los datos para la vista de añadir trabajo
        $data = [
            "userId" => $userId, // ID del usuario propietario del trabajo
            "usuario" => $usuario, // Datos del usuario propietario
        ];

        // Si se recibe un formulario POST para agregar un nuevo trabajo
        if (isset($_POST) && !empty($_POST)) {
            // Crear una nueva instancia del modelo Jobs
            $job = Jobs::getInstancia();
            // Establecer los datos del trabajo desde el formulario
            $job->setTitle($_POST["title"]);
            $job->setDescription($_POST["description"]);
            $job->setStartDate($_POST["start_date"]);
            $job->setFinishDate($_POST["finish_date"]);
            $job->setAchievements($_POST["achievements"]);
            $job->setVisible(1); // El trabajo se establece como visible
            $job->setUserId($_SESSION["usuario"]["id"]); // Asignar el ID del usuario logueado al trabajo

            // Guardar el trabajo en la base de datos
            $job->set();

            // Redirigir al portafolio del usuario después de agregar el trabajo
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }

        // Renderizar la vista para agregar un nuevo trabajo
        $this->renderHTML("../app/Views/add/add_job_view.php", $data);
    }
}
