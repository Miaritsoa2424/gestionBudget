<?php

namespace app\controllers;

use Flight;

class ClientController {

	public function __construct() {

	}

    public function listClientFront() {
        
        Flight::render('templatedev', [
            'title' => 'Liste des Clients',
            'page' => 'list-client',
        ]);
    }

  
 
}