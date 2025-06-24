<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Agent;
use Flight;

class WelcomeController {

	public function __construct() {

	}

	public function test() {
        $texte = "Bienvenue sur notre site de gestion de budget";
        $data = ['page' => 'accueil','text' => $texte];
        Flight::render('test', $data);
    }

    public function home() {
        Flight::render('templatedev', ['page' => 'testElyance', 'title' => 'Accueil']);
    }
    public function message() {
        $data = [
            'title' => 'Message',
            'page' => 'message'
        ];
        Flight::render('template-agent', $data);
    }

    public function listMessages() {
        $data = [
            'title' => 'Liste des messages',
            'page' => 'list-message',
            'messages' => [
                ['id' => 1, 'content' => 'Message 1', 'date' => '2023-10-01'],
                ['id' => 2, 'content' => 'Message 2', 'date' => '2023-10-02']
            ]
        ];
        Flight::render('template-agent', $data);
    }

    public function affilierTicket($id){
        $data = [
            'title' => 'Affiliation Agent',
            'page' => 'affiliation-ticket'
        ];
        Flight::render('templatedev', $data);
        
    }


    public function homeClient(){
        $agentDispo = Agent::getAll();
        $data = [
            'title' => 'Accueil Client',
            'page' => 'hero-section-client'
        ];
        Flight::render('template-client', $data);
    }

    public function listMessagesClient() {
        $data = [
            'title' => 'Liste des messages',
            'page' => 'list-message-client',
            'messages' => [
                ['id' => 1, 'content' => 'Message 1', 'date' => '2023-10-01'],
                ['id' => 2, 'content' => 'Message 2', 'date' => '2023-10-02']
            ]
        ];
        Flight::render('template-client', $data);
    }

    public function messageClient($id) {
        $data = [
            'title' => 'Message',
            'page' => 'message-client'
        ];
        Flight::render('template-client', $data);
    }

    public function statAdmin() {
        $data = [
            'title' => 'Statistiques Administrateur',
            'page' => 'stat-admin',
            'topClients' => [
                ['name' => 'Client A', 'tickets' => 45],
                ['name' => 'Client B', 'tickets' => 38],
                ['name' => 'Client C', 'tickets' => 32],
                ['name' => 'Client D', 'tickets' => 28],
                ['name' => 'Client E', 'tickets' => 25]
            ]
        ];
        Flight::render('templatedev', $data);
    }

    

    public function fichePaie($idAgent) {
        // Connexion à la base (tu peux remplacer par ton propre accès modèle si tu en as un)
        $db = Flight::db(); // ou ton propre accès DB
    
        // Récupérer les informations de l'agent
        $stmtAgent = $db->prepare("SELECT id_agent AS id, nom, prenom FROM agent WHERE id_agent = ?");
        $stmtAgent->execute([$idAgent]);
        $agent = $stmtAgent->fetch(\PDO::FETCH_ASSOC);
    
        // Récupérer les tickets liés à l’agent (selon ta requête donnée)
        $stmtTickets = $db->prepare("
            SELECT d.id_ticket, ticket.sujet, ticket.cout_horaire, d.duree
            FROM ticket
            JOIN mvt_duree AS d ON ticket.id_ticket = d.id_ticket
            WHERE d.id_agent = ?
            ORDER BY d.id_mvt_duree DESC
            LIMIT 1
        ");
        $stmtTickets->execute([$idAgent]);
        $tickets = $stmtTickets->fetchAll(\PDO::FETCH_ASSOC);
    
        // Préparer les données à envoyer à la vue
        $data = [
            'title' => 'Fiche de paie',
            'page' => 'fiche-paie',
            'nom' => $agent['nom'] . ' ' . $agent['prenom'],
            'agent' => (object) $agent,
            'tickets' => $tickets
        ];
    
        // Affichage
        Flight::render('templatedev', $data);
    }
    

    
   
    

  
 
}