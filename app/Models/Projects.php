<?php

namespace App\Models;


class Projects extends DBAbstractModel
{
    private $id;
    private $title;
    private $description;
    private $logo;
    private $technologies;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function getTechnologies()
    {
        return $this->technologies;
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

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    public function setTechnologies($technologies): void
    {
        $this->technologies = $technologies;
    }

    public function setVisible($visible): void
    {
        $this->visible = $visible;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }


    public function getAll()
    {
        $this->query = "SELECT * FROM projects WHERE user_id = :id";
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function get($id = "")
    {
        $this->query = "SELECT * FROM projects WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }
    public function set()
    {
        $this->query = "INSERT INTO projects (title, description, technologies, user_id) VALUES (:title, :description, :technologies, :user_id)";
        $this->params = [
            "title" => $this->title,
            "description" => $this->description,
            "technologies" => $this->technologies,
            "user_id" => $this->user_id
        ];
        $this->get_results_from_query();
    }
    public function edit()
    {
        $this->query = "UPDATE projects SET title = :title, description = :description, technologies = :technologies WHERE id = :id";
        $this->params = [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "technologies" => $this->technologies
        ];
        $this->get_results_from_query();
    }
    public function delete($id)
    {
        $this->query = "DELETE FROM projects WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function getUserId($id)
    {
        $this->query = "SELECT user_id FROM projects WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows[0]["user_id"] ?? "";
    }

    public function getByUserId($id)
    {
        $this->query = "SELECT * FROM projects WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }
}
