<?php
namespace app\models;

class Message {
    private $id_message;
    private $id_envoyeur;
    private $id_receveur;
    private $client_agent; // booléen (0 ou 1)
    private $date_heure;

    public function __construct($id_envoyeur, $id_receveur, $client_agent, $date_heure, $id_message = null) {
        $this->id_message = $id_message;
        $this->id_envoyeur = $id_envoyeur;
        $this->id_receveur = $id_receveur;
        $this->client_agent = $client_agent;
        $this->date_heure = $date_heure;
    }

    // Getters
    public function getIdMessage() {
        return $this->id_message;
    }

    public function getIdEnvoyeur() {
        return $this->id_envoyeur;
    }

    public function getIdReceveur() {
        return $this->id_receveur;
    }

    public function getClientAgent() {
        return $this->client_agent;
    }

    public function getDateHeure() {
        return $this->date_heure;
    }

    // Setters
    public function setIdEnvoyeur($id_envoyeur) {
        $this->id_envoyeur = $id_envoyeur;
    }

    public function setIdReceveur($id_receveur) {
        $this->id_receveur = $id_receveur;
    }

    public function setClientAgent($client_agent) {
        $this->client_agent = $client_agent;
    }

    public function setDateHeure($date_heure) {
        $this->date_heure = $date_heure;
    }

    public static function getMessageByAgentClient($id_personne1, $id_personne2, $client_agent) {
        $db = \Flight::db(); 
        $sql = "SELECT * FROM message
                WHERE id_envoyeur = :p1 AND id_receveur = :p2 AND client_agent = :client_agent
                ORDER BY date_heure ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':p1' => $id_personne1,
            ':p2' => $id_personne2,
            ':client_agent' => $client_agent
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function sendNewReportToAdmin($libelle, $piece_jointe = null, $dateReport = null, $note = null, $dateNote = null, $commentaire = null, $id_client = null) {
        if (empty($libelle)) {
            throw new \InvalidArgumentException("Le libellé est obligatoire.");
        }

        $db = \Flight::db();
        $sql = "INSERT INTO report_client (libelle, piece_jointe, date_report, note, date_note, commentaire, id_client)
                VALUES (:libelle, :piece_jointe, :date_report, :note, :date_note, :commentaire, :id_client)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':libelle'      => $libelle,
            ':piece_jointe' => $piece_jointe,
            ':date_report'  => $dateReport,
            ':note'         => $note,
            ':date_note'    => $dateNote,
            ':commentaire'  => $commentaire,
            ':id_client'    => $id_client
        ]);
    }
}   