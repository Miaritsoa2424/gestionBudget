<?php

namespace app\controllers;

use app\models\ProductModel;
use Flight;

class ValidationController {
	public function getListValidation() {
        $data = ['page' => 'validation'];
        Flight::render('template', $data);
    }

  
 
}