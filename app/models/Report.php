<?php

namespace app\models;

use Flight;

class Report
{
    private $id;
    private $libelle;
    private $piece_jointe;
    private $dateReport;
    private $note;
    private $dateNote;
    private $commentaire;
    private $statut;
    private $id_client; // Ajout

    public function __construct($id, $libelle, $piece_jointe, $dateReport, $note = null, $dateNote = null, $commentaire = null, $statut = 0, $id_client = null)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->piece_jointe = $piece_jointe;
        $this->dateReport = $dateReport;
        $this->note = $note;
        $this->dateNote = $dateNote;
        $this->commentaire = $commentaire;
        $this->statut = $statut;
        $this->id_client = $id_client; // Ajout
    }

    // Getters
    public function getLibelle()
    {
        return $this->libelle;
    }

    public function getPieceJointe()
    {
        return $this->piece_jointe;
    }

    public function getDateReport()
    {
        return $this->dateReport;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getDateNote()
    {
        return $this->dateNote;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    // Getter pour id
    public function getId()
    {
        return $this->id;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    // Setters
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function setPieceJointe($piece_jointe)
    {
        $this->piece_jointe = $piece_jointe;
    }

    public function setDateReport($dateReport)
    {
        $this->dateReport = $dateReport;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function setDateNote($dateNote)
    {
        $this->dateNote = $dateNote;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }
    public function getStatut()
    {
        return $this->statut;
    }

    public function getStatutLibelle() {
        if ($this->statut == 1) {
            return 'Lu';
        }
        return 'Non lu';
    }

    // Setter pour id
    public function setId($id)
    {
        $this->id = $id;
    }

    // Récupérer tous les rapports depuis la table report_client
    public static function getAll()
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM report_client");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getReportById($id)
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM report_client WHERE id_report = :id_report");
        $stmt->execute([':id_report' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            return new Report(
                $row['id_report'],
                $row['libelle'],
                $row['piece_jointe'],
                $row['date_report'],
                isset($row['note']) ? $row['note'] : null,
                isset($row['date_note']) ? $row['date_note'] : null,
                isset($row['commentaire']) ? $row['commentaire'] : null,
                isset($row['statut']) ? $row['statut'] : 0,
                $row['id_client']
            );
        }
        return null;
    }

    public function saveReport($id_client)
    {
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

    public static function getReportByIdClient($id_client)
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM report_client WHERE id_client = :id_client ORDER BY date_report DESC");
        $stmt->execute([':id_client' => $id_client]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $reports = [];
        foreach ($rows as $row) {
            $reports[] = new Report(
                $row['id_report'],
                $row['libelle'],
                $row['piece_jointe'],
                $row['date_report'],
                isset($row['note']) ? $row['note'] : null,
                isset($row['date_note']) ? $row['date_note'] : null,
                isset($row['commentaire']) ? $row['commentaire'] : null,
                isset($row['statut']) ? $row['statut'] : 0,
                $row['id_client'] // Ajout ici
            );
        }
        return $reports;
    }
}
