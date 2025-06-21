<?php

namespace app\controllers;

use app\models\Client;
use Flight;

class ClientController
{
    public function getFormulaireLogin()
    {
        Flight::render('login');
    }

    public function getAccueil()
    {
        Flight::render('accueil');
    }

    public function getClientById()
    {
        $data = Client::getAll();
        Flight::render('template', ['clients' => $data]);     
    }

    public function deconnexion(){
        session_destroy();
        Flight::clear('idDept');
        Flight::render('login', []);   
    }

}
