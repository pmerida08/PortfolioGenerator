<?php

namespace App\Models;

class Users extends DBAbstractModel
{

    private $id;
    private $name;
    private $surname;
    private $photo;
    private $categoria_profesional;
    private $email;
    private $profile_summary;
    private $password;
    private $visible;
    private $created_at;
    private $updated_at;
    private $token;
    private $token_expiration;
    private $active_account;


    private static $instancia;

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getCategoriaProfesional()
    {
        return $this->categoria_profesional;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getProfileSummary()
    {
        return $this->profile_summary;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getTokenExpiration()
    {
        return $this->token_expiration;
    }

    public function getActiveAccount()
    {
        return $this->active_account;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function setCategoriaProfesional($categoria_profesional)
    {
        $this->categoria_profesional = $categoria_profesional;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setProfileSummary($profile_summary)
    {
        $this->profile_summary = $profile_summary;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setTokenExpiration($token_expiration)
    {
        $this->token_expiration = $token_expiration;
    }

    public function setActiveAccount($active_account)
    {
        $this->active_account = $active_account;
    }




    public function login()
    {
        $this->params["email"] = $_POST["email"];
        $this->params["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $this->query = "SELECT * FROM users WHERE email = :email AND password = :password";

        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
        }

        return $this->rows[0] ?? null;
    }

    public function register($datos_formulario)
    {
        foreach ($datos_formulario as $key => $value) {
            $this->params[$key] = $value;
        }

        $rb = random_bytes(32);
        $token = base64_encode($rb);
        $secureToken = uniqid('', true) . $token;
        $expiration = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $this->query = "INSERT INTO users (name, surname, photo, categoria_profesional, email, password, token, token_expiration) 
                    VALUES (:name, :surname, :photo, :categoria_profesional, :email, :password, :token, :token_expiration)";

        $this->params["token"] = $secureToken;
        $this->params["token_expiration"] = $expiration;
        $this->get_results_from_query();
    }

    public function get()
    {
        $this->query = "SELECT * FROM users WHERE id = :id";
        $this->params["id"] = $_SESSION["usuario"]["id"];
        $this->get_results_from_query();
        return $this->rows[0] ?? "";
    }
    public function set() {
        $this->query = "UPDATE users SET name = :name, surname = :surname, photo = :photo, categoria_profesional = :categoria_profesional, email = :email, profile_summary = :profile_summary WHERE id = :id";
        $this->params["id"] = $_SESSION["usuario"]["id"];
        $this->params["name"] = $_POST["name"];
        $this->params["surname"] = $_POST["surname"];
        $this->params["photo"] = $_POST["photo"];
        $this->params["categoria_profesional"] = $_POST["categoria_profesional"];
        $this->params["email"] = $_POST["email"];
        $this->params["profile_summary"] = $_POST["profile_summary"];
        $this->get_results_from_query();
    }
    public function edit() {
    
    }
    public function delete($id)
    {
        $this->query = "DELETE FROM users WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM users";
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function uploadVisible($id)
    {
        $this->query = "UPDATE users SET visible = CASE WHEN visible = 1 THEN 0 ELSE 1 END WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function search($termino)
    {
        $this->query = "SELECT * FROM users WHERE name LIKE :termino OR surname LIKE :termino OR categoria_profesional LIKE :termino OR email LIKE :termino";
        $this->params["termino"] = "%$termino%";
        $this->get_results_from_query();
        return $this->rows ?? [];
    }

    public function activate($token)
    {
        $this->query = "SELECT * FROM users WHERE token = :token";
        $this->params["token"] = $token;
        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            $this->query = "UPDATE users SET active = 1 WHERE token = :token";
            $this->get_results_from_query();
        }
    }

    public function getTokenByEmail($email)
    {
        $this->query = "SELECT token FROM users WHERE email = :email";
        $this->params["email"] = $email;
        $this->get_results_from_query();
        return $this->rows[0]["token"] ?? "";
    }

    public function getUserByToken($token)
    {
        $this->query = "SELECT * FROM users WHERE token = :token";
        $this->params["token"] = $token;
        $this->get_results_from_query();
        return $this->rows[0] ?? null;
    }

    public function getUserById($id)
    {
        $this->query = "SELECT * FROM users WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows[0] ?? null;
    }

    public function getUserByEmail($email)
    {
        $this->query = "SELECT * FROM users WHERE email = :email";
        $this->params["email"] = $email;
        $this->get_results_from_query();
        return $this->rows[0] ?? null;
    }

    public function activateUser($token)
    {
        $this->query = "UPDATE users SET active_account = 1 WHERE token = :token";
        $this->params["token"] = $token;
        $this->get_results_from_query();
    }
}
