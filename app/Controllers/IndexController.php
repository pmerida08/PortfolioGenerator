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
        $usuario = $_SESSION["usuario"];
        $portfolio = [
            "id" => $usuario["id"],
            "title" => $usuario["name"] . " " . $usuario["surname"],
            "photo" => $usuario["photo"],
            "jobs" => Jobs::getInstancia()->getAll($usuario["id"]),
            "projects" => Projects::getInstancia()->getAll($usuario["id"]),
            "skills" => Skills::getInstancia()->getAll($usuario["id"]),
            "socialNetworks" => SocialNetworks::getInstancia()->getAll($usuario["id"]),
        ];

        $data = [
            "usuario" => Users::getInstancia()->get($usuario["id"]),
            "portfolio" => $portfolio,
            "perfiles" => Users::getInstancia()->getAll(),
        ];
        $this->renderHTML("../app/Views/index_view.php", $data);
    }

    public function addAction($request)
    {
        $user_id = $_SESSION["usuario"]["id"];

        $partes = explode('/', $request);
        $elemento = end($partes);

        if (isset($_POST) && !empty($_POST)) {
            switch ($elemento) {
                case "job":
                    $job = Jobs::getInstancia();
                    $datos = [
                        "title" => $_POST["title"],
                        "description" => $_POST["description"],
                        "start_date" => $_POST["start_date"],
                        "finish_date" => $_POST["finish_date"],
                        "achievements" => $_POST["achievements"],
                        "user_id" => $user_id,
                    ];
                    $job->set($datos);
                    break;
                case "project":
                    $project = Projects::getInstancia();
                    $datos = [
                        "title" => $_POST["title"],
                        "description" => $_POST["description"],
                        "technologies" => $_POST["technologies"],
                        "user_id" => $user_id,
                    ];
                    $project->set($datos);
                    break;
                case "skill":
                    $skill = Skills::getInstancia();
                    $datos = [
                        "name" => $_POST["name"],
                        "user_id" => $user_id,
                    ];
                    $skill->set($datos);
                    break;
                case "social":
                    $social = SocialNetworks::getInstancia();
                    $datos = [
                        "name" => $_POST["name"],
                        "url" => $_POST["url"],
                        "user_id" => $user_id,
                    ];
                    $social->set($datos);
                    break;
            }
            header("Location: /");
        }

        switch ($elemento) {
            case "job":
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "job",
                ];
                break;
            case "project":
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "project",
                ];
                break;
            case "skill":
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "skill",
                ];
                break;
            case "social":
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "social",
                ];
                break;
        }
        $this->renderHTML("../app/Views/add_view.php", $data);
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
        header("Location: /");
    }

    public function editAction($request)
    {
        $partes = explode('/', $request);
        $elemento = $partes[2];
        $id = end($partes);

        if (isset($_POST) && !empty($_POST)) {
            switch ($elemento) {
                case "job":
                    $job = Jobs::getInstancia();
                    $datos = [
                        "title" => $_POST["title"],
                        "description" => $_POST["description"],
                        "start_date" => $_POST["start_date"],
                        "finish_date" => $_POST["finish_date"],
                        "achievements" => $_POST["achievements"],
                    ];
                    $job->edit($id, $datos);
                    break;
                case "project":
                    $project = Projects::getInstancia();
                    $datos = [
                        "title" => $_POST["title"],
                        "description" => $_POST["description"],
                        "technologies" => $_POST["technologies"],
                    ];
                    $project->edit($id, $datos);
                    break;
                case "skill":
                    $skill = Skills::getInstancia();
                    $datos = [
                        "name" => $_POST["name"],
                    ];
                    $skill->edit($id, $datos);
                    break;
                case "social":
                    $social = SocialNetworks::getInstancia();
                    $datos = [
                        "name" => $_POST["name"],
                        "url" => $_POST["url"],
                    ];
                    $social->edit($id, $datos);
                    break;
            }
            header("Location: /");
        }

        switch ($elemento) {
            case "job":
                $job = Jobs::getInstancia();
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "job",
                    "datos" => $job->get($id)[0],
                ];
                break;
            case "project":
                $project = Projects::getInstancia();
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "project",
                    "datos" => $project->get($id)[0],
                ];
                break;
            case "skill":
                $skill = Skills::getInstancia();
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "skill",
                    "datos" => $skill->get($id)[0],
                ];
                break;
            case "social":
                $social = SocialNetworks::getInstancia();
                $data = [
                    "usuario" => $_SESSION["usuario"]["name"],
                    "elemento" => "social",
                    "datos" => $social->get($id)[0],
                ];
                break;
        }

        $this->renderHTML("../app/Views/edit_view.php", $data);
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
        $user->setVisible($user_id);
        header("Location: /");
    }

    public function searchAction()
    {
        $termino = isset($_POST["termino"]) ? $_POST["termino"] : "";
        $user = Users::getInstancia();
        $perfiles = $user->search($termino);

        $usuario = $_SESSION["usuario"];
        $portfolio = [
            "id" => $usuario["id"],
            "title" => $usuario["name"] . " " . $usuario["surname"],
            "photo" => $usuario["photo"],
            "jobs" => Jobs::getInstancia()->getAll($usuario["id"]),
            "projects" => Projects::getInstancia()->getAll($usuario["id"]),
            "skills" => Skills::getInstancia()->getAll($usuario["id"]),
            "socialNetworks" => SocialNetworks::getInstancia()->getAll($usuario["id"]),
        ];
        
        $data = [
            "usuario" => Users::getInstancia()->get($usuario["id"]),
            "portfolio" => $portfolio,
            "perfiles" => $perfiles,
        ];

        $this->renderHTML("../app/Views/index_view.php", $data);
    }
}
