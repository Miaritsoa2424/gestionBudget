<?php
namespace app\controllers;

use app\models\Client;
use app\models\Importance;
use app\models\Etat;
use app\models\Demande;
use app\models\Departement;
use app\models\TypeDemande;
use app\models\Ticket;
use app\models\Report;
use app\models\Agent;
use app\models\CategorieTicket;
use app\models\MvtDuree;
use Flight;
use app\models\Statistique;
use app\models\TicketModel;

class TicketController {
    public function getTemplateTicket() {
        Flight::render('template', ['page' => 'templateTicket']);
    }

    public function getAllTicketsByIdDept() {
        if (!isset($_SESSION['idDept'])) {
            Flight::redirect('/login');
        }
        $ticketModel = new Ticket();
        $clients = $ticketModel->getAllClients();
        $types = $ticketModel->getAllTypes();
        $importances = $ticketModel->getAllImportances();
        $etats = $ticketModel->getAllEtats();
        $idDept = $_SESSION['idDept'];
        $tickets = Flight::Ticket()->getAllTicketsByIdDept($idDept);
        Flight::render('template', [
            'page' => 'templateTicket',
            'pageContent' => 'ticketDept',
            'tickets' => $tickets,
            'clients' => $clients,
            'types' => $types,
            'importances' => $importances,
            'etats' => $etats
        ]);
    }

    
    public function ticketStats() {
        $statistiqueModel = new Statistique(Flight::db());
        $departements = $statistiqueModel->getDepartements();
        $etats = $statistiqueModel->getEtats();
        $data = [
            'page' => 'templateTicket',
            'pageContent' => 'ticketStats',
            'departements' => $departements,
            'etats' => $etats
          ];
        Flight::render('template', $data);
    }
  
   public function getFormTicket() {
        $data = [
            'page' => 'templateTicket',
            'pageContent' => 'ticketForm',
            'importances' => Importance::getAll(),
            'etats' => Etat::getAll(),
            'demandes' => Demande::getAll(),
            'departements' => Departement::getAllDepartement(),
            'typeDemandes' => TypeDemande::getAll()
        ];
        Flight::render('template', $data);
    }

    public function getData() {
        $etat = Flight::request()->query['etat'] ?? null;
        $dept = Flight::request()->query['dept'] ?? null;
        $annee = Flight::request()->query['annee'] ?? date('Y');

        $data = Statistique::getTicketParMois($etat, $dept, $annee);
        Flight::json($data);
    }

    public function getAgentTicket() {
        // Récupération des paramètres de tri depuis la requête (GET ou POST)
        $id_agent = Flight::request()->query['id_agent'] ?? null;
        $status = Flight::request()->query['status'] ?? null;

        // Vérification de la présence de l'id_agent
        if (empty($id_agent)) {
            Flight::json(['error' => 'id_agent manquant.'], 400);
            return;
        }

        $ticketModel = new Ticket();
        $tickets = $ticketModel->getTicketByAgent($id_agent, $status);

        // Tu peux ajouter d'autres données à passer au template si besoin
        Flight::render('template', [
            'page' => 'templateTicket',
            'tickets' => $tickets
        ]);
    }


    public function insertTicket() {
        $data = Flight::request()->data;

        $clients = Client::getClientReportDetail(1);

        $demoReport = [
            'client' => [
                'nom' => $clients['nom'],
                'prenom' => $clients['prenom'],
                'email' => $clients['email']
            ],
            'date' => $clients['date_report'],
            'statut' => 'Créé',
            'message' => $clients['libelle'],
            'attachments' => [
                ['name' => $clients['piece_jointe'], 'url' => '#']
            ]
        ];
        // Vérification des champs requis
        if (
            empty($data['cout_horaire']) ||
            empty($data['sujet']) 
            // empty($data['id_categorie']) ||
            // empty($data['id_agent']) 
            // ||
            // empty($data['id_report'])
        ) {
            Flight::json(['error' => 'Champs manquants.'], 400);
            return;
        }

        $ticketModel = new Ticket();
        $idTicket = $ticketModel->insertTicket(
            $data['cout_horaire'],
            $data['sujet'],
            1,
            // $data['id_categorie'],
            1
            // $data['id_report']
        );

        if ($idTicket > 0) {

            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'success' => 'Ticket inséré avec succès.'
            ];
            Flight::render('templatedev', $donnees);

            // Flight::json(['success' => true, 'id_ticket' => $idTicket]);
        } else {

            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'error' => 'Erreur lors de l\'insertion du ticket.'
            ];
            Flight::render('templatedev', $donnees);

            // Flight::json(['error' => 'Erreur lors de l\'insertion'], 500);
        }
    }
      
    //////////////Controller pour les tickets des clients vaovao
    public function getTickets(){
        $tickets = TicketModel::getAll();

        $ticket2d = [];
        foreach ($tickets as $ticket) {
            $ticket = [
                'id' => $ticket->getId(),
                'sujet' => $ticket->getSujet(),
                'categorie' => $ticket->getIdCategorie(),
                'libelle' => Report::getReportById($ticket->getIdReport())->getLibelle(),
                'client' => Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient()),
                'date' => $ticket->getDateCreation(),
                'priorite' => "haute", // Assuming a static value for priority
                'etat' => Etat::findById($ticket->getIdEtat())->getNom(),
                'duree' => MvtDuree::getDureeByIdTicket($ticket->getId())['duree'] ?? '0'
            ];
            $ticket2d[] = $ticket;
        }

        $data = [
            'title' => 'Liste des Tickets',
            'page' => 'affiliation-agent',
            'tickets' => $ticket2d,
            'categories' => CategorieTicket::getAll(),
        ];
        Flight::render('templatedev', $data);
    }
}
