<?php

namespace App\Controllers;

use App\Models\Jobs;
use App\Models\Projects;
use App\Models\Skills;
use App\Models\SocialNetworks;
use App\Models\Users;

class PortfolioController extends BaseController {
    public function indexAction() {
        $url = $_SERVER["REQUEST_URI"];
        $partes = explode('/', $url);
        $id = end($partes);
    
        $usuario = Users::getInstancia()->getUserById($id);

        $portfolio = [
            "id" => $id,
            "title" => $usuario["name"] . " " . $usuario["surname"],
            "photo" => $usuario["photo"],
            "jobs" => Jobs::getInstancia()->getByUserId($usuario["id"]),
            "projects" => Projects::getInstancia()->getByUserId($usuario["id"]),
            "skills" => Skills::getInstancia()->getByUserId($usuario["id"]),
            "socialNetworks" => SocialNetworks::getInstancia()->getByUserId($usuario["id"]),
        ];

        $data = [
            "usuario" => Users::getInstancia()->get($usuario["id"]),
            "portfolio" => $portfolio,
            "perfiles" => Users::getInstancia()->getAll(),
        ];
        $this->renderHTML("../app/Views/portfolio_view.php", $data);
    }
}