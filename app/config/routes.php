<?php

use app\controllers\FormController;
use app\controllers\ValeurController;
use app\controllers\ValidationController;
use app\controllers\WelcomeController;
use app\controllers\BudgetController;
use app\controllers\PdfController;

use flight\Engine;
use flight\net\Router;
use app\controllers\DepartementController;

/** 
 * @var Router $router 
 * @var Engine $app
 */
$valeurController = new ValeurController();
// $router->post('/valeur/savePrevision', [$valeurController, 'savePrevision']);
$router->post('/saveRealisation', [$valeurController, 'saveRealisation']);
$router->post('/savePrevision', [$valeurController, 'savePrevision']);

// $Welcome_Controller = new WelcomeController();
// $router->get('/', [$Welcome_Controller, 'home']);

$departementController = new DepartementController();
$router->get('/', [$departementController, 'getFormulaireLogin']);
$router->post('/doLogin', [$departementController, 'doLogin']);

$router->post('/importer', [$valeurController, 'doImportCSV']);

$FormController = new FormController();
$router->get('/login', [$FormController, 'login']);

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
