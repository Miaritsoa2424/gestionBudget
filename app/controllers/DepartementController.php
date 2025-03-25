<?php
    namespace app\controllers;
session_start();
use app\models\Departement;
use Flight;
    class DepartementController{
        public function getFormulaireLogin() {
            Flight::render('login');
        }

        public function getAccueil() {
            Flight::render('accueil');
        }

        public function doLogin() {
            $dept = Departement::login(Flight::request()->data->nomDept, Flight::request()->data->mdp);
            if ($dept) {
                $_SESSION['idDept'] = $dept->getIdDept();
                Flight::render('\departement\accueil');
            } else {
                Flight::render('\departement\login', ['erreur' => 'Nom d\'utilisateur ou mot de passe incorrect']);
            }
        }
    }