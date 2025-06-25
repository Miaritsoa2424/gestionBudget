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
use app\models\Crm;
use app\models\Valeur;
use app\models\CategorieTicket;
use app\models\MvtDuree;
use app\models\Solde;
use Flight;
use app\models\Statistique;
use app\models\StatutTicket;

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
    
        $clients = Client::getClientReportDetail($data['id_report']);
    
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
            Report::reportToLu($data['id_report']);

            StatutTicket::create($idTicket,1);
    
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
            $statutObj = Statut::getById($ticket->getIdStatut());
            $statut = $statutObj ? $statutObj->getNom() : "Non affilié";

            $dureeObj = MvtDuree::getLastDureeByIdTicket($ticket->getId());
            $duree = $dureeObj ? $dureeObj->getDuree() : "";

            $prioriteObj = Importance::getImportanceByIdTicket($ticket->getId());
            $priorite = $prioriteObj ? $prioriteObj->getNom() : "";

            $ticket1D = [
                'id' => $ticket->getId(),
                'sujet' => $ticket->getSujet(),
                'categorie' => CategorieTicket::getCategorieById($ticket->getIdCategorie())->getNom(),
                'libelle' => Report::getReportById($ticket->getIdReport())->getLibelle(),
                'client' => Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient()),
                'date' => $ticket->getDateCreation(),
                'priorite' => $priorite,
                'statut' => $statut,
                'duree' => $duree
            ];
            $ticket2d[] = $ticket1D;
        }

        $data = [
            'title' => 'Liste des Tickets',
            'page' => 'affiliation-agent',
            'tickets' => $ticket2d,
            'categories' => CategorieTicket::getAll(),
            'priorites' => Importance::getAll(),
            'statuts' => Statut::getAll()
        ];
        Flight::render('templatedev', $data);
    }
    public function getTicketsAgent(){
        $tickets = TicketModel::getAllTicketAgent($_SESSION['id_agent']);

        $ticket2d = [];
        foreach ($tickets as $ticket) {
            $statutObj = Statut::getById($ticket->getIdStatut());
            $statut = $statutObj ? $statutObj->getNom() : "";

            $dureeObj = MvtDuree::getLastDureeByIdTicket($ticket->getId());
            $duree = $dureeObj ? $dureeObj->getDuree() : "";

            $prioriteObj = Importance::getImportanceByIdTicket($ticket->getId());
            $priorite = $prioriteObj ? $prioriteObj->getNom() : "";

            $ticket1D = [
                'id' => $ticket->getId(),
                'sujet' => $ticket->getSujet(),
                'categorie' => CategorieTicket::getCategorieById($ticket->getIdCategorie())->getNom(),
                'libelle' => Report::getReportById($ticket->getIdReport())->getLibelle(),
                'client' => Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient()),
                'date' => $ticket->getDateCreation(),
                'priorite' => $priorite,
                'statut' => $statut,
                'duree' => $duree
            ];
            $ticket2d[] = $ticket1D;
        }

        $data = [
            'title' => 'Mes Tickets',
            'page' => 'tickets-agent',
            'tickets' => $ticket2d,
            'categories' => CategorieTicket::getAll(),
            'priorites' => Importance::getAll(),
            'statuts' => Statut::getAll()
        ];
        Flight::render('template-agent', $data);
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
            'page' => 'affiliation-ticket',
            'client' => $client,
            'ticket' => $ticket,
            'nomCategorie' => CategorieTicket::getCategorieById($ticket->getIdCategorie())->getNom(),
            'description' => Report::getReportById($ticket->getIdReport())->getLibelle(),
            'categories' => CategorieTicket::getAll(),
            'priorites' => Importance::getAll(),
            'agents' => Agent::getAgentDispo()
        ];
        Flight::render('templatedev', $data);
    }


    public function doAffiliation() {
        $data = Flight::request()->data;

        // Vérification des champs requis
        if (empty($data['agent_id']) || empty($data['duree']) || empty($data['cout_horaire'])) {
            // Affichage du formulaire avec message d'erreur
            $ticket = TicketModel::getById($data['ticket_id']);
            $client = $ticket ? Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient()) : null;
            $dataRender = [
                'title' => 'Affiliation Agent',
                'page' => 'affiliation-ticket',
                'client' => $client,
                'ticket' => $ticket,
                'nomCategorie' => $ticket ? CategorieTicket::getCategorieById($ticket->getIdCategorie())->getNom() : '',
                'description' => $ticket ? Report::getReportById($ticket->getIdReport())->getLibelle() : '',
                'categories' => CategorieTicket::getAll(),
                'priorites' => Importance::getAll(),
                'agents' => Agent::getAgentDispo(),
                'errorMessage' => 'Champs requis manquants.'
            ];
            Flight::render('templatedev', $dataRender);
            return;
        }


        // Récupération du ticket
        $ticket = TicketModel::getById($data['ticket_id']);
        if (!$ticket) {
            $dataRender = [
                'title' => 'Affiliation Agent',
                'page' => 'affiliation-ticket',
                'errorMessage' => 'Ticket non trouvé.',
                'categories' => CategorieTicket::getAll(),
                'priorites' => Importance::getAll(),
                'agents' => Agent::getAgentDispo()
            ];
            Flight::render('templatedev', $dataRender);
            return;
        }

        $coutHoraire = $data['cout_horaire'];
        $ticket->setCoutHoraire($coutHoraire);

        // Création du mouvement de durée
        $mvtDuree = new MvtDuree(null, $data['duree'], date('Y-m-d H:i:s'), $ticket->getId());
        $mvtDuree->save();

        // Mise à jour du statut du ticket
        $ticket->setIdStatut(2);
        $ticket->setIdAgent($data['agent_id']);
        
        if ($ticket->update()) {
            $ticket = TicketModel::getById($data['ticket_id']);
            $client = Client::getClientById(Report::getReportById($ticket->getIdReport())->getIdClient());

            $dataRender = [
                'title' => 'Affiliation Agent',
                'page' => 'affiliation-ticket',
                'client' => $client,
                'ticket' => $ticket,
                'nomCategorie' => CategorieTicket::getCategorieById($ticket->getIdCategorie())->getNom(),
                'description' => Report::getReportById($ticket->getIdReport())->getLibelle(),
                'categories' => CategorieTicket::getAll(),
                'priorites' => Importance::getAll(),
                'agents' => Agent::getAgentDispo(),
                'successMessage' => 'Ticket affilié avec succès !'
            ];

            $sql = "
                SELECT (mvt.duree*ticket.cout_horaire) as value from ticket 
                JOIN (select duree from  mvt_duree where id_ticket = :idTicket ORDER BY mvt_duree.id_mvt_duree desc limit 1) as mvt
                where ticket.id_ticket = :idTicket2;";
        $stmt = Flight::db()->prepare($sql);
        $stmt->execute([':idTicket' => $data['ticket_id'], ':idTicket2' => $data['ticket_id']]);

        
        $montant = $stmt->fetchColumn();

        $date = date('Y-m-d'); // Date actuelle
        $nomRubrique = 'Satisfaction client';

        // $date = date('Y-m-d H:i:s'); // Date actuelle
        $solde = new Solde();
        $sommeCRM = $solde->getSoldeInitial(6)['montant'] - (float)Crm::getResteTicketsValue(6, $date);
        $validation = 0; // Par défaut, on ne valide pas
            if ($sommeCRM > $montant) {
                $validation = 1;
            }
        
        $valeur = new Valeur(0, $nomRubrique, 8, 1, $montant, $date, $validation, 6);
        $valeur->insert();



            Flight::render('templatedev', $dataRender);
        } else {
            $dataRender = [
                'title' => 'Affiliation Agent',
                'page' => 'affiliation-ticket',
                'client' => $client ?? null,
                'ticket' => $ticket ?? null,
                'categories' => CategorieTicket::getAll(),
                'priorites' => Importance::getAll(),
                'agents' => Agent::getAgentDispo(),
                'errorMessage' => 'Erreur lors de l\'affiliation du ticket.'
            ];
            Flight::render('templatedev', $dataRender);}
        }

    public function updateTicketDuration() {
        $data = Flight::request()->data;
        $idTicket = $data['id_ticket'] ?? null;
        $duree = $data['duree'] ?? null;

        if (!$idTicket || !$duree) {
            Flight::json(['error' => 'ID du ticket ou durée manquante.'], 400);
            return;
        }

        $date = date('Y-m-d H:i:s'); // Date actuelle
        $mvtDuree = new MvtDuree(null, $duree, $date, $idTicket);
        if ($mvtDuree->save()) {
            $_SESSION['success_message'] = 'Durée mise à jour avec succès.';
            Flight::redirect('/admin');
        } else {
            $_SESSION['error_message'] = 'Erreur lors de la mise à jour de la durée.';
            Flight::redirect('/admin');

        }
    }
}
