<?php

use app\controllers\ReportController;
use app\controllers\FormController;
use app\controllers\ValeurController;
use app\controllers\ValidationController;
use app\controllers\WelcomeController;
use app\controllers\BudgetController;
use app\controllers\PdfController;
use app\controllers\ClientController;

use flight\Engine;
use flight\net\Router;
use app\controllers\DepartementController;
use app\controllers\StatistiqueController;
use app\controllers\ModifDeptController;
use app\controllers\TicketController;
use app\controllers\AgentController;

/** 
 * @var Router $router 
 * @var Engine $app
 */
$valeurController = new ValeurController();

$StatController = new StatistiqueController();
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


Flight::route('/chart', function () use ($StatController) {
    $StatController->showDashboard();
});

Flight::route('/api/ventes-par-mois', function () use ($StatController) {
    $StatController->getSalesByMonthJson();
});

$modifDeptController = new ModifDeptController();
Flight::route('/departement', function () use ($modifDeptController) {
    $modifDeptController->getPageDepartement();
});

$router->post('/departement/modifier', function () use ($modifDeptController) {
    $modifDeptController->modifierDepartement();
});

$router->get('/departement/supprimer/@id:[0-9]+', function ($id) use ($modifDeptController) {
    $modifDeptController->supprimerDepartement($id);
});
$ticketController = new TicketController();

// $router->get('/ticket', [$ticketController, 'getTemplateTicket']);
$router->get('/formTicket', [$ticketController, 'getFormTicket']);
$router->post('/insertTicket', [$ticketController, 'insertTicket']);
$router->get('/ticketDept', [$ticketController, 'getAllTicketsByIdDept']);
$router->get('/listeTicket', [$ticketController, 'getAllTickets']);
$router->get('/ticketStats', [$ticketController, 'ticketStats']);
$router->get('/ticketStats/data', [$ticketController, 'getData']);

// New controller de Miaritsoa
$ticketController = new TicketController();
$router->get('/ticket', [$ticketController, 'getTickets']);

$welcomeController = new WelcomeController();
$router->get('/welcome', [$welcomeController, 'home']);

$AgentController = new AgentController();

$ClientController = new ClientController();
$router->get('/list-client', [$ClientController, 'listClientFront']);
$router->get('/detail-client', [$ClientController, 'clientDetail']);
$router->get('/detail-report/@id', [$ClientController, 'clientReportDetail']);

$router->get('/report-client', [$ClientController, 'getFormulaireReportClient']);
$router->get('/home', [$ClientController, 'getHomeCLient']);
$router->post('/client-login', [$ClientController, 'clientLogin']);

$router->get('/message', [$AgentController, 'message']);
$router->get('/messageClient', [$ClientController, 'messageClient']);

$router->get('/listMessages', [$AgentController, 'listMessages']);
$router->post('/send-message', [$AgentController, 'sendMessage']);
$router->post('/end-discussion', [$AgentController, 'endDiscussion']);
$router->post('/send-message-client', [$ClientController, 'sendMessageClient']);

$ReportController = new ReportController();
$router->post('/submit-report', [$ReportController, 'insertReport']);
$router->get('/affilierTicket/@id', [$welcomeController, 'affilierTicket']);


$router->get('/homeClient', [$welcomeController, 'homeClient']);
$router->get('/listMessagesClient', [$ClientController, 'listMessagesClient']);
$router->get('/messageClient/@id', [$ClientController, 'messageClient']);

$router->get('/stat-admin', [$welcomeController, 'statAdmin']);
$router->get('/list-agents', [$welcomeController, 'listAgents']);
$router->get('/fiche-paie/@id_agent', [$welcomeController, 'fichePaie']);







