
<?php

use app\controllers\FormController;
use app\controllers\WelcomeController;

use flight\Engine;
use flight\net\Router;
use app\controllers\DepartementController;

/** 
 * @var Router $router 
 * @var Engine $app
 */


$Welcome_Controller = new WelcomeController();
$router->get('/', [$Welcome_Controller, 'home']);

$router->group('/departement', function (Router $router) {
    $departementController = new DepartementController();
    $router->get('/', [$departementController, 'getFormulaireLogin']);
    $router->post('/doLogin', [$departementController, 'doLogin']);
});

$FormController = new FormController();
$router->get('/login',[$FormController,'login']);





