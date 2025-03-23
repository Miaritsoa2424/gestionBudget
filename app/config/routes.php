
<?php

use app\controllers\WelcomeController;

use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */


$Welcome_Controller = new WelcomeController();
$router->get('/', [$Welcome_Controller, 'home']);





