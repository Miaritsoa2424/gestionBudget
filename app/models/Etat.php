<?php
namespace app\models;
use Flight;

class Etat {
    private $idEtat;
    private $nom;

    public function __construct($nom, $idEtat = null) {
        $this->nom = $nom;
        $this->idEtat = $idEtat;
    }

    public function getIdEtat() {
        return $this->idEtat;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function save() {
        $conn = Flight::db();
        if ($this->idEtat === null) {
            $stmt = $conn->prepare("INSERT INTO Etat (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $this->nom]);
            $this->idEtat = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE Etat SET nom = :nom WHERE idEtat = :idEtat");
            $stmt->execute(['nom' => $this->nom, 'idEtat' => $this->idEtat]);
        }
    }

    public function delete() {
        if ($this->idEtat !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM Etat WHERE idEtat = :idEtat");
            $stmt->execute(['idEtat' => $this->idEtat]);
        }
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM Etat");
        $results = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = new Etat($row['nom'], $row['idEtat']);
        }
        return $results;
    }

    public static function findById($idEtat) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM Etat WHERE idEtat = :id");
        $stmt->execute(['id' => $idEtat]);
        $row = $stmt->fetch();
        return $row ? new Etat($row['nom'], $row['idEtat']) : null;
    }
}
