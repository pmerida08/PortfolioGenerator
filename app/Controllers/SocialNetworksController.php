<?php

namespace App\Controllers;

use App\Models\SocialNetworks;
use App\Models\Users;

class SocialNetworksController extends BaseController
{

    public function editAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);

        $socialNetworksModel = SocialNetworks::getInstancia();
        $userModel = Users::getInstancia();

        $userIdJob = $socialNetworksModel->getUserId($elemento);
        $usuario = $userModel->get($userIdJob);


        if ($userIdJob != $_SESSION["usuario"]["id"]) {
            echo "No tienes permisos para editar estos datos";
        }

        if (isset($_POST) && !empty($_POST)) {
            $socialNetworksModel->setId($elemento);
            $socialNetworksModel->setName($_POST["name"] ?? '');
            $socialNetworksModel->setUrl($_POST["url"] ?? '');
            $socialNetworksModel->edit();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        };

        $data = [
            "userId" => $userIdJob,
            "usuario" => $usuario,
            "datos" => $socialNetworksModel->get($elemento)[0],
        ];
        $this->renderHTML("../app/Views/edit/edit_social_view.php", $data);
    }

    public function addAction($request)
    {
        $partes = explode('/', $request);
        $elemento = end($partes);
        $userId = SocialNetworks::getInstancia()->getUserId($elemento);
        $usuario = Users::getInstancia()->get($userId);
        $data = [
            "userId" => $userId,
            "usuario" => $usuario,
        ];

        if (isset($_POST) && !empty($_POST)) {
            $socialNetworks = SocialNetworks::getInstancia();
            $socialNetworks->setName($_POST["name"] ?? '');
            $socialNetworks->setUrl($_POST["url"] ?? '');
            $socialNetworks->setUserId($_SESSION["usuario"]["id"]);
            $socialNetworks->set();
            header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
        }
        $this->renderHTML("../app/Views/add/add_social_view.php", $data);
    }
}
