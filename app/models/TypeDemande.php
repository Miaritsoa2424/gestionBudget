<?php
namespace app\models;
use Flight;

class TypeDemande {
    private $idTypeDemande;
    private $nom;

    public function __construct($nom, $idTypeDemande = null) {
        $this->nom = $nom;
        $this->idTypeDemande = $idTypeDemande;
    }

    public function getIdTypeDemande() {
        return $this->idTypeDemande;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function save() {
        $conn = Flight::db();
        if ($this->idTypeDemande === null) {
            $stmt = $conn->prepare("INSERT INTO TypeDemande (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $this->nom]);
            $this->idTypeDemande = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE TypeDemande SET nom = :nom WHERE idTypeDemande = :id");
            $stmt->execute(['nom' => $this->nom, 'id' => $this->idTypeDemande]);
        }
    }

    public function delete() {
        if ($this->idTypeDemande !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM TypeDemande WHERE idTypeDemande = :id");
            $stmt->execute(['id' => $this->idTypeDemande]);
        }
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM TypeDemande");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new TypeDemande($row['nom'], $row['idTypeDemande']);
        }
        return $list;
    }

    public static function findById($id) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM TypeDemande WHERE idTypeDemande = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new TypeDemande($row['nom'], $row['idTypeDemande']) : null;
    }
}
