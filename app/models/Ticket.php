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
        $sql = "SELECT * FROM Vue_TicketsComplets ORDER BY dateDebut DESC";
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
        $sql = "SELECT * FROM Vue_TicketsComplets WHERE idDept = ? ORDER BY dateDebut DESC";
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

     public function getAllClients() {
        $sql = "SELECT idClient, nomClient FROM client ORDER BY nomClient";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTypes() {
        $sql = "SELECT idTypeDemande, nom FROM TypeDemande ORDER BY nom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllImportances() {
        $sql = "SELECT idImportance, nom FROM Importance ORDER BY nom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllDepts() {
        $sql = "SELECT idDept, nomDept FROM Dept ORDER BY nomDept";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllEtats() {
        $sql = "SELECT idEtat, nom FROM Etat ORDER BY nom";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  
    public function addTicket($idDemande, $idImportance, $idTypeDemande, $idEtat, $idDept, $dateFin = null)
    {
        $dateDebut = date('Y-m-d'); // Date actuelle

        $sql = "INSERT INTO Ticket (idDemande, idImportance, idTypeDemande, idEtat, idDept, dateDebut, dateFin)
                VALUES (:idDemande, :idImportance, :idTypeDemande, :idEtat, :idDept, :dateDebut, :dateFin)";
        
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'idDemande' => $idDemande,
            'idImportance' => $idImportance,
            'idTypeDemande' => $idTypeDemande,
            'idEtat' => $idEtat,
            'idDept' => $idDept,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ]);

        if ($result) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }
    
    public function getTicketByAgent($id_agent, $status = null)
    {
        $sql = "SELECT t.*, s.id_status, s.date_status
                FROM ticket t
                LEFT JOIN statut_ticket s ON t.id_ticket = s.id_ticket
                WHERE t.id_agent = :id_agent";
        
        $params = ['id_agent' => $id_agent];

        if ($status !== null) {
            $sql .= " AND s.id_status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY t.id_ticket DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $tickets = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $tickets ?: [];
    }
  

    public function insertTicket($cout_horaire, $sujet, $id_categorie, $id_agent, $id_report) {
        $conn = Flight::db();
        $stmt = $conn->prepare(
            "INSERT INTO ticket (cout_horaire, sujet, id_categorie, id_agent, id_report) VALUES (:cout_horaire, :sujet, :id_categorie, :id_agent, :id_report)"
        );
        $stmt->execute([
            'cout_horaire' => $cout_horaire, 
            ':sujet'=> $sujet, 
            ':id_categorie'=> $id_categorie, 
            ':id_agent'=> $id_agent, 
            ':id_report'=> $id_report
        ]);
        return  1;
    }
}
