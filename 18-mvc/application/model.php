<?php
    class Model extends Database{
        protected $db;

        public function __construct() {
            $this->db = Database::connect();
        }

        public function listPokemons() {
            $stmt =  $this->db->query("SELECT * FROM pokemons");
            return $stmt->fetchAll();
        }
    }
