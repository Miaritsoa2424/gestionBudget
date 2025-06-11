<?php 
namespace app\controllers;

use app\models\Importance;
use app\models\Etat;
use app\models\Demande;
use app\models\Departement;
use app\models\TypeDemande;

use Flight;

class TicketController {
    public function getTemplateTicket() {
        Flight::render('template', ['page' => 'templateTicket']);
    }

    public function getFormTicket() {
        $data = [
            'page' => 'ticketForm',
            'pageContent' => 'ticketForm',
            'importances' => Importance::getAll(),
            'etats' => Etat::getAll(),
            'demandes' => Demande::getAll(),
            'departements' => Departement::getAllDepartement(),
            'typeDemandes' => TypeDemande::getAll()
        ];
        Flight::render('template', $data);
    }

    public function insertTicket() {
        $data = Flight::request()->data;

        $ticket = new Ticket(
            $data->idDemande,
            $data->idImportance,
            $data->idTypeDemande,
            $data->idEtat,
            $data->idDept,
            $data->dateDebut,
            $data->dateFin
        );

        try {
            $ticket->save();
            Flight::redirect('/ticket');
        } catch (\Exception $e) {
            Flight::render('template', [
                'page' => 'ticketForm',
                'erreur' => 'Erreur lors de la création du ticket: ' . $e->getMessage()
            ]);
        }
    }
}
