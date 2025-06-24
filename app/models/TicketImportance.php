<?php
namespace app\models;
use Flight;
class TicketImportance {
    private $id;
    private $id_ticket;
    private $id_importance;

    public function __construct($id = null, $id_ticket = null, $id_importance = null) {
        $this->id = $id;
        $this->id_ticket = $id_ticket;
        $this->id_importance = $id_importance;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getIdTicket() { return $this->id_ticket; }
    public function getIdImportance() { return $this->id_importance; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setIdTicket($id_ticket) { $this->id_ticket = $id_ticket; }
    public function setIdImportance($id_importance) { $this->id_importance = $id_importance; }

    public function save() {
        $db = Flight::db();
        
        if ($this->id === null) {
            // Insert new record
            $sql = "INSERT INTO ticket_importance (id_ticket, id_importance) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([$this->id_ticket, $this->id_importance]);
            // $params = [$this->id_ticket, $this->id_importance];
            // $stmt->execute($sql, $params);
            if ($result) {
                $this->id = $db->lastInsertId();
                return true;
            }
        } else {
            // Update existing record
            $sql = "UPDATE ticket_importance SET id_ticket = ?, id_importance = ? WHERE id = ?";
            $params = [$this->id_ticket, $this->id_importance, $this->id];
            return $db->execute($sql, $params);
        }
        return false;
    }
}
?>
