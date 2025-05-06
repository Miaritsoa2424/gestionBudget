<?php

namespace app\controllers;

use app\models\Departement;
use app\models\AffichageBudjetPeriode;
use app\models\Type;
use app\models\Solde;
use Flight;

class BudgetController
{
   public function getBudget()
   {
      // Récupérer les données du formulaire
      $dateDeb = Flight::request()->data->dateDeb;
      $dateFin = Flight::request()->data->dateFin;
      $idDept = Flight::request()->data->idDept;
      $intervalle = Flight::request()->data->intervalle;
      $types = Type::getAllType();

      if (!isset($_SESSION['idDept'])) {
         Flight::redirect('/login');
      }

      // Vérifier si toutes les données sont bien remplies
      if (!empty($dateDeb) && !empty($dateFin) && !empty($idDept) && !empty($intervalle)) {

         // Récupérer la liste des départements
         $departements = Departement::getAllDept($_SESSION['idDept']);

         // Générer les débuts de mois entre les dates fournies
         $moisDebuts = AffichageBudjetPeriode::getDebutsDeMois($dateDeb, $dateFin);

         // Initialiser les données des tables
         $tablesData = [];
         // $budgetInitial = Departement::getDepartementById($idDept)->getSoldeInitial()['montant'];
         $soldeModel = new Solde();
         $budgetInitial = $soldeModel->getSolde($_SESSION['idDept'], $dateDeb); // Récupérer le solde initial


         // Pour chaque mois généré, récupérer les données
         foreach ($moisDebuts as $index => $mois) {
            $moisFormat = date('Y-m', strtotime($mois)); // Format du mois (YYYY-MM)

            // Appeler la fonction pour récupérer les données du budget par mois et année
            $budgetData = AffichageBudjetPeriode::getBudgetByMonthYear($idDept, date('m', strtotime($mois)), date('Y', strtotime($mois)));

            // Appeler la fonction pour récupérer les totaux des recettes et dépenses
            $realisationTotal = AffichageBudjetPeriode::getRealisationTotalByMonthYear($idDept, date('m', strtotime($mois)), date('Y', strtotime($mois)));

            // Préparer les données à afficher
            // Ajouter les totaux à chaque mois
            $tablesData[$index] = [
               'mois' => date('F Y', strtotime($mois)), // Format lisible du mois
               'data' => $budgetData,
               'totalRecettes' => $realisationTotal['totalRecettes'],
               'totalDepenses' => $realisationTotal['totalDepenses']
               
           ];
         }

         // Envoi des données à la vue
         $data = ['page' => 'budget', 'tablesData' => $tablesData, 'departements' => $departements,'soldeInitial' => $budgetInitial,'datDeb' => $dateDeb,'dateFin' => $dateFin,'types' => $types];
         Flight::render('template', $data);
         return;
      }

      // Si les données sont incomplètes, on affiche la page sans tableau
      $departements = Departement::getAllDept($_SESSION['idDept']);
      $data = ['page' => 'budget', 'departements' => $departements,'types' => $types];
      Flight::render('template', $data);
   }
}
