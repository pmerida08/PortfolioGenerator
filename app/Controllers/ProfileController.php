<?php

namespace App\Controllers;

use App\Models\Users;

class ProfileController extends BaseController
{
    public function indexAction()
    {
        $url = $_SERVER["REQUEST_URI"];
        $partes = explode('/', $url);
        $id = end($partes);

        $userModel = Users::getInstancia();
        $usuario = Users::getInstancia()->getUserById($id);

        $usuarioDatos = [
            "id" => $id,
            "name" => $usuario["name"],
            "surname" => $usuario["surname"],
            "photo" => $usuario["photo"],
            "email" => $usuario["email"],
            "profile_summary" => $usuario["profile_summary"],
            "categoria_profesional" => $usuario["categoria_profesional"],
        ];

        $data = [
            "usuario" => $usuarioDatos,
        ];

        // Procesar datos si se ha enviado el formulario
        if (isset($_POST["editarPerfil"])) {
            $userModel->setId($id);
            $userModel->setName($_POST["name"] ?? $usuario["name"]);
            $userModel->setSurname($_POST["surname"] ?? $usuario["surname"]);
            $userModel->setEmail($_POST["email"] ?? $usuario["email"]);

            // Verificar si hay una nueva foto
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                // Verificar la carpeta de destino
                $uploadDir = '../public/media/'; // Cambia esto a la ruta correcta
                $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

                // Mover el archivo
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $userModel->setPhoto($_FILES['photo']['name']);
                } else {
                    echo "Error al mover el archivo.";
                }
            } else {
                // Si no hay foto nueva, usar la existente
                $userModel->setPhoto($usuario["photo"]);
            }

            $userModel->setProfileSummary($_POST["profile_summary"] ?? $usuario["profile_summary"]);
            $userModel->setCategoriaProfesional($_POST["categoria_profesional"] ?? $usuario["categoria_profesional"]);
            $userModel->set();

            // Redirigir después de actualizar
            header('Location: /profile/' . $id);
            exit();
        }

        // Mostrar la vista con los datos actualizados
        $this->renderHTML("../app/Views/profile_view.php", $data);
    }
}
