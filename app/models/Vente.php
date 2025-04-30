<?php
namespace app\models;
use Flight;

class Vente {
    private $idVente;
    private $idProduit;
    private $idClient;
    private $dateVente;
    private $quantite;
    public function __construct($idProduit, $idClient, $dateVente, $quantite, $idVente = null) {
        $this->idProduit = $idProduit;
        $this->idClient = $idClient;
        $this->dateVente = $dateVente;
        $this->quantite = $quantite;
        $this->idVente = $idVente;
    }

    // Getters
    public function getIdVente() { return $this->idVente; }
    public function getIdProduit() { return $this->idProduit; }
    public function getIdClient() { return $this->idClient; }
    public function getDateVente() { return $this->dateVente; }
    public function getQuantite() { return $this->quantite; }

    // Setters
    public function setIdProduit($idProduit) { $this->idProduit = $idProduit; }
    public function setIdClient($idClient) { $this->idClient = $idClient; }
    public function setDateVente($dateVente) { $this->dateVente = $dateVente; }
    public function setQuantite($quantite) { $this->quantite = $quantite; }

    // Save (insert or update)
    public function save() {
        $conn = Flight::db();
        if ($this->idVente === null) {
            $stmt = $conn->prepare("
                INSERT INTO vente (idProduit, idClient, dateVente, quantite)
                VALUES (:idProduit, :idClient, :dateVente, :quantite)
            ");
            $stmt->execute([
                'idProduit' => $this->idProduit,
                'idClient' => $this->idClient,
                'dateVente' => $this->dateVente,
                'quantite' => $this->quantite
            ]);
            $this->idVente = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("
                UPDATE vente
                SET idProduit = :idProduit, idClient = :idClient, dateVente = :dateVente, quantite = :quantite
                WHERE idVente = :idVente
            ");
            $stmt->execute([
                'idProduit' => $this->idProduit,
                'idClient' => $this->idClient,
                'dateVente' => $this->dateVente,
                'quantite' => $this->quantite,
                'idVente' => $this->idVente
            ]);
        }
    }

    // Find by ID
    public static function findById($idVente) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM vente WHERE idVente = :idVente");
        $stmt->execute(['idVente' => $idVente]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return new Vente($row['idProduit'], $row['idClient'], $row['dateVente'], $row['quantite'], $row['idVente']);
        }
        return null;
    }

    // Get all
    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM vente");
        $ventes = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $ventes[] = new Vente($row['idProduit'], $row['idClient'], $row['dateVente'], $row['quantite'], $row['idVente']);
        }
        return $ventes;
    }

    // Delete
    public function delete() {
        $conn = Flight::db();
        if ($this->idVente !== null) {
            $stmt = $conn->prepare("DELETE FROM vente WHERE idVente = :idVente");
            $stmt->execute(['idVente' => $this->idVente]);
        }
    }
}
