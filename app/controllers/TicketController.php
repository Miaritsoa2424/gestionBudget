<?php
namespace app\controllers;
use app\models\Ticket;
use Flight;

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
            'pageContent' => 'ticketAdmin',
            'tickets' => $tickets,
            'clients' => $clients,
            'types' => $types,
            'importances' => $importances,
            'etats' => $etats
        ]);
    }
}