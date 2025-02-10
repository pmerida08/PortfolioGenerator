<?php

namespace App\Controllers;

use App\Models\Users;

class AuthController extends BaseController
{
    // Acción de inicio de sesión (login)
    public function loginAction()
    {
        // Comprobar si se ha enviado el formulario (POST)
        if (!empty($_POST)) {
            $userModel = Users::getInstancia(); // Obtener la instancia del modelo de usuario
            $email = $_POST["email"] ?? '';  // Obtener el email enviado en el formulario
            $password = $_POST["password"] ?? ''; // Obtener la contraseña enviada

            // Obtener el usuario con el correo electrónico proporcionado
            $usuario = $userModel->getUserByEmail($email);

            // Verificar si el usuario existe y si la contraseña es correcta
            if ($usuario && password_verify($password, $usuario["password"])) {
                // Si las credenciales son correctas, iniciar sesión
                $_SESSION["perfil"] = "usuario"; // Definir el perfil del usuario
                $_SESSION["usuario"] = [
                    "id" => $usuario["id"],
                    "email" => $usuario["email"],
                    "name" => $usuario["name"], // Guardar la información básica del usuario en la sesión
                ];
                header("Location: /"); // Redirigir al usuario a la página principal
                exit;
            } else {
                // Si las credenciales son incorrectas, mostrar mensaje de error
                $message = "Usuario o contraseña incorrectos";
            }
        }

        // Preparar los datos para mostrar la vista de inicio de sesión
        $data = [
            "message" => $message ?? "", // Mostrar el mensaje de error si existe
        ];

        // Renderizar la vista de inicio de sesión
        $this->renderHTML("../app/Views/login_view.php", $data);
    }

    // Acción de registro de usuario
    public function registerAction()
    {
        $userModel = Users::getInstancia(); // Obtener la instancia del modelo de usuario
        $users = $userModel->getAll(); // Obtener todos los usuarios registrados

        // Verificar si se ha enviado el formulario de registro
        if (isset($_POST["registrar"]) && !empty($_POST["registrar"])) {

            // Comprobar si el email ya está registrado
            foreach ($users as $user) {
                if ($user["email"] == $_POST["email"]) {
                    // Si el email ya está registrado, redirigir con mensaje de error
                    $_SESSION["message"] = "El email ya está registrado";
                    header("Location: /register");
                    exit();
                }
            }

            // Verificar si las contraseñas coinciden
            if ($_POST['password'] != $_POST['password2']) {
                // Si no coinciden, redirigir con un mensaje de error
                $_SESSION['message'] = "Las contraseñas no coinciden";
                header("Location: /register");
                exit();
            }

            // Preparar los datos del usuario para el registro
            $user = Users::getInstancia();
            $datos = [
                "name" => $_POST["name"], // Nombre del usuario
                "surname" => $_POST["surname"], // Apellido del usuario
                "email" => $_POST["email"], // Correo electrónico
                "password" => password_hash($_POST["password"], PASSWORD_DEFAULT), // Contraseña encriptada
                "photo" => !empty($_POST["photo"]) ? $_POST["photo"] : 'user.jpg', // Foto del usuario (por defecto 'user.jpg' si no se proporciona)
                "categoria_profesional" => $_POST["categoria_profesional"] // Categoría profesional del usuario
            ];

            // Registrar al usuario en la base de datos
            $user->register($datos);

            // Generar el enlace de activación para el usuario
            $email = $_POST['email'];
            $token = $user->getTokenByEmail($email); // Obtener el token de activación
            $activationLink = "http://portfoliopmv.local/activate?token=" . $token;

            // Enviar el correo de activación
            $this->sendActivationEmail($email, $activationLink);

            // Redirigir al login después de registrarse
            header("Location: /login");
            exit();
        }

        // Recuperar mensaje de la sesión si existe
        $data = [];
        if (isset($_SESSION['message'])) {
            $data['message'] = $_SESSION['message']; // Mostrar el mensaje de error
            unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
        }

        // Renderizar la vista de registro
        $this->renderHTML("../app/Views/register_view.php", $data);
    }

    // Función para enviar el correo de activación
    private function sendActivationEmail($email, $activationLink)
    {
        $subject = "Activar tu cuenta"; // Asunto del correo
        $message = "Hola, gracias por registrarte. Para activar tu cuenta, por favor haz clic en el siguiente enlace:\n\n";
        $message .= $activationLink; // Enlace de activación
        $headers = "From: no-reply@portfoliopmv.local"; // Cabecera del correo

        mail($email, $subject, $message, $headers); // Enviar el correo
    }

    // Acción para activar la cuenta del usuario
    public function activateAction()
    {
        // Comprobar si se ha pasado el token como parámetro en la URL
        if (isset($_GET['token'])) {
            $token = trim($_GET['token']); // Obtener el token de la URL

            $user = Users::getInstancia(); // Obtener la instancia del modelo de usuario
            $userData = $user->getUserByToken($token); // Obtener los datos del usuario por el token

            // Verificar si el token es válido y no ha expirado
            if ($userData && strtotime($userData['token_expiration']) > strtotime(time())) {
                // Si es válido, activar la cuenta del usuario
                $user->activateUser($token);
                echo "Cuenta activada con éxito."; // Mensaje de éxito
            } else {
                echo "El enlace de activación es inválido o ha expirado."; // Mensaje de error si el token es inválido
            }
        } else {
            echo "Token no proporcionado."; // Mensaje de error si no se proporciona el token
        }
    }

    // Acción para cerrar sesión
    public function logoutAction()
    {
        session_unset(); // Limpiar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: /"); // Redirigir a la página principal
    }
}
