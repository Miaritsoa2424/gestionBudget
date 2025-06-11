<?php
namespace app\models;
use Flight;

class Demande {
    private $idDemande;
    private $idClient;
    private $valideOuPas;
    private $description;
    private $sujet;
    private $dateDemande;

    public function __construct($idClient, $valideOuPas, $description, $sujet, $dateDemande, $idDemande = null) {
        $this->idDemande = $idDemande;
        $this->idClient = $idClient;
        $this->valideOuPas = $valideOuPas;
        $this->description = $description;
        $this->sujet = $sujet;
        $this->dateDemande = $dateDemande;
    }

    public function getIdDemande() {
        return $this->idDemande;
    }

    public function getIdClient() {
        return $this->idClient;
    }

    public function getValideOuPas() {
        return $this->valideOuPas;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSujet() {
        return $this->sujet;
    }

    public function getDateDemande() {
        return $this->dateDemande;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setSujet($sujet) {
        $this->sujet = $sujet;
    }

    public function save() {
        $conn = Flight::db();
        if ($this->idDemande === null) {
            $stmt = $conn->prepare("INSERT INTO Demande (idClient, valideOuPas, description, sujet, dateDemande) VALUES (:idClient, :valideOuPas, :description, :sujet, :dateDemande)");
            $stmt->execute([
                'idClient' => $this->idClient,
                'valideOuPas' => $this->valideOuPas,
                'description' => $this->description,
                'sujet' => $this->sujet,
                'dateDemande' => $this->dateDemande
            ]);
            $this->idDemande = $conn->lastInsertId();
        } else {
            $stmt = $conn->prepare("UPDATE Demande SET idClient = :idClient, valideOuPas = :valideOuPas, description = :description, sujet = :sujet, dateDemande = :dateDemande WHERE idDemande = :idDemande");
            $stmt->execute([
                'idClient' => $this->idClient,
                'valideOuPas' => $this->valideOuPas,
                'description' => $this->description,
                'sujet' => $this->sujet,
                'dateDemande' => $this->dateDemande,
                'idDemande' => $this->idDemande
            ]);
        }
    }

    public function delete() {
        if ($this->idDemande !== null) {
            $conn = Flight::db();
            $stmt = $conn->prepare("DELETE FROM Demande WHERE idDemande = :id");
            $stmt->execute(['id' => $this->idDemande]);
        }
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM Demande");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new Demande(
                $row['idClient'],
                $row['valideOuPas'],
                $row['description'],
                $row['sujet'],
                $row['dateDemande'],
                $row['idDemande']
            );
        }
        return $list;
    }

    public static function findById($id) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM Demande WHERE idDemande = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Demande(
            $row['idClient'],
            $row['valideOuPas'],
            $row['description'],
            $row['sujet'],
            $row['dateDemande'],
            $row['idDemande']
        ) : null;
    }
}
