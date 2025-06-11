<?php

use app\controllers\StatController;
use app\controllers\FormController;
use app\controllers\ValeurController;
use app\controllers\ValidationController;
use app\controllers\WelcomeController;
use app\controllers\BudgetController;
use app\controllers\PdfController;

use flight\Engine;
use flight\net\Router;
use app\controllers\DepartementController;
use app\controllers\StatistiqueController;
use app\controllers\ModifDeptController;
use app\controllers\TicketController;

/** 
 * @var Router $router 
 * @var Engine $app
 */
$valeurController = new ValeurController();
// $router->post('/valeur/savePrevision', [$valeurController, 'savePrevision']);
$router->post('/saveRealisation', [$valeurController, 'saveRealisation']);
$router->post('/savePrevision', [$valeurController, 'savePrevision']);
$router->post('/saveCRM', [$valeurController, 'saveCRM']);


$departementController = new DepartementController();
$router->get('/', [$departementController, 'getFormulaireLogin']);
$router->get('/deco', [$departementController, 'deconnexion']);
$router->get('/login', [$departementController, 'getFormulaireLogin']);

$router->post('/doLogin', [$departementController, 'doLogin']);

$router->post('/importer', [$valeurController, 'doImportCSV']);

$router->group('/validation', function (Router $router) {
    $validationController = new ValidationController();
    $router->get('/', [$validationController, 'getListValidation']);
    $router->get('/valider/@id:[0-9]+', [$validationController, 'valider']);
    $router->get('/refuser/@id:[0-9]+', [$validationController, 'refuser']);
});

$BudgetController = new BudgetController();
$router->get('/budget', [$BudgetController, 'getBudget']);
$router->post('/budget', [$BudgetController, 'getBudget']);



$PdfController = new PdfController();
$router->post('/export', [$PdfController, 'exportPDF']);

$router->group('/valeur', function (Router $router) {
    $valeurController = new ValeurController();
    $router->post('/savePrevision', [$valeurController, 'savePrevision']);
    $router->post('/saveRealisation', [$valeurController, 'saveRealisation']);
});


$formController = new FormController();
$router->get('/crm', [$formController, 'crm']);

$StatController = new StatistiqueController();

Flight::route('/chart', function() use ($StatController) {
    $StatController->showDashboard();
});

Flight::route('/api/ventes-par-mois', function() use ($StatController) {
    $StatController->getSalesByMonthJson();
});

$modifDeptController = new ModifDeptController();
Flight::route('/departement', function() use ($modifDeptController) {
    $modifDeptController->getPageDepartement();
});

$router->post('/departement/modifier', function() use ($modifDeptController) {
    $modifDeptController->modifierDepartement();
});

$router->get('/departement/supprimer/@id:[0-9]+', function($id) use ($modifDeptController) {
    $modifDeptController->supprimerDepartement($id);
});

$router->group('/ticket', function (Router $router) {
    $ticketController = new TicketController();
    $router->get('/', [$ticketController, 'getTemplateTicket']);
    $router->get('/insertionTicket', [$ticketController, 'getInsertionTicket']);
    $router->post('/insertionTicket', [$ticketController, 'postInsertionTicket']);
    $router->get('/listeTicket', [$ticketController, 'getListeTicket']);
    $router->get('/statTicket', [$ticketController, 'getStatistique']);
});
