<?php

namespace App\Controllers;

use App\Models\Skills;
use App\Models\Users;

class SkillsController extends BaseController
{

    public function editAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);

        $skillModel = Skills::getInstancia();
        $userModel = Users::getInstancia();

        $userIdJob = $skillModel->getUserId($elemento);
        $usuario = $userModel->get($userIdJob);

        if ($userIdJob != $_SESSION["usuario"]["id"]) {
            echo "No tienes permisos para editar estos datos";
        }

        if (isset($_POST) && !empty($_POST)) {
            $skillModel->setId($elemento);
            $skillModel->setName($_POST["name"] ?? '');
            $skillModel->edit();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        };

        $data = [
            "userId" => $userIdJob,
            "usuario" => $usuario,
            "datos" => $skillModel->get($elemento)[0],
        ];
        $this->renderHTML("../app/Views/edit/edit_skill_view.php", $data);
    }

    public function addAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);
        $userId = Skills::getInstancia()->getUserId($elemento);
        $usuario = Users::getInstancia()->get($userId);
        $data = [
            "userId" => $userId,
            "usuario" => $usuario,
        ];

        if (isset($_POST) && !empty($_POST)) {
            $skill = Skills::getInstancia();
            $skill->setName($_POST["name"]);
            $skill->setVisible(1);
            $skill->setUser_id($_SESSION["usuario"]["id"]);
            $skill->set();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }
        $this->renderHTML("../app/Views/add/add_skill_view.php", $data);
    }
}
