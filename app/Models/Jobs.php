<?php

namespace App\Models;


class Jobs extends DBAbstractModel
{
    private $id;
    private $title;
    private $description;
    private $start_date;
    private $finish_date;
    private $achievements;
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

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getFinishDate()
    {
        return $this->finish_date;
    }

    public function getAchievements()
    {
        return $this->achievements;
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

    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    public function setFinishDate($finish_date): void
    {
        $this->finish_date = $finish_date;
    }

    public function setAchievements($achievements): void
    {
        $this->achievements = $achievements;
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
        $this->query = "SELECT * FROM jobs";
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function get($id = "")
    {
        $this->query = "SELECT * FROM jobs WHERE id = :id";
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function set()
    {
        $this->query = "INSERT INTO jobs (title, description, start_date, finish_date, achievements, visible, user_id) VALUES (:title, :description, :start_date, :finish_date, :achievements, :visible, :user_id)";
        $this->params = [
            "title" => $this->title,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "finish_date" => $this->finish_date,
            "achievements" =>   $this->achievements,
            "visible" => $this->visible,
            "user_id" => $this->user_id
        ];
        $this->get_results_from_query();
    }

    public function edit()
    {
        $this->query = "UPDATE jobs SET title = :title, description = :description, start_date = :start_date, finish_date = :finish_date, achievements = :achievements WHERE id = :id";
        $this->params = [
            "title" => $this->title,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "finish_date" => $this->finish_date,
            "achievements" => $this->achievements,
            "id" => $this->id
        ];
        $this->get_results_from_query();
    }

    public function delete($id)
    {
        $this->query = "DELETE FROM jobs WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function getUserId($id)
    {
        $this->query = "SELECT user_id FROM jobs WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows[0]["user_id"] ?? "";
    }

    public function getByUserId($id)
    {
        $this->query = "SELECT * FROM jobs WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }
}
