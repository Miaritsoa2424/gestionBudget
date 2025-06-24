<?php

namespace app\models;

class TicketModel
{
    private $id;
    private $coutHoraire;
    private $sujet;
    private $idCategorie;
    private $idAgent;
    private $idReport;
    private $dateCreation;
    private $idEtat;

    public function __construct($id = null, $coutHoraire = null, $sujet = null, $idCategorie = null, $idAgent = null, $idReport = null, $dateCreation = null, $idEtat = null)
    {
        $this->id = $id;
        $this->coutHoraire = $coutHoraire;
        $this->sujet = $sujet;
        $this->idCategorie = $idCategorie;
        $this->idAgent = $idAgent;
        $this->idReport = $idReport;
        $this->dateCreation = $dateCreation;
        $this->idEtat = $idEtat;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getCoutHoraire()
    {
        return $this->coutHoraire;
    }
    public function getSujet()
    {
        return $this->sujet;
    }
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }
    public function getIdAgent()
    {
        return $this->idAgent;
    }
    public function getIdReport()
    {
        return $this->idReport;
    }
    public function getDateCreation() {
        return $this->dateCreation;
    }
    public function getIdEtat() {
        return $this->idEtat;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCoutHoraire($coutHoraire)
    {
        $this->coutHoraire = $coutHoraire;
    }
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    }
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }
    public function setIdAgent($idAgent)
    {
        $this->idAgent = $idAgent;
    }
    public function setIdReport($idReport)
    {
        $this->idReport = $idReport;
    }
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
    public function setIdEtat($idEtat) {
        $this->idEtat = $idEtat;
    }
    
    public static function getAll() {
        $conn = \Flight::db();
        $stmt = $conn->query("SELECT * FROM ticket");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new TicketModel(
                $row['id_ticket'],
                $row['cout_horaire'],
                $row['sujet'],
                $row['id_categorie'],
                $row['id_agent'],
                $row['id_report'],
                $row['dateCreation'],
                $row['id_etat']
            );
        }
        return $list;
    }
}
