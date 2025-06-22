<?php
namespace app\controllers;

use app\models\Importance;
use app\models\Etat;
use app\models\Demande;
use app\models\Departement;
use app\models\TypeDemande;
use app\models\Ticket;

use Flight;
use app\models\Statistique;

class TicketController {
    public function getTemplateTicket() {
        Flight::render('template', ['page' => 'templateTicket']);
    }

    public function getAllTickets() {
        $ticketModel = new Ticket();
        $tickets = $ticketModel->getAllTickets();
        $clients = $ticketModel->getAllClients();
        $types = $ticketModel->getAllTypes();
        $importances = $ticketModel->getAllImportances();
        $depts = $ticketModel->getAllDepts();
        $etats = $ticketModel->getAllEtats();

        Flight::render('template', [
            'page' => 'templateTicket',
            'pageContent' => 'ticketAdmin',
            'tickets' => $tickets,
            'clients' => $clients,
            'types' => $types,
            'importances' => $importances,
            'depts' => $depts,
            'etats' => $etats
        ]);
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
          
    public static function insertTicket()
    {
        $data = Flight::request()->data;

        // Vérification des champs requis
        if (
            empty($data['idDemande']) ||
            empty($data['idImportance']) ||
            empty($data['idTypeDemande']) ||
            empty($data['idEtat']) ||
            empty($data['idDept'])
        ) {
            Flight::json(['error' => 'Champs manquants.'], 400);
            return;
        }

        $ticket = new Ticket();
        $idTicket = $ticket->addTicket(
            $data['idDemande'],
            $data['idImportance'],
            $data['idTypeDemande'],
            $data['idEtat'],
            $data['idDept'],
            $data['dateFin'] ?? null
        );

        if ($idTicket) {
            Flight::redirect('/ticket');
        } else {
            Flight::render('template', [
                'page' => 'templateTicket',
                'pageContent' => 'ticketForm',
                'importances' => Importance::getAll(),
                'etats' => Etat::getAll(),
                'demandes' => Demande::getAll(),
                'departements' => Departement::getAllDepartement(),
                'typeDemandes' => TypeDemande::getAll(),
                'erreur' => 'Erreur lors de la création du ticket'
            ]);
        }
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

    //////////////Controller pour les tickets des clients vaovao
    public function getTickets(){
        $data = [
            'title' => 'Liste des Tickets',
            'page' => 'affiliation-agent',
            'tickets' => [
                [
                    'id' => 1,
                    'sujet' => 'Problème de connexion',
                    'categorie' => 'Technique',
                    'libelle' => 'Impossible de se connecter depuis ce matin. Message d\'erreur 404 persistant.',
                    'client' => 'Jean Dupont',
                    'date' => '2024-01-15',
                    'priorite' => 'haute'
                ],
                [
                    'id' => 2,
                    'sujet' => 'Facturation incorrecte',
                    'categorie' => 'Facturation',
                    'libelle' => 'Le montant de la facture n°F2024-001 ne correspond pas au devis initial.',
                    'client' => 'Marie Martin',
                    'date' => '2024-01-14',
                    'priorite' => 'moyenne'
                ],
                [
                    'id' => 3,
                    'sujet' => 'Demande de devis',
                    'categorie' => 'Commercial',
                    'libelle' => 'Besoin d\'un devis pour l\'installation de 5 nouveaux postes.',
                    'client' => 'Pierre Durant',
                    'date' => '2024-01-13',
                    'priorite' => 'basse'
                ]]
        ];
        Flight::render('templatedev', $data);
    
    }
}
