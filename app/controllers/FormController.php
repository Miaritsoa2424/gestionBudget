<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\Departement;
use app\models\Crm;
use Flight;

class FormController {

	public function __construct() {

	}

	public function login() {
        Flight::render('loginEmp', []);
    }

	public function crm() {
		$depts = Departement::getAllDept($_SESSION['idDept']);
		$crms = Crm::getAllCrm();
		Flight::render('template', ['page' => 'crm', 'crms' => $crms, 'depts' => $depts]);
	}

  
 
}