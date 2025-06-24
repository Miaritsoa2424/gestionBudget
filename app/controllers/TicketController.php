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

use app\models\Statut;
use app\models\TicketImportance;

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
            'etats' => Statut::getAll(),
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
            'importance' => Importance::getAll(),
            'categories' => CategorieTicket::getAll(),
            'id_report' => $data['id_report'],
            'attachments' => [
                ['name' => $clients['piece_jointe'], 'url' => '#']
            ]
        ];
    
        // Champs manquants
        if (
            empty($data['sujet']) ||
            empty($data['id_categorie']) ||
            empty($data['id_importance']) ||
            empty($data['id_report'])
        ) {
            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'error' => 'Champs requis manquants.'
            ];
            Flight::render('templatedev', $donnees);
            return;
        }
    
        if (Report::checkReportTicketer($data['id_report'])) {
            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'error' => 'Ce rapport a déjà un ticket.'
            ];
            Flight::render('templatedev', $donnees);
            return;
        }
    
        $ticketModel = new Ticket();
        $idTicket = $ticketModel->insertTicket(
            null,
            $data['sujet'],
            $data['id_categorie'],
            $data['id_report']
        );
    
        if ($idTicket > 0) {
            // Insertion dans ticket_importance
            $importance = new TicketImportance(null, $idTicket, $data['id_importance']);
            $importance->save();
    
            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'success' => 'Ticket inséré avec succès.'
            ];
            Flight::render('templatedev', $donnees);
        } else {
            $donnees = [
                'title' => 'Détail du Report',
                'page' => 'form-ticket',
                'demoReport' => $demoReport,
                'error' => 'Erreur lors de l\'insertion du ticket.'
            ];
            Flight::render('templatedev', $donnees);
        }
    }
    
          
    //////////////Controller pour les tickets des clients vaovao
    public function getTickets(){
        $tickets = TicketModel::getAll();

        $ticket2d = [];
        foreach ($tickets as $ticket) {
            $ticket1D = [
                'id' => $ticket->getId(),
                'sujet' => $ticket->getSujet(),
                'categorie' => $ticket->getIdCategorie(),
                'libelle' => Report::getReportById($ticket->getIdReport())->getLibelle(),
                'client' => Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient()),
                'date' => $ticket->getDateCreation(),
                'priorite' => "haute", // Assuming a static value for priority
                'statut' => Statut::getById($ticket->getIdStatut())->getLibelle(),
                'duree' => MvtDuree::getLastDureeByIdTicket($ticket->getId())->getDuree() ?? 0
            ];
            $ticket2d[] = $ticket1D;
        }

        $data = [
            'title' => 'Liste des Tickets',
            'page' => 'affiliation-agent',
            'tickets' => $ticket2d,
            'categories' => CategorieTicket::getAll(),
        ];
        Flight::render('templatedev', $data);
    }

    public function affilierTicket($id) {
        $ticket = TicketModel::getById($id);
        $client = Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient());

        if (!$ticket) {
            Flight::redirect('/tickets');
            return;
        }

        $data = [
            'title' => 'Affiliation Agent',
            'page' => 'affiliation-agent',
            'client' => $client,
            'ticket' => $ticket,
            'agents' => Agent::getAll()
        ];
        Flight::render('templatedev', $data);
    }
}
