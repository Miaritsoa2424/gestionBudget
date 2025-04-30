<?php
namespace app\models;
use Flight;

class Crm {
    private $idCrm;
    private $label;

    public function __construct($label, $idCrm = null) {
        $this->label = $label;
        $this->idCrm = $idCrm;
    }

    // Getters
    public function getIdCrm() {
        return $this->idCrm;
    }

    public function getLabel() {
        return $this->label;
    }

    // Setters
    public function setLabel($label) {
        $this->label = $label;
    }

    // Sauvegarde en base de données (insertion)
    public function save() {
        $conn = Flight::db();
        if ($this->idCrm === null) {
            $stmt = $conn->prepare("INSERT INTO Crm (label) VALUES (:label)");
            $stmt->execute(['label' => $this->label]);
            $this->idCrm = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE Crm SET label = :label WHERE idCrm = :idCrm");
            $stmt->execute([
                'label' => $this->label,
                'idCrm' => $this->idCrm
            ]);
        }
    }

    public static function getAllCrm() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM Crm");
        $crms = [];
    
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $crms[] = new Crm($row['label'], $row['idCrm']);
        }
    
        return $crms;
    }
    

    // Chargement d’un enregistrement par ID
    public static function findById($idCrm) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM Crm WHERE idCrm = :idCrm");
        $stmt->execute(['idCrm' => $idCrm]);
        $row = $stmt->fetch();
        if ($row) {
            return new Crm($row['label'], $row['idCrm']);
        }
        return null;
    }

    // Suppression
    public function delete() {
        $conn = Flight::db();
        if ($this->idCrm !== null) {
            $stmt = $conn->prepare("DELETE FROM Crm WHERE idCrm = :idCrm");
            $stmt->execute(['idCrm' => $this->idCrm]);
        }
    }
    public static function getResteCRMValue($idDept, $date) {
        $conn = Flight::db();
    
        // Extraire mois et année de la date donnée
        $mois = date('m', strtotime($date));
        $annee = date('Y', strtotime($date));
    
        // Somme des prévisions validées du mois
        $stmtPrev = $conn->prepare("
            SELECT COALESCE(SUM(montant), 0) AS sommePrevision 
            FROM Valeur v 
            JOIN Type t ON v.idType = t.idType 
            JOIN Categorie c ON t.idCategorie = c.idCategorie 
            WHERE v.idDept = :idDept 
            AND MONTH(v.date) = :mois 
            AND YEAR(v.date) = :annee 
            AND v.previsionOuRealisation = 0 
            AND v.validation = 1 
            AND c.nomCategorie = 'CRM'
        ");
        $stmtPrev->execute(['idDept' => $idDept, 'mois' => $mois, 'annee' => $annee]);
        $sommePrevision = $stmtPrev->fetchColumn();
    
        // Somme des réalisations validées du mois
        $stmtRea = $conn->prepare("
            SELECT COALESCE(SUM(montant), 0) AS sommeRealisation 
            FROM Valeur v 
            JOIN Type t ON v.idType = t.idType 
            JOIN Categorie c ON t.idCategorie = c.idCategorie 
            WHERE v.idDept = :idDept 
            AND MONTH(v.date) = :mois 
            AND YEAR(v.date) = :annee 
            AND v.previsionOuRealisation = 1 
            AND v.validation = 1 
            AND c.nomCategorie = 'CRM'
        ");
        $stmtRea->execute(['idDept' => $idDept, 'mois' => $mois, 'annee' => $annee]);
        $sommeRealisation = $stmtRea->fetchColumn();
    
        return $sommePrevision - $sommeRealisation;
    }
    
}
