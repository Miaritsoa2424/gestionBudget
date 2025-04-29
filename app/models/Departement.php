<?php
namespace app\models;

use Flight;
use Nette\StaticClass;
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

        public static function getDepartementByName($nom) {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM Dept WHERE nomDept = ?");
            $stmt->execute([$nom]);
            $data = $stmt->fetch();
    
            if ($data) {
                $departement = new Departement($data['idDept'],$data['nomDept']);
                return $departement;
            }
            return null;
        }  

        
        public static function getDepartementById($id) {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM Dept WHERE idDept = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch();
    
            if ($data) {
                $departement = new Departement($data['idDept'],$data['nomDept']);
                return $departement;
            }
            return null;
        }  
        public static function getAllDepartement() {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM Dept");
            $stmt->execute();
            $data = $stmt->fetchAll(); // Récupérer tous les résultats
        
            $departements = [];
            foreach ($data as $row) {
                $departements[] = new Departement($row['idDept'], $row['nomDept']);
            }
        
            return $departements; // Retourne une liste de départements
        }

        public static function getAllDept($idDept) {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT de.idDept,de.nomDept FROM Dept as de JOIN Droit as dr on dr.idDeptFils = de.idDept WHERE idDeptPere = ?");
            $stmt->execute([$idDept]);
            $data = $stmt->fetchAll(); // Récupérer tous les résultats
        
            $departements = [];
            foreach ($data as $row) {
                $departements[] = new Departement($row['idDept'], $row['nomDept']);
            }
            return $departements; // Retourne une liste de départements
        }

        public static function getDroit($idDepartPere, $idDepartFils) {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM Droit WHERE idDeptPere = ? AND idDeptFils = ?");
            $stmt->execute([$idDepartPere, $idDepartFils]);
            $data = $stmt->fetch(); 

            if (!empty($data)) {
                return true;
            }
            return false;
        }
        
        
        public function getSoldeInitial() {
            $sql = "SELECT montant FROM soldeInitial WHERE idDept = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->getIdDept()]);
            $solde = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Vérifier si un solde a été trouvé, sinon retourner 0
            if ($solde) {
                return $solde['montant'];
            } else {
                return 0;  // Valeur par défaut si aucun solde n'est trouvé
            }
        }
        

        public function getSoldeInitialAtDate() {
            $soldeInitial = $this->getSoldeInitial();


        }


        

    }
?>
