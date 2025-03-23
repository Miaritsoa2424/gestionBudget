<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class WelcomeController {

	public function __construct() {

	}

	public function home() {
        $solde = Flight::Transaction()->getSoldeUser($_SESSION['idUser']);
        $data = ['page' => 'accueil','solde' => $solde];
        Flight::render('template', $data);
    }

  
 
}