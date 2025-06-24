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

    public function listAgents() {
        $data = [
            'title' => 'Liste des agents',
            'page' => 'list-agent',
            'agents' => Agent::getAll()
        ];
        Flight::render('templatedev', $data);
    }

    public function fichePaie($idAgent) {
        // Simulation des données d'un agent
        $agent = [
            'id' => $idAgent,
            'nom' => 'Dupont Jean'
        ];
    
        // Simulation des tickets
        $tickets = [
            [
                'id_ticket' => 'TK001',
                'sujet' => 'Développement interface login',
                'cout_horaire' => 45.00,
                'duree' => 8,
            ],
            [
                'id_ticket' => 'TK002',
                'sujet' => 'Correction bug authentification',
                'cout_horaire' => 45.00,
                'duree' => 4,
            ],
            [
                'id_ticket' => 'TK003',
                'sujet' => 'Mise à jour base données',
                'cout_horaire' => 50.00,
                'duree' => 6,
            ]
        ];
    
        $data = [
            'title' => 'Fiche de paie',
            'page' => 'fiche-paie',
            'nom' => 'Dupont Jean',
            'agent' => (object)$agent,
            'tickets' => $tickets
        ];
    
        Flight::render('templatedev', $data);
    }

    
   
    

  
 
}