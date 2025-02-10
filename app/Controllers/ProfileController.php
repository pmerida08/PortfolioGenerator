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

            // Verificar si hay una nueva photo
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                // Verificar la carpeta de destino
                $photo = $_FILES['photo'];
                $imagenesDir = __DIR__ . '/../../public/imagenes/';

                if (!is_dir($imagenesDir)) {
                    mkdir($imagenesDir, 0777, true);
                }
                $fotoRuta = $imagenesDir . $photo['name'];

                if (move_uploaded_file($photo['tmp_name'], $fotoRuta)) {
                    $data['photo'] = $photo['name'];
                } else {
                    echo "Error al mover el archivo.";
                }
            } else {
                // Si no hay photo nueva, usar la existente
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
