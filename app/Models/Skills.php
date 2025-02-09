<?php

namespace App\Models;


class Skills extends DBAbstractModel
{

    private $id;
    private $name;
    private $visible;
    private $created_at;
    private $updated_at;
    private $user_id;
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

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function getUpdated_at()
    {
        return $this->updated_at;
    }



    public function setId($id)
    {
        $this->id = $id;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }



    public function getSkillByUserId($id)
    {
        $this->query = "SELECT * FROM skills WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function get($id = "")
    {
        $this->query = "SELECT * FROM skills WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function set()
    {
        $this->query = "INSERT INTO skills (name, user_id) VALUES (:name, :user_id)";
        $this->params = [
            "name" => $this->name,
            "visible" => 1,
            "user_id" => $this->user_id
        ];
        $this->get_results_from_query();
    }

    public function edit()
    {
        $this->query = "UPDATE skills SET name = :name WHERE id = :id";
        $this->params = [
            "id" => $this->id,
            "name" => $this->name,
        ];
        $this->get_results_from_query();
    }

    public function delete($id)
    {
        $this->query = "DELETE FROM skills WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function getUserId($id)
    {
        $this->query = "SELECT user_id FROM skills WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows[0]["user_id"] ?? "";
    }

    public function search($termino)
    {
        $this->query = "SELECT * FROM skills WHERE name LIKE :termino";
        $this->params["termino"] = "%$termino%";
        $this->get_results_from_query();
        return $this->rows ?? [];
    }

    public function getByUserId($id)
    {
        $this->query = "SELECT * FROM skills WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }
}
