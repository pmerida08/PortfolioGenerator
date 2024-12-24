<?php
    namespace App\Models;
    

    class Skills extends DBAbstractModel {
        private static $instancia;

        public static function getInstancia() {
            if (!isset(self::$instancia)) {
                $miclase = __CLASS__;
                self::$instancia = new $miclase;
            }
            return self::$instancia;
        }

        public function getAll($id) {
            $this->query = "SELECT * FROM skills WHERE user_id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
            return $this->rows ?? "";
        }

        public function get($id) {
            $this->query = "SELECT * FROM skills WHERE id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
            return $this->rows ?? "";
        }
        
        public function set($datos) {
            $this->query = "INSERT INTO skills (name, user_id) VALUES (:name, :user_id)";
            $this->params = [
                "name" => $datos["name"],
                "user_id" => $datos["user_id"]
            ];
            $this->get_results_from_query();
        }
        
        public function edit($id, $datos) {
            $this->query = "UPDATE skills SET name = :name WHERE id = :id";
            $this->params = [
                "id" => $id,
                "name" => $datos["name"]
            ];
            $this->get_results_from_query();
        }

        public function delete($id) {
            $this->query = "DELETE FROM skills WHERE id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
        }
    }