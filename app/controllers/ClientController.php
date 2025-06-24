<?php

namespace app\controllers;


use app\models\Client;
use app\models\Report;
use app\models\Agent;

use app\models\Message;
use app\models\CategorieTicket;
use app\models\Importance;

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
        Flight::clear('id_client');
        Flight::render('login-client', []);   
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
            'importance' => Importance::getAll(),
            'categories' => CategorieTicket::getAll(), 
            'date' => $report->getDateReport(),
            'statut' => $report->getStatutLibelle(),
            'message' => $report->getLibelle(),
            'id_report' => $id_report,
            'attachments' => [
                ['name' => $report->getPieceJointe(), 'url' => $report->getPieceJointe()]
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
        Flight::render('template-client', $data);
    }
    public function getHomeCLient() {
        $data = [
            'title' => 'Espace Client'
        ];
        Flight::render('template-client', $data);
    }

    public function listMessagesClient() {
        // Supposons que l'id du client est stocké en session
        $id_client = $_SESSION['id_client'];
        if (!$id_client) {
            Flight::redirect('login');
            return;
        }

        $db = \Flight::db();
        $sql = "SELECT DISTINCT a.id_agent, a.nom, a.prenom, a.email
                FROM ticket t
                JOIN report_client rc ON rc.id_report = t.id_report
                JOIN agent a ON a.id_agent = t.id_agent
                JOIN client c ON c.id_client = rc.id_client
                WHERE c.id_client = :id_client";
                // -- WHERE c.id_client = :id_client";


        $stmt = $db->prepare($sql);
        $stmt->execute([':id_client' => $id_client]);
        // $stmt->execute();
        $agents = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        Flight::render('template-client', [
            'title' => 'Liste des messages',
            'page' => 'list-message-client',
            'agents' => $agents
        ]);
    }
 
    public function messageClient() {

        $id_agent = $_GET['agent_id'] ?? null;
        // Tu peux charger ici les infos de l'agent, les messages, etc.
        $agent = Agent::getById($id_agent);
        if (!$agent) {
            Flight::redirect('list-messages-client');
            return;
        }

        // $messages = Message::getMessageByAgentClient($_SESSION['idClient'], $id_agent, 1);
        $messages = Message::getMessageByAgentClient(1, $id_agent);

        $data = [
            'title' => 'Message',
            'page' => 'message-client',
            'agent' => $agent,
            'messages' => $messages
        ];
        Flight::render('template-client', $data);
    }

    public function sendMessageClient() {
        $id_agent = $_SESSION['id_client'] ?? 1;
        // $id_agent = $_SESSION['id_client'] ?? 1;
        $id_client = $_POST['id_agent'] ?? null;
        $contenu = $_POST['contenu'] ?? '';
        if ($id_client && $contenu !== '') {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO message (id_envoyeur, id_receveur, client_agent, date_heure, contenu) VALUES (:id_agent, :id_client, 0, NOW(), :contenu)");
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

    public function getFormulaireLoginClient()
    {
        Flight::render('login-client');
    }

    public function loginClient() {
        $nom = Flight::request()->data->nom;
        $mdp = Flight::request()->data->mdp;
        // echo $nom;
        // echo $mdp;

        $client = Client::getByNom($nom);

        if ($client && ($mdp == $client->getPwd())) {
            // Authentification réussie
            $_SESSION['id_client'] = $client->getId();
            $_SESSION['nom_client'] = $client->getNom();

            Flight::redirect('homeClient');
        } else {
            // Authentification échouée
            Flight::render('login-client', ['error' => 'Identifiants incorrects']);
        }
    }

    public function insertClient() {
        // Affiche toutes les données reçues pour vérification
        $data = Flight::request()->data;
        print_r($data); // ou var_dump($data);

        $nom = $data->nom;
        $email = $data->email;
        $password = $data->password;
        $prenom = $data->prenom;
        

        // Création du nouveau client
        $client = new Client(null, $nom, $prenom, $email, $password);
        $client->save();

        // Redirection vers la page de connexion ou une autre page
        Flight::render('templatedev', [
            'title' => 'Inscription réussie',
            'page' => 'list-client',
            'clients' => Client::getAll(),
            'message' => 'Inscription réussie, vous pouvez maintenant vous connecter.'
        ]);
    }

}

