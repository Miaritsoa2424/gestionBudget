
<?php

use app\controllers\FormController;
use app\controllers\ValidationController;
use app\controllers\WelcomeController;
use app\controllers\BudgetController;

use flight\Engine;
use flight\net\Router;
use app\controllers\DepartementController;
use app\controllers\ValeurController;

/** 
 * @var Router $router 
 * @var Engine $app
 */
$valeurController = new ValeurController();

$Welcome_Controller = new WelcomeController();
$router->get('/', [$Welcome_Controller, 'home']);

$router->group('/departement', function (Router $router) {
    $departementController = new DepartementController();
    $router->get('/', [$departementController, 'getFormulaireLogin']);
    $router->post('/doLogin', [$departementController, 'doLogin']);
});

$router->post('/importer', [$valeurController, 'doImportCSV']);

$FormController = new FormController();
$router->get('/login',[$FormController,'login']);

$validationController = new ValidationController();
$router->get('/validation',[$validationController,'getListValidation']);

$BudgetController = new BudgetController();
$router->get('/budget',[$BudgetController,'getBudget']);





