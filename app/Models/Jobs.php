<?php

namespace App\Models;


class Jobs extends DBAbstractModel
{
    private static $instancia;

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getAll($id)
    {
        $this->query = "SELECT * FROM jobs WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function get($id)
    {
        $this->query = "SELECT * FROM jobs WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function set($datos)
    {
        $this->query = "INSERT INTO jobs (title, description, start_date, finish_date, achievements, user_id) VALUES (:title, :description, :start_date, :finish_date, :achievements, :user_id)";
        $this->params = [
            "title" => $datos["title"],
            "description" => $datos["description"],
            "start_date" => $datos["start_date"],
            "finish_date" => $datos["finish_date"],
            "achievements" => $datos["achievements"],
            "user_id" => $datos["user_id"]
        ];
        $this->get_results_from_query();
    }

    public function edit($id, $datos)
    {
        $this->query = "UPDATE jobs SET title = :title, description = :description, start_date = :start_date, finish_date = :finish_date, achievements = :achievements WHERE id = :id";
        $this->params = [
            "id" => $id,
            "title" => $datos["title"],
            "description" => $datos["description"],
            "start_date" => $datos["start_date"],
            "finish_date" => $datos["finish_date"],
            "achievements" => $datos["achievements"]
        ];
        $this->get_results_from_query();
    }

    public function delete($id)
    {
        $this->query = "DELETE FROM jobs WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }
}
