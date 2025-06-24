<?php

namespace app\controllers;


use app\models\Client;
use app\models\Report;
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
    
    public function clientDetail($id){
        $statuts = [
            [
                'id' => 0,
                'libelle' => "non lu"
            ],
            [
                'id' => 1,
                'libelle' => "lu"
            ]
        ];

        $client = Client::getClientById($id);

        // Récupérer les filtres depuis l'URL
        $dateDebut = $_GET['date_debut'] ?? null;
        $dateFin = $_GET['date_fin'] ?? null;
        $statut = $_GET['statut'] ?? null;

        // Si aucun filtre n'est appliqué, on affiche tous les reports
        $reports = Report::getReportByIdClient($id);

        $repos = [];
        foreach ($reports as $rep) {
            $reportFormated = [];
            $reportFormated['id'] = $rep->getId();
            $reportFormated['date'] = $rep->getDateReport();
            $reportFormated['message'] = $rep->getLibelle();
            $reportFormated['statut'] = $rep->getStatutLibelle();
            $reportFormated['idStatut'] = $rep->getStatut();
            $repos[] = $reportFormated;
        }
        $data = [
            'title' => 'Détail du client',
            'page' => 'report-client-admin',
            'client' => [
                'nom' => $client->getNom(),
                'email' => $client->getEmail(),
                'reports' => $repos,
            ],
            'statuts' => $statuts
        ];
        Flight::render('templatedev', $data);
    }


    public function clientReportDetail($id_report) {
        $report = Report::getReportById($id_report);
        $agents = Agent::getAll();

        $client = Client::getClientById($report->getIdClient());

        $demoReport = [
            'client' => [
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'email' => $client->getEmail()
            ],
            'date' => $report->getDateReport(),
            'statut' => $report->getStatutLibelle(),
            'message' => $report->getLibelle(),
            'attachments' => [
                ['name' => $report->getPieceJointe(), 'url' => '#']
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

