<?php
    namespace app\models;

use Flight;
use PDO;
    class Departement {
        private $idDept;
        private $nomDept;
        private $conn;

        public function __construct($idDept, $nomDept) {
            $this->setIdDept($idDept);
            $this->setNomDept($nomDept);
            $this->conn = Flight::db();
        }

        // Getters et Setters
        public function getIdDept() {
            return $this->idDept;
        }

        public function setIdDept($idDept) {
            $this->idDept = $idDept;
        }

        public function getNomDept() {
            return $this->nomDept;
        }

        public function setNomDept($nomDept) {
            $this->nomDept = $nomDept;
        }

        // Méthode de connexion
        public static function login($nomDept, $mdp) {
            $sql = "SELECT * FROM Dept WHERE nomDept = ?";
            $conn = Flight::db();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nomDept]);
            $dept = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dept && $dept['mdp'] == $mdp) {
                $departement = new Departement($dept['idDept'], $dept['nomDept']);
                return $departement; // Connexion réussie
            }
            return null; // Échec de connexion
        }
        
    }
?>
