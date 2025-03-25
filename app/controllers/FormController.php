<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class FormController {

	public function __construct() {

	}

	public function login() {
        Flight::render('loginEmp', []);
    }

  
 
}