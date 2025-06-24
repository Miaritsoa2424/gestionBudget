<?php
namespace app\models;
use Flight;

class Importance {
    private $idmportance;
    private $nom;

    public function __construct($nom, $idmportance = null) {
        $this->nom = $nom;
        $this->idmportance = $idmportance;
    }

    public function getIdmportance() {
        return $this->idmportance;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function save() {
        $conn = Flight::db();
        if ($this->idmportance === null) {
            $stmt = $conn->prepare("INSERT INTO importance (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $this->nom]);
            $this->idmportance = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE importance SET nom = :nom WHERE idmportance = :id");
            $stmt->execute(['nom' => $this->nom, 'id' => $this->idmportance]);
        }
    }

    public function delete() {
        if ($this->idmportance !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM importance WHERE idmportance = :id");
            $stmt->execute(['id' => $this->idmportance]);
        }
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM importance");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new Importance($row['libelle'], $row['id_importance']);
        }
        return $list;
    }

    public static function findById($id) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM importance WHERE idimportance = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Importance($row['nom'], $row['idmportance']) : null;
    }
    
}
