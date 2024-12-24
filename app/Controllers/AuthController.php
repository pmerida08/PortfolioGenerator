<?php

    namespace App\Controllers;

    use App\Models\Users;

    class AuthController extends BaseController{
        public function loginAction() {
            if (isset($_POST) && !empty($_POST)) {
                $user = Users::getInstancia();
                if ($user->login($_POST) != null) {
                    $_SESSION["perfil"] = "usuario";
                    $_SESSION["usuario"] = [
                        "id" => $user->id,
                        "name" => $user->name,
                        "surname" => $user->surname,
                        "photo" => $user->photo,
                        "categoria"=> $user->categoria_profesional,
                        "email" => $user->email,
                        "resumen" => $user->profile_summary,
                        "visible" => $user->visible,
                        "updated_at" => $user->updated_at,
                    ];
                    header("Location: /");
                } else {
                    $message = "Usuario o contraseña incorrectos";
                }
            }

            $data = [
                "message" => $message ?? "",
            ];
            $this->renderHTML("../app/Views/login_view.php", $data);
        }

        public function registerAction() {
            if (isset($_POST) && !empty($_POST)) {
                $user = Users::getInstancia();
                $user->register($_POST);
                header("Location: /login");
            }
            $this->renderHTML("../app/Views/register_view.php");
        }

        public function logoutAction() {
            session_unset();
            session_destroy();
            header("Location: /login");
        }
    }
