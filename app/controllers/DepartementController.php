<?php

namespace app\controllers;

use app\models\Departement;
use Flight;

class DepartementController
{
    public function getFormulaireLogin()
    {
        Flight::render('login');
    }

    public function getAccueil()
    {
        Flight::render('accueil');
    }

    public function doLogin()
    {
        $dept = Departement::login(Flight::request()->data->nomDept, Flight::request()->data->mdp);
        if ($dept) {
            $_SESSION['idDept'] = $dept->getIdDept();
            Flight::render('template');
        } else {
            Flight::render('login', ['erreur' => 'Nom d\'utilisateur ou mot de passe incorrect']);
        }
    }

    public function deconnexion(){
        session_destroy();
        Flight::clear('idDept');
        Flight::render('login', []);
        
    }
}
