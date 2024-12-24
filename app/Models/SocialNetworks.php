<?php
    namespace App\Models;
    

    class SocialNetworks extends DBAbstractModel {
        private static $instancia;

        public static function getInstancia() {
            if (!isset(self::$instancia)) {
                $miclase = __CLASS__;
                self::$instancia = new $miclase;
            }
            return self::$instancia;
        }

        public function getAll($id) {
            $this->query = "SELECT * FROM social_networks WHERE user_id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
            return $this->rows ?? "";
        }

        public function get($id) {
            $this->query = "SELECT * FROM social_networks WHERE id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
            return $this->rows ?? "";
        }
        public function set($datos) {
            $this->query = "INSERT INTO social_networks (name, url, user_id) VALUES (:name, :url, :user_id)";
            $this->params = [
                "name" => $datos["name"],
                "url" => $datos["url"],
                "user_id" => $datos["user_id"]
            ];
            $this->get_results_from_query();
        }
        public function edit($id, $datos) {
            $this->query = "UPDATE social_networks SET name = :name, url = :url WHERE id = :id";
            $this->params = [
                "id" => $id,
                "name" => $datos["name"],
                "url" => $datos["url"]
            ];
            $this->get_results_from_query();
        }
        public function delete($id) {
            $this->query = "DELETE FROM social_networks WHERE id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
        }
    }