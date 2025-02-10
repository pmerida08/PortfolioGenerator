<?php

namespace App\Controllers;

use App\Models\Projects;
use App\Models\Users;

class ProjectsController extends BaseController
{

    public function editAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);

        $projectModel = Projects::getInstancia();
        $userModel = Users::getInstancia();
        
        $userIdJob = $projectModel->getUserId($elemento);
        $usuario = $userModel->get($userIdJob);

        if ($userIdJob != $_SESSION["usuario"]["id"]) {
            header("Location: /");
            exit();
        }

        if (isset($_POST) && !empty($_POST)) {
            
            $projectModel->setId($elemento);
            $projectModel->setTitle($_POST["title"] ?? '');
            $projectModel->setDescription($_POST["description"] ?? '');
            $projectModel->setTechnologies($_POST["technologies"] ?? '');
            
            $projectModel->edit();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }

        $data = [
            "userId" => $userIdJob,
            "usuario" => $usuario,
            "datos" => $projectModel->get($elemento)[0],
        ];
        $this->renderHTML("../app/Views/edit/edit_project_view.php", $data);
    }

    public function addAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);
        $userId = Projects::getInstancia()->getUserId($elemento);
        $usuario = Users::getInstancia()->get($userId);
        $data = [
            "userId" => $userId,
            "usuario" => $usuario,
        ];

        if (isset($_POST) && !empty($_POST)) {
            $project = Projects::getInstancia();
            $project->setTitle($_POST["title"] ?? '');
            $project->setDescription($_POST["description"] ?? '');
            $project->setTechnologies($_POST["technologies"] ?? '');
            $project->setUserId($_SESSION["usuario"]["id"]);
            $project->set();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }
        $this->renderHTML("../app/Views/add/add_project_view.php", $data);
    }
}
