<?php
namespace app\models;
use Flight;

class Importance {
    private $idImportance;
    private $nom;

    public function __construct($nom, $idImportance = null) {
        $this->nom = $nom;
        $this->idImportance = $idImportance;
    }

    public function getIdImportance() {
        return $this->idImportance;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function save() {
        $conn = Flight::db();
        if ($this->idImportance === null) {
            $stmt = $conn->prepare("INSERT INTO Importance (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $this->nom]);
            $this->idImportance = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE Importance SET nom = :nom WHERE idImportance = :id");
            $stmt->execute(['nom' => $this->nom, 'id' => $this->idImportance]);
        }
    }

    public function delete() {
        if ($this->idImportance !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM Importance WHERE idImportance = :id");
            $stmt->execute(['id' => $this->idImportance]);
        }
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM Importance");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new Importance($row['nom'], $row['idImportance']);
        }
        return $list;
    }

    public static function findById($id) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM Importance WHERE idImportance = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Importance($row['nom'], $row['idImportance']) : null;
    }
    
}
