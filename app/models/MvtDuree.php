<?php

namespace app\models;

class MvtDuree
{
    private $id;
    private $duree;
    private $dateDuree;
    private $idTicket;

    public function __construct($id = null, $duree = null, $dateDuree = null, $idTicket = null)
    {
        $this->id = $id;
        $this->duree = $duree;
        $this->dateDuree = $dateDuree;
        $this->idTicket = $idTicket;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getDuree() { return $this->duree; }
    public function getDateDuree() { return $this->dateDuree; }
    public function getIdTicket() { return $this->idTicket; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setDuree($duree) { $this->duree = $duree; }
    public function setDateDuree($dateDuree) { $this->dateDuree = $dateDuree; }
    public function setIdTicket($idTicket) { $this->idTicket = $idTicket; }

    // Récupérer tous les mouvements de durée
    public static function getAll()
    {
        $db = \Flight::db();
        $stmt = $db->query("SELECT * FROM mvt_duree");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new MvtDuree(
                $row['id_mvt_duree'],
                $row['duree'],
                $row['date_duree'],
                $row['id_ticket']
            );
        }
        return $list;
    }

    public static function getDureeByIdTicket($idTicket)
    {
        $db = \Flight::db();
        $stmt = $db->prepare("SELECT * FROM mvt_duree WHERE id_ticket = :id_ticket");
        $stmt->execute([':id_ticket' => $idTicket]);
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new MvtDuree(
                $row['id_mvt_duree'],
                $row['duree'],
                $row['date_duree'],
                $row['id_ticket']
            );
        }
        return $list;
    }

    public static function getLastDureeByIdTicket($idTicket)
    {
        $db = \Flight::db();
        $stmt = $db->prepare("SELECT * FROM mvt_duree WHERE id_ticket = :id_ticket ORDER BY date_duree DESC, id_mvt_duree DESC LIMIT 1");
        $stmt->execute([':id_ticket' => $idTicket]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return new MvtDuree(
                $row['id_mvt_duree'],
                $row['duree'],
                $row['date_duree'],
                $row['id_ticket']
            );
        }
        return null;
    }

    public function save()
    {
        $db = \Flight::db();
        // Force current datetime
        $this->dateDuree = date('Y-m-d H:i:s');
        
        if ($this->id === null) {
            // Insert new record
            $stmt = $db->prepare("INSERT INTO mvt_duree (duree, date_duree, id_ticket) VALUES (:duree, :date_duree, :id_ticket)");
            $result = $stmt->execute([
                ':duree' => $this->duree,
                ':date_duree' => $this->dateDuree,
                ':id_ticket' => $this->idTicket
            ]);
            if ($result) {
                $this->id = $db->lastInsertId();
            }
            return $result;
        } else {
            // Update existing record
            $stmt = $db->prepare("UPDATE mvt_duree SET duree = :duree, date_duree = :date_duree, id_ticket = :id_ticket WHERE id_mvt_duree = :id");
            return $stmt->execute([
                ':id' => $this->id,
                ':duree' => $this->duree,
                ':date_duree' => $this->dateDuree,
                ':id_ticket' => $this->idTicket
            ]);
        }
    }
}