<?php

namespace app\models;
use Flight;

class Ticket
{
    private $conn;

    public function __construct()
    {
        $this->conn = Flight::db();
    }

    public function getAllTickets()
    {
        $sql = "SELECT * FROM Vue_TicketsComplets ORDER BY dateCreation DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $tickets = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Vérifier si des tickets ont été trouvés, sinon retourner un tableau vide
        if ($tickets) {
            return $tickets;
        } else {
            return [];  // Tableau vide si aucun ticket n'est trouvé
        }
    }

    public function getAllTicketsByIdDept($idDept)
    {
        $sql = "SELECT * FROM Vue_TicketsComplets WHERE idDept = ? ORDER BY dateCreation DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idDept]);
        $tickets = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Vérifier si des tickets ont été trouvés, sinon retourner un tableau vide
        if ($tickets) {
            return $tickets;
        } else {
            return [];  // Tableau vide si aucun ticket n'est trouvé
        }
    }

  
}
