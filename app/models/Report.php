<?php
namespace app\models;
use Flight;

class Report {
    private $libelle;
    private $piece_jointe;
    private $dateReport;
    private $note;
    private $dateNote;
    private $commentaire;

    public function __construct($libelle, $piece_jointe, $dateReport, $note = null, $dateNote = null, $commentaire = null) {
        $this->libelle = $libelle;
        $this->piece_jointe = $piece_jointe;
        $this->dateReport = $dateReport;
        $this->note = $note;
        $this->dateNote = $dateNote;
        $this->commentaire = $commentaire;
    }

    // Getters
    public function getLibelle() {
        return $this->libelle;
    }

    public function getPieceJointe() {
        return $this->piece_jointe;
    }

    public function getDateReport() {
        return $this->dateReport;
    }

    public function getNote() {
        return $this->note;
    }

    public function getDateNote() {
        return $this->dateNote;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    // Setters
    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function setPieceJointe($piece_jointe) {
        $this->piece_jointe = $piece_jointe;
    }

    public function setDateReport($dateReport) {
        $this->dateReport = $dateReport;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function setDateNote($dateNote) {
        $this->dateNote = $dateNote;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    // Récupérer tous les rapports depuis la table report_client
    public static function getAll() {
        $db = Flight::db(); 
        $stmt = $db->prepare("SELECT * FROM report_client");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function saveReport($id_client) {
        $db = Flight::db(); 
        $stmt = $db->prepare(
            "INSERT INTO report_client (libelle, piece_jointe, date_report, note, date_note, commentaire, id_client)
            VALUES (:libelle, :piece_jointe, :date_report, :note, :date_note, :commentaire, :id_client)"
        );
        return $stmt->execute([
            ':libelle'      => $this->libelle,
            ':piece_jointe' => $this->piece_jointe,
            ':date_report'  => $this->dateReport,
            ':note'         => $this->note,
            ':date_note'    => $this->dateNote,
            ':commentaire'  => $this->commentaire,
            ':id_client'    => $id_client
        ]);
}



}
