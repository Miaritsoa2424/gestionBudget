<?php

namespace app\controllers;

use app\models\Statistique;
use Flight;

class StatistiqueController {

    public function dashboard() {
        $stat = new Statistique(Flight::db());

       $mois = isset($_GET['mois']) && $_GET['mois'] !== '' ? (int)$_GET['mois'] : date('m');
       $annee = isset($_GET['annee']) && $_GET['annee'] !== '' ? (int)$_GET['annee'] : date('Y');



        $topClients = $stat->getTopClientsByTickets($mois, $annee);
        $satisfactionByAgent = $stat->getSatisfactionByAgent($mois, $annee);
        $timeByCategory = $stat->getTimeByCategory($mois, $annee);
        
        
        $budget = $stat->getBudgetPrevisionnel($mois, $annee);

        Flight::render('templatedev', [
            'title' => 'Statistiques Administrateur',
            'page' => 'stat-admin',
            'topClients' => $topClients,
            'satisfactionByAgent' => $satisfactionByAgent,
            'timeByCategory' => $timeByCategory,
            'budget' => $budget
        ]);
    }

    public static function showDashboard() {
        $statistiqueModel = new Statistique(Flight::db());
        // Récupération de l'année (paramètre optionnel)
        $year = Flight::request()->query->year ?? date('Y');
        // $year = 2025;
        // Récupérer les données de vente par mois
        $salesByMonth = $statistiqueModel->getSalesByMonth($year);
        
        // Préparer les données pour le graphique
        $months = [];
        $sales = [];
        
        foreach ($salesByMonth as $data) {
            // Convertir le numéro du mois en nom du mois en français
            $monthNum = $data['mois'];
            $dateObj = \DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // Nom du mois en anglais
            
            // Traduction des mois en français
            $frenchMonths = [
                'January' => 'Jan.',
                'February' => 'Fév.',
                'March' => 'Mars',
                'April' => 'Avr.',
                'May' => 'Mai',
                'June' => 'Juin',
                'July' => 'Juil.',
                'August' => 'Août',
                'September' => 'Sept.',
                'October' => 'Oct.',
                'November' => 'Nov.',
                'December' => 'Déc.'
            ];
            
            $months[] = $frenchMonths[$monthName];
            $sales[] = $data['total_ventes'];
        }
        
        // Récupérer les autres données statistiques
        $bestProducts = $statistiqueModel->getBestProduct();
        $topCustomers = $statistiqueModel->getTopCustomers();
        $chiffreAffaire = $statistiqueModel->getChiffreAffaire($year);
        
        // Passer les données à la vue
        Flight::render('template', [
            'page' => 'chart',
            'months' => json_encode($months),
            'sales' => json_encode($sales),
            'year' => $year,
            'bestProducts' => $bestProducts,
            'topCustomers' => $topCustomers,
            'chiffreAffaire' => $chiffreAffaire
        ]);
    }
    
    public function getSalesByMonthJson() {
        $statistiqueModel = new Statistique(Flight::db());
        $year = Flight::request()->query->year ?? date('Y');
        $salesByMonth = $statistiqueModel->getSalesByMonth($year);
        
        Flight::json($salesByMonth);
    }



}