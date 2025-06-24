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

    public function getidImportance() {
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
            $stmt = $conn->prepare("INSERT INTO importance (nom) VALUES (:nom)");
            $stmt->execute(['nom' => $this->nom]);
            $this->idImportance = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE importance SET nom = :nom WHERE idImportance = :id");
            $stmt->execute(['nom' => $this->nom, 'id' => $this->idImportance]);
        }
    }

    public function delete() {
        if ($this->idImportance !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM importance WHERE idImportance = :id");
            $stmt->execute(['id' => $this->idImportance]);
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
        return $row ? new Importance($row['nom'], $row['idImportance']) : null;
    }

    public static function getImportanceByIdTicket($idTicket) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT i.* FROM importance i
            JOIN ticket_importance ti ON i.id_importance = ti.id_importance
            WHERE ti.id_ticket = :idTicket");
        $stmt->execute(['idTicket' => $idTicket]);
        $row = $stmt->fetch();
        return $row ? new Importance($row['libelle'], $row['id_importance']) : null;
    }
    
}
