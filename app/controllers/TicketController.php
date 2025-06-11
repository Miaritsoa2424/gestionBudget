<?php 
namespace app\controllers;

use Flight;
use app\models\Statistique;

class TicketController {
    public function getTemplateTicket() {
        Flight::render('template', ['page' => 'templateTicket']);
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



    public function getData() {
        $etat = Flight::request()->query['etat'] ?? null;
        $dept = Flight::request()->query['dept'] ?? null;
        $annee = Flight::request()->query['annee'] ?? date('Y');

        $data = Statistique::getTicketParMois($etat, $dept, $annee);
        Flight::json($data);
    }
}
