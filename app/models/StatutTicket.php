<?php
namespace app\models;
use Flight;

class StatutTicket {
    private $id_ticket;
    private $id_statut;
    private $date_statut;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getters and Setters
    public function getIdTicket() { return $this->id_ticket; }
    public function getIdStatut() { return $this->id_statut; }
    public function getDateStatut() { return $this->date_statut; }

    public function setIdTicket($id_ticket) { $this->id_ticket = $id_ticket; }
    public function setIdStatut($id_statut) { $this->id_statut = $id_statut; }
    public function setDateStatut($date_statut) { $this->date_statut = $date_statut; }

    // Create new statut ticket
    public static function create($id_ticket, $id_statut) {
        $query = "INSERT INTO statut_ticket (id_ticket, id_statut, date_statut) VALUES (?, ?, now())";
        $stmt = Flight::db()->prepare($query);
        return $stmt->execute([$id_ticket, $id_statut]);
    }

   

    
}
?>
