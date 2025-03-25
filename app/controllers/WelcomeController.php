<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class WelcomeController {

	public function __construct() {

	}

	public function test() {
        $texte = "Bienvenue sur notre site de gestion de budget";
        $data = ['page' => 'accueil','text' => $texte];
        Flight::render('test', $data);
    }

    public function home() {
        Flight::render('template', []);
    }

  
 
}