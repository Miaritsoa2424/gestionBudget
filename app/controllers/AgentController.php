<?php

namespace app\controllers;

use app\models\Agent;
use app\models\Client;
use app\models\Message;
use Flight;

class AgentController {

	public function __construct() {

	}

    public function deconnexion() {
        session_destroy();
        Flight::redirect('login');
    }

    // public function listMessages() {
            
    public function listMessages() {
        // Supposons que l'id de l'agent est stocké en session
        $id_agent = $_SESSION['id_agent'] ?? 1;
        if (!$id_agent) {
            Flight::redirect('login');
            return;
        }

        // Récupérer les clients ayant échangé avec cet agent
        $db = \Flight::db();
        // $sql = "SELECT DISTINCT c.id_client, c.nom, c.prenom, c.email
        //         FROM message m
        //         JOIN client c ON (m.id_envoyeur = c.id_client OR m.id_receveur = c.id_client)
        //         WHERE (m.id_envoyeur = 1 OR m.id_receveur = 1)
        //         AND m.client_agent = 1";

        $sql ="SELECT DISTINCT c.id_client, c.nom, c.prenom, c.email 
            FROM ticket t
            JOIN report_client rc on rc.id_report = t.id_report
            JOIN client c ON c.id_client = rc.id_client
            JOIN agent a ON a.id_agent = t.id_agent
            -- JOIN message m ON m.id_envoyeur = t.id_agent
            WHERE a.id_agent = 1
        ";

        $stmt = $db->prepare($sql);
        // $stmt->execute([':id_agent' => $id_agent]);
        $stmt->execute();
        $clients = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Tu peux aussi récupérer le dernier message pour chaque client ici si besoin

        Flight::render('template-agent', [
            'title' => 'Liste des messages',
            'page' => 'list-message',
            'clients' => $clients
        ]);
    }

    public function formLoginAgent()
    {
        Flight::render('login-agent');
    }


    public function loginAgent() {
        $nom = Flight::request()->data->nom;
        $mdp = Flight::request()->data->mdp;
        // echo $nom;
        // echo $mdp;

        $agent = Agent::getByNom($nom);

        if ($agent && ($mdp == $agent->getPassword())) {
            // Authentification réussie
            $_SESSION['id_client'] = $agent->getIdAgent();
            $_SESSION['nom_client'] = $agent->getNom();

            Flight::redirect('list-ticket-agent');
        } else {
            // Authentification échouée
            Flight::render('login-agent', ['error' => 'Identifiants incorrects']);
        }
    }

    
    public function message() {
        $id_client = $_GET['client_id'] ?? null;
        if (!$id_client) {
            Flight::redirect('list-messages');
            return;
        }

        // Tu peux charger ici les infos du client, les messages, etc.
        $client = Client::getById($id_client);
        $messages = Message::getMessageByAgentClient($_SESSION['id_agent'], $id_client, 1);
        // $messages = Message::getMessageByAgentClient(1, $id_client);

        Flight::render('template-agent', [
            'title' => 'Message',
            'page' => 'message',
            'client' => $client,
            'messages' => $messages
        ]);
    }
    
    public function sendMessage() {
        $id_agent = $_SESSION['id_agent'] ?? 1;
        $id_client = $_POST['id_client'] ?? null;
        $contenu = $_POST['contenu'] ?? '';
        if ($id_client && $contenu !== '') {
            $db = \Flight::db();
            $stmt = $db->prepare("INSERT INTO message (id_envoyeur, id_receveur, client_agent, date_heure, contenu) VALUES (:id_agent, :id_client, 1, NOW(), :contenu)");
            $stmt->execute([
                ':id_agent' => $id_agent,
                ':id_client' => $id_client,
                ':contenu' => $contenu
            ]);
            Flight::json(['success' => true]);
        } else {
            Flight::json(['success' => false]);
        }
    }
    
    public function endDiscussion() {
        $id_client = $_POST['id_client'] ?? null;
        // $id_agent = $_SESSION['id_agent'] ?? null;
        $id_agent = $_SESSION['id_agent'] ?? 1;
        if ($id_client && $id_agent) {
            $db = \Flight::db();
            $stmt = $db->prepare(
                "UPDATE message SET discu_termine = 1 
                WHERE (id_envoyeur = :id_client AND id_receveur = :id_agent) OR (id_envoyeur = :id_agent AND id_receveur = :id_client)");
            $stmt->execute([
                ':id_client' => $id_client,
                ':id_agent' => $id_agent,
                ':id_agent' => $id_agent,
                ':id_client' => $id_client
            ]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
}
 