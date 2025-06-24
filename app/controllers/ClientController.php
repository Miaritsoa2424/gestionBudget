<?php

namespace app\controllers;


use app\models\Client;
use app\models\Agent;
use Flight;

class ClientController {

	public function __construct() {

	}
   public function getFormulaireLogin()
    {
        Flight::render('login');
    }

    public function getAccueil()
    {
        Flight::render('accueil');
    }

    public function getClientById()
    {
        $data = Client::getAll();
        Flight::render('template', ['clients' => $data]);     
    }

    public function deconnexion(){
        session_destroy();
        Flight::clear('idDept');
        Flight::render('login', []);   
    }
    public function listClientFront() {
        $data = [
            'title' => 'Liste des Clients',
            'page' => 'list-client',
            'clients' => Client::getAll()
        ];
    
        Flight::render('templatedev', $data);
    }
    public function clientDetail(){
        $data = [
            'title' => 'Détail du client',
            'page' => 'report-client-admin',
            'client' => [
                'nom' => 'Client 1',
                'email' => 'jhdgf@mail.com',
                'telephone' => '0341234567',
                'date_inscription' => '2023-10-01',
                'reports' => [
                    [
                        'id' => 1,
                        'date' => '2023-10-01',
                        'statut' => 'en_cours',
                        'message' => 'Problème avec le service de livraison.'
                    ],
                    [
                        'id' => 2,
                        'date' => '2023-10-02',
                        'statut' => 'valide',
                        'message' => 'Demande de remboursement traitée avec succès.'
                    ],
                    [
                        'id' => 3,
                        'date' => '2023-10-03',
                        'statut' => 'refuse',
                        'message' => 'Réclamation injustifiée selon nos vérifications.'
                    ]
                ]
            ]
        ];
        Flight::render('templatedev', $data);
    }

    public function clientReportDetail($id){
       // Données statiques de démonstration
        $data = Client::getClientReportDetail(1);
        $agents = Agent::getAll();

        $demoReport = [
            'client' => [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email']
            ],
            'date' => $data['date_report'],
            'statut' => 'Créé',
            'message' => $data['libelle'],
            'attachments' => [
                ['name' => $data['piece_jointe'], 'url' => '#']
            ]
        ];
        $donnees = [
            'title' => 'Détail du Report',
            'page' => 'form-ticket',
            'demoReport' => $demoReport,
            'agents' => $agents
        ];
        Flight::render('templatedev', $donnees);
    }

    public function getFormulaireReportClient()
    {
        $data = [
            'title' => 'Formulaire de Report Client',
            'page' => 'report-client'
        ];
        Flight::render('templateClient', $data);
    }
    public function getHomeCLient() {
        $data = [
            'title' => 'Espace Client'
        ];
        Flight::render('templateClient', $data);
    }
    

    public function clientLogin() {
        $nom = Flight::request()->data->nom;
        $mdp = Flight::request()->data->mdp;

        $client = Client::getByNom($nom);

        if ($client && ($mdp == $client['mdp'])) {
            // Authentification réussie
            $_SESSION['idClient'] = $client['id_client'];
            $_SESSION['nomClient'] = $client['nom'];

            Flight::render('templateClient', ['title' => 'Rapport client', 'page' => 'report-client', 'success' => true]);
        } else {
           
            Flight::render('templateClient', ['title' => 'Rapport client', 'page' => 'report-client', 'error' => true]);
        }
    }
 
}

