<?php
namespace app\Models;

use Flight;

class Validation {

    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function setValidationValider($id) : bool {
        try {
            $query = $this->db->prepare("UPDATE Valeur SET validation = 1 WHERE idValeur = $id");
            if ($query->execute()) {
                return $query->rowCount() > 0; // Vérifie si une ligne a été mise à jour
            }
            return false;
        } catch (\PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }

    public function setValidationRefuser($id) : bool {
        try {
            $query = $this->db->prepare("UPDATE Valeur SET validation = 2 WHERE idValeur = $id");
            if ($query->execute()) {
                return $query->rowCount() > 0; // Vérifie si une ligne a été mise à jour
            }
            return false;
        } catch (\PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }

    public function getAllValidation() {
        $query = "
            SELECT 
                Valeur.idValeur, 
                Valeur.nomRubrique, 
                Valeur.date, 
                Valeur.montant, 
                Valeur.validation, 
                Valeur.previsionOuRealisation, 
                Type.nomType, 
                Categorie.nomCategorie, 
                Dept.nomDept, 
                Categorie.recetteOuDepense
            FROM Valeur
            JOIN Type ON Valeur.idType = Type.idType
            JOIN Categorie ON Type.idCategorie = Categorie.idCategorie
            JOIN Dept ON Valeur.idDept = Dept.idDept
            WHERE Valeur.validation = 0
        ";
        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
}
