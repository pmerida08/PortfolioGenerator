<?php
    namespace App\Models;

    class Users extends DBAbstractModel {
        private static $instancia;

        public static function getInstancia() {
            if (!isset(self::$instancia)) {
                $miclase = __CLASS__;
                self::$instancia = new $miclase;
            }
            return self::$instancia;
        }

        public function login($datos_formulario) {
            foreach ($datos_formulario as $key => $value) {
                $this->params[$key] = $value;
            }

            $this->query = "SELECT * FROM users WHERE email = :email AND password = :password";
            
            $this->get_results_from_query();

            if (count($this -> rows) == 1) {
                foreach ($this -> rows[0] as $propiedad => $valor) {
                    $this -> $propiedad = $valor;
                }
            }

            return $this -> rows[0] ?? null;
        }

        public function register($datos_formulario) {
            foreach ($datos_formulario as $key => $value) {
                $this->params[$key] = $value;
            }

            $this->query = "INSERT INTO users (name, surname, email, password) values (:name, :surname, :email, :password)";
            
            $this->get_results_from_query();
        }

        public function get() {}
        public function set() {}
        public function edit() {}
        public function delete($id) {
            $this->query = "DELETE FROM users WHERE id = :id";
            $this->params["id"] = $id;
            $this->get_results_from_query();
        }  
    }
