<?php

namespace app\controllers;

use app\models\Client;
use app\models\Message;
use Flight;

class AgentController {

	public function __construct() {

	}

    // public function message() {
    //     $data = [
    //         'title' => 'Message',
    //         'page' => 'message'
    //     ];
    //     Flight::render('template-agent', $data);
    // }

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
        $sql = "SELECT DISTINCT c.id_client, c.nom, c.prenom, c.email
                FROM message m
                JOIN client c ON (m.id_envoyeur = c.id_client OR m.id_receveur = c.id_client)
                WHERE (m.id_envoyeur = 1 OR m.id_receveur = 1)
                AND m.client_agent = 1";
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
    
    public function message() {
        $id_client = $_GET['client_id'] ?? null;
        if (!$id_client) {
            Flight::redirect('list-messages');
            return;
        }

        // Tu peux charger ici les infos du client, les messages, etc.
        $client = Client::getById($id_client);
        // $messages = Message::getMessageByAgentClient($_SESSION['id_agent'], $id_client, 1);
        $messages = Message::getMessageByAgentClient(1, $id_client, 1);

        Flight::render('template-agent', [
            'title' => 'Message',
            'page' => 'message',
            'client' => $client,
            'messages' => $messages
        ]);
    }
    
 
}