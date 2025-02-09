<?php

namespace App\Controllers;

use App\Models\Jobs;
use App\Models\Users;

class JobsController extends BaseController
{

    public function editAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);

        $jobModel = Jobs::getInstancia();
        $userModel = Users::getInstancia();

        $userIdJob = $jobModel->getUserId($elemento);
        $usuario = $userModel->get($userIdJob);

        if ($userIdJob !== $_SESSION["usuario"]["id"]) {
            echo "No tienes permisos para editar estos datos";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $jobModel->setId($elemento);
            $jobModel->setTitle($_POST["title"] ?? '');
            $jobModel->setDescription($_POST["description"] ?? '');
            $jobModel->setStartDate($_POST["start_date"] ?? '');
            $jobModel->setFinishDate($_POST["finish_date"] ?? '');
            $jobModel->setAchievements($_POST["achievements"] ?? '');
            $jobModel->edit();

            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }

        $data = [
            "userId" => $userIdJob,
            "usuario" => $usuario,
            "datos" => $jobModel->get($elemento)[0],
        ];

        $this->renderHTML("../app/Views/edit/edit_job_view.php", $data);
    }


    public function addAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);
        $userId = Jobs::getInstancia()->getUserId($elemento);
        $usuario = Users::getInstancia()->get($userId);
        $data = [
            "userId" => $userId,
            "usuario" => $usuario,
        ];
        if (isset($_POST) && !empty($_POST)) {
            $job = Jobs::getInstancia();
            $job->setTitle($_POST["title"]);
            $job->setDescription($_POST["description"]);
            $job->setStartDate($_POST["start_date"]);
            $job->setFinishDate($_POST["finish_date"]);
            $job->setAchievements($_POST["achievements"]);
            $job->setVisible(1);
            $job->setUserId($_SESSION["usuario"]["id"]);
            $job->set();

            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }
        $this->renderHTML("../app/Views/add/add_job_view.php", $data);
    }
}
