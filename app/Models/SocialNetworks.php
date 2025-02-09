<?php

namespace App\Models;


class SocialNetworks extends DBAbstractModel
{
    private $id;
    private $name;
    private $url;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public function getAll()
    {
        $this->query = "SELECT * FROM social_networks WHERE user_id = :id";
        $this->get_results_from_query();
        return $this->rows ?? "";
    }

    public function get($id = "")
    {
        $this->query = "SELECT * FROM social_networks WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? "";
    }
    public function set()
    {
        $this->query = "INSERT INTO social_networks (name, url, user_id) VALUES (:name, :url, :user_id)";
        $this->params = [
            "name" => $this->name,
            "url" => $this->url,
            "user_id" => $this->user_id
        ];
        $this->get_results_from_query();
    }
    public function edit()
    {
        $this->query = "UPDATE social_networks SET name = :name, url = :url WHERE id = :id";
        $this->params = [
            "id" => $this->id,
            "name" => $this->name,
            "url" => $this->url
        ];
        $this->get_results_from_query();
    }
    public function delete($id)
    {
        $this->query = "DELETE FROM social_networks WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
    }

    public function getUserId($id)
    {
        $this->query = "SELECT user_id FROM social_networks WHERE id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows[0]["user_id"] ?? "";
    }

    public function getByUserId($id)
    {
        $this->query = "SELECT * FROM social_networks WHERE user_id = :id";
        $this->params["id"] = $id;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }
}
