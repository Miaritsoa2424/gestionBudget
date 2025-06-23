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
        Flight::render('templatedev', ['page' => 'testElyance', 'title' => 'Accueil']);
    }
    public function message() {
        $data = [
            'title' => 'Message',
            'page' => 'message'
        ];
        Flight::render('template-agent', $data);
    }

    public function listMessages() {
        $data = [
            'title' => 'Liste des messages',
            'page' => 'list-message',
            'messages' => [
                ['id' => 1, 'content' => 'Message 1', 'date' => '2023-10-01'],
                ['id' => 2, 'content' => 'Message 2', 'date' => '2023-10-02']
            ]
        ];
        Flight::render('template-agent', $data);
    }
    

  
 
}