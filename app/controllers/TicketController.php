<?php 
namespace app\controllers;

use Flight;

class TicketController {
    public function getTemplateTicket() {
        Flight::render('template', ['page' => 'templateTicket']);
    }
}
