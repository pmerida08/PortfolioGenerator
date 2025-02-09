<?php

namespace App\Controllers;

use App\Models\Jobs;
use App\Models\Projects;
use App\Models\Skills;
use App\Models\SocialNetworks;
use App\Models\Users;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $user = Users::getInstancia();
        $perfiles = $user->getAll();
        
        $usuario = $_SESSION["usuario"] ?? null;
        
        
        $userId = $usuario["id"] ?? null;
        if (isset($usuario)) {            
            $data = [
                "usuario" => $usuario,
                "perfiles" => $perfiles,
                "img" => Users::getInstancia()->getUserById($userId)["photo"],
            ];
        } else {
            $data = [
                "invitadoUser" => "Invitado",
                "perfiles" => $perfiles,
            ];
        }
        
        $this->renderHTML("../app/Views/index_view.php", $data);
    }
    

    public function delAction($request)
    {
        $partes = explode('/', $request);
        $elemento = $partes[2];
        $id = end($partes);

        switch ($elemento) {
            case "job":
                $job = Jobs::getInstancia();
                $job->delete($id);
                break;
            case "project":
                $project = Projects::getInstancia();
                $project->delete($id);
                break;
            case "skill":
                $skill = Skills::getInstancia();
                $skill->delete($id);
                break;
            case "social":
                $social = SocialNetworks::getInstancia();
                $social->delete($id);
                break;
        }
        header("Location: /portfolio/" . $_SESSION["usuario"]["id"]);
    }

    public function logoutAction()
    {
        session_destroy();
        header("Location: /");
    }

    public function visibilityAction()
    {
        $user = Users::getInstancia();
        $user_id = $_SESSION["usuario"]["id"];
        $user->uploadVisible($user_id);
        header("Location: /");
    }

    public function searchAction()
    {
        $termino = $_POST["termino"];
        $user = Users::getInstancia();
        $perfiles = $user->search($termino);
        $usuario = $_SESSION["usuario"] ?? null;
        $userId = $usuario["id"] ?? null;
        if (isset($usuario)) {
            $data = [
                "usuario" => $usuario,
                "perfiles" => $perfiles,
                "img" => Users::getInstancia()->getUserById($userId)["photo"],
            ];
        } else {
            $data = [
                "invitadoUser" => "Invitado",
                "perfiles" => $perfiles,
            ];
        }
        $this->renderHTML("../app/Views/search_view.php", $data);
    }
}
