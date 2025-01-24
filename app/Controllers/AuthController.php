<?php

namespace App\Controllers;

use App\Models\Users;

class AuthController extends BaseController
{
    public function loginAction()
    {
        if (isset($_POST) && !empty($_POST)) {
            $user = Users::getInstancia();
            if ($user->login($_POST) != null) {
                $_SESSION["perfil"] = "usuario";
                $_SESSION["usuario"] = [
                    "id" => $user->id,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "photo" => $user->photo,
                    "categoria" => $user->categoria_profesional,
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

    public function registerAction()
    {
        if (isset($_POST) && !empty($_POST)) {
            $user = Users::getInstancia();
            $user->register($_POST);

            $email = $_POST['email'];

            $token = $user->getTokenByEmail($email);
            $activationLink = "http://portfoliopmv.local/activate?token=" . $token;
            $this->sendActivationEmail($email, $activationLink);

            header("Location: /login");
        }
        $this->renderHTML("../app/Views/register_view.php");
    }

    private function sendActivationEmail($email, $activationLink)
    {
        $subject = "Activar tu cuenta";
        $message = "Hola, gracias por registrarte. Para activar tu cuenta, por favor haz clic en el siguiente enlace:\n\n";
        $message .= $activationLink;
        $headers = "From: no-reply@portfoliopmv.local";

        mail($email, $subject, $message, $headers);
    }

    public function activateAction()
    {
        if (isset($_GET['token'])) {
            $token = trim($_GET['token']);

            $user = Users::getInstancia();
            $userData = $user->getUserByToken($token);

            if ($userData && strtotime($userData['token_expiration']) > strtotime(time())) {
                $user->activateUser($token);
                echo "Cuenta activada con éxito.";
            } else {
                echo "El enlace de activación es inválido o ha expirado.";
            }
        } else {
            echo "Token no proporcionado.";
        }
    }


    public function logoutAction()
    {
        session_unset();
        session_destroy();
        header("Location: /login");
    }
}
