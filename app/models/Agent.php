<?php
namespace app\models;
use Flight;

class Agent {
    private $id_agent;
    private $nom;
    private $prenom;
    private $email;
    private $password;

    public function __construct($id_agent = null, $nom = null, $prenom = null, $email = null, $password = null) {
        $this->id_agent = $id_agent;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
    }

    // Getters
    public function getIdAgent() { return $this->id_agent; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }

    // Setters
    public function setIdAgent($id_agent) { $this->id_agent = $id_agent; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }

    // CRUD Methods

    // Create
    public function save() {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO agent (nom, prenom, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->nom, $this->prenom, $this->email, $this->password]);
        $this->id_agent = $conn->lastInsertId();
        return $this->id_agent;
    }

    // Read all
    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM agent");
        $agents = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $agents[] = new Agent($row['id_agent'], $row['nom'], $row['prenom'], $row['email'], $row['password']);
        }
        return $agents;
    }

    // Read one
    public static function getById($id_agent) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM agent WHERE id_agent = :id_agent");
        $stmt->execute([':id_agent' => $id_agent]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return new Agent($row['id_agent'], $row['nom'], $row['prenom'], $row['email'], $row['password']);
        }
        return null;
    }

    public static function getByNom($nom) {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM agent WHERE nom = :nom");
        $stmt->execute([':nom' => $nom]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return new Agent($row['id_agent'], $row['nom'], $row['prenom'], $row['email'], $row['password']);
        }
        return null;
    }


    // Update
    public function update() {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE agent SET nom = ?, prenom = ?, email = ?, password = ? WHERE id_agent = ?");
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->password, $this->id_agent]);
    }

    // Delete
    public static function delete($id_agent) {
        $conn = Flight::db();
        $stmt = $conn->prepare("DELETE FROM agent WHERE id_agent = ?");
        return $stmt->execute([$id_agent]);
    }

    public static function getAgentDispo() {
        // On ne compte que les tickets dont le statut est 3
        $conn = Flight::db();
        // $stmt = $conn->query("
        //     SELECT a.id_agent, a.nom, a.prenom, COUNT(t.id_ticket) AS nb_tickets
        //     FROM agent a
        //     LEFT JOIN ticket t ON a.id_agent = t.id_agent AND t.id_statut != 2
        //     GROUP BY a.id_agent
        //     HAVING nb_tickets < (
        //         SELECT AVG(nb_tickets) FROM (
        //             SELECT COUNT(id_ticket) AS nb_tickets 
        //             FROM ticket 
        //             WHERE id_statut != 2
        //             GROUP BY id_agent
        //         ) AS sub
        //     )
        //     ORDER BY nb_tickets ASC
        // ");
        $stmt = $conn->query("
            SELECT a.id_agent, a.nom, a.prenom, a.email
            FROM agent a
            LEFT JOIN ticket t ON a.id_agent = t.id_agent
            WHERE (t.id_ticket IS NULL) OR (t.id_statut != 2)
        ");
        $agents = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $agents[] = new Agent($row['id_agent'], $row['nom'], $row['prenom']);
        }
        return $agents;
    }

    public static function getTicketsByAgent($id_agent) {
        $db = Flight::db();
        $sql = "
            SELECT 
                t.id_ticket,
                t.sujet,
                t.cout_horaire,
                IFNULL(SUM(md.duree), 0) AS duree
            FROM ticket t
            LEFT JOIN mvt_duree md ON md.id_ticket = t.id_ticket
            WHERE t.id_agent = :id_agent
            GROUP BY t.id_ticket, t.sujet, t.cout_horaire
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id_agent' => $id_agent]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}