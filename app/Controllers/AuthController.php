<?php

namespace App\Controllers;

use App\Models\Users;

class AuthController extends BaseController
{
    public function loginAction()
    {
        if (!empty($_POST)) {
            $userModel = Users::getInstancia();
            $email = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';

            $usuario = $userModel->getUserByEmail($email);

            if ($usuario && password_verify($password, $usuario["password"])) {
                $_SESSION["perfil"] = "usuario";
                $_SESSION["usuario"] = [
                    "id" => $usuario["id"],
                    "email" => $usuario["email"],
                    "name" => $usuario["name"],

                ];
                header("Location: /");
                exit;
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

        $userModel = Users::getInstancia();
        $users = $userModel->getAll();

        if (isset($_POST["registrar"]) && !empty($_POST["registrar"])) {

            foreach ($users as $user) {
                if ($user["email"] == $_POST["email"]) {
                    $_SESSION["message"] = "El email ya está registrado";
                    header("Location: /register");
                    exit();
                }
            }
            // Check if passwords match
            if ($_POST['password'] != $_POST['password2']) {
                // Store the error message in session
                $_SESSION['message'] = "Las contraseñas no coinciden";
                // Redirect to registration page
                header("Location: /register");
                exit();
            }

            // Prepare user data for registration
            $user = Users::getInstancia();
            $datos = [
                "name" => $_POST["name"],
                "surname" => $_POST["surname"],
                "email" => $_POST["email"],
                "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
                "photo" => !empty($_POST["photo"]) ? $_POST["photo"] : 'user.jpg', // Set default if no photo
                "categoria_profesional" => $_POST["categoria_profesional"]
            ];

            // Register the user
            $user->register($datos);

            // Generate activation token
            $email = $_POST['email'];
            $token = $user->getTokenByEmail($email);
            $activationLink = "http://portfoliopmv.local/activate?token=" . $token;

            // Send activation email
            $this->sendActivationEmail($email, $activationLink);

            // Redirect to login page after registration
            header("Location: /login");
            exit();
        }

        // Retrieve message from session, if exists
        $data = [];
        if (isset($_SESSION['message'])) {
            $data['message'] = $_SESSION['message'];
            // Clear the message from the session after it's been displayed
            unset($_SESSION['message']);
        }

        // Render the registration view
        $this->renderHTML("../app/Views/register_view.php", $data);
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
        header("Location: /");
    }
}
